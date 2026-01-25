-- Create Database
CREATE DATABASE IF NOT EXISTS halalkeeps;
USE halalkeeps;

-- 1. Unified Users Table (Owners & Customers)
-- Supports login for both roles and stores profile data
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191) NOT NULL,           -- Full Name
    middle_initial VARCHAR(5) NULL,       -- Added for profile accuracy
    last_name VARCHAR(100) NULL,          -- Optional separate storage if needed
    gender VARCHAR(20) NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('owner', 'customer') NOT NULL,
    
    -- Profile / Location Fields
    business_name VARCHAR(191) NULL,      -- NULL for customers
    phone VARCHAR(20) NULL,
    address VARCHAR(255) NULL,            -- Mapped from 'Barangay' for customers
    city VARCHAR(100) NULL,
    province VARCHAR(100) NULL,
    zip_code VARCHAR(10) NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Certifiers Table (Separate Entity)
-- For Certifying Body accounts
CREATE TABLE IF NOT EXISTS certifiers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_name VARCHAR(191) NOT NULL,
    representative_name VARCHAR(100) NOT NULL,
    accreditation_id VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(191) NOT NULL UNIQUE,
    phone VARCHAR(20) NULL,
    password_hash VARCHAR(255) NOT NULL,
    office_address TEXT NULL,
    city VARCHAR(100) NULL,
    province VARCHAR(100) NULL,
    status ENUM('pending', 'active', 'suspended') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Halal Certification Applications
-- Links to Users (Owner) via email or could be updated to user_id
CREATE TABLE IF NOT EXISTS halal_certification_applications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    applicant_name VARCHAR(100) NOT NULL,
    company_name VARCHAR(191) NOT NULL,
    business_address TEXT NOT NULL,
    mailing_address TEXT,
    ownership_type ENUM('sole_proprietorship', 'partnership', 'corporation', 'cooperative') NOT NULL,
    contact_person VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(191) NOT NULL,          -- Used to link back to users table
    
    -- Application Details
    application_type ENUM('initial', 'renewal', 'scope_extension') NOT NULL,
    certification_type ENUM('product', 'establishment', 'abattoir') NOT NULL,
    
    -- Schedule & Agreement
    halal_seminar_date DATE NULL,
    first_audit_date DATE NULL,
    final_audit_date DATE NULL,
    undertaking_agreement TINYINT(1) NOT NULL DEFAULT 0,
    signature VARCHAR(100) NOT NULL,
    application_date DATE NOT NULL,
    
    -- Status & Blockchain
    status ENUM('Pending', 'Under Review', 'Inspection Scheduled', 'Approved', 'Rejected') DEFAULT 'Pending',
    blockchain_tx VARCHAR(255) NULL,      -- For storing Polygon transaction hash
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. Application Documents
-- Stores file paths and audit status per document
CREATE TABLE IF NOT EXISTS application_documents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id INT UNSIGNED NOT NULL,
    document_type VARCHAR(100) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    
    -- Certifier Review Fields
    status ENUM('pending', 'compliant', 'non_compliant') DEFAULT 'pending',
    remarks TEXT NULL,
    
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES halal_certification_applications(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Application Details (Dynamic Fields)
-- Stores variable data like "Product List" or "Establishment Capacity"
CREATE TABLE IF NOT EXISTS application_details (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id INT UNSIGNED NOT NULL,
    detail_type VARCHAR(50) NOT NULL,
    detail_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES halal_certification_applications(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Customer Reviews
CREATE TABLE IF NOT EXISTS reviews (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id INT UNSIGNED NOT NULL,    -- Links to users.id (the owner)
    reviewer_id INT UNSIGNED NOT NULL,    -- Links to users.id (the customer)
    rating TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    is_anonymous TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (business_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7. Customer Claims (Complaints)
CREATE TABLE IF NOT EXISTS customer_claims (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id INT UNSIGNED NOT NULL,    -- Links to users.id (owner)
    customer_id INT UNSIGNED NULL,        -- Nullable if anonymous claim
    claim_date DATE NOT NULL,
    description TEXT NOT NULL,
    status ENUM('unresolved', 'resolved', 'dismissed') DEFAULT 'unresolved',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    blockchain_tx VARCHAR(255) NULL,      -- Optional verification
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (business_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS certifiers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_name VARCHAR(191) NOT NULL,
    representative_name VARCHAR(100) NOT NULL,
    accreditation_id VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(191) NOT NULL UNIQUE,
    phone VARCHAR(20) NULL,
    password_hash VARCHAR(255) NOT NULL,
    office_address TEXT NULL,
    city VARCHAR(100) NULL,
    province VARCHAR(100) NULL,
    status ENUM('pending', 'active', 'suspended') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create the distinct Auditors table
CREATE TABLE IF NOT EXISTS auditors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- (Optional) If you want to link specific auditors to specific applications later, 
-- you might need an 'auditor_id' column in the 'halal_certification_applications' table,
-- but for now, the logic handles it via the 'inspection_scheduled' status.

-- Indexes for Performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_apps_status ON halal_certification_applications(status);
CREATE INDEX idx_apps_email ON halal_certification_applications(email);