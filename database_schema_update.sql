-- Additional tables for Halal Certification Application
-- Run this after creating the basic database

USE halalkeeps;

-- Halal Certification Applications table
CREATE TABLE IF NOT EXISTS halal_certification_applications (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  applicant_name VARCHAR(100) NOT NULL,
  company_name VARCHAR(191) NOT NULL,
  business_address TEXT NOT NULL,
  mailing_address TEXT,
  ownership_type ENUM('sole_proprietorship', 'partnership', 'corporation', 'cooperative') NOT NULL,
  contact_person VARCHAR(100) NOT NULL,
  telephone VARCHAR(20) NOT NULL,
  email VARCHAR(191) NOT NULL,
  application_type ENUM('initial', 'renewal', 'scope_extension') NOT NULL,
  certification_type ENUM('product', 'establishment', 'abattoir') NOT NULL,
  halal_seminar_date DATE NOT NULL,
  first_audit_date DATE NOT NULL,
  final_audit_date DATE NOT NULL,
  undertaking_agreement TINYINT(1) NOT NULL DEFAULT 0,
  signature VARCHAR(100) NOT NULL,
  application_date DATE NOT NULL,
  status ENUM('pending', 'under_review', 'approved', 'rejected', 'in_progress') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Application Documents table
CREATE TABLE IF NOT EXISTS application_documents (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  application_id INT UNSIGNED NOT NULL,
  document_type VARCHAR(100) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (application_id) REFERENCES halal_certification_applications(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Application Details (for specific certification types)
CREATE TABLE IF NOT EXISTS application_details (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  application_id INT UNSIGNED NOT NULL,
  detail_type VARCHAR(50) NOT NULL,
  detail_value TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (application_id) REFERENCES halal_certification_applications(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Indexes for better performance
CREATE INDEX idx_applications_status ON halal_certification_applications(status);
CREATE INDEX idx_applications_email ON halal_certification_applications(email);
CREATE INDEX idx_applications_created_at ON halal_certification_applications(created_at);
CREATE INDEX idx_documents_application_id ON application_documents(application_id);
CREATE INDEX idx_details_application_id ON application_details(application_id);
