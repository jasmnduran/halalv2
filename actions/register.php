<?php 
include '../includes/db.php'; 
$first_name = $_POST['first_name'];
$middle_initial = $_POST['middle_initial'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$email = $_POST['email']; 
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
$stmt = $conn->prepare("INSERT INTO business_owners (first_name, middle_initial, last_name, age, gender, barangay, city, province, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
$stmt->bind_param("sssissssss", $first_name, $middle_initial, $last_name, $age, $gender, $barangay, $city, $province, $email, $password); 
if ($stmt->execute()) { 
    header('Location: ../login_owner.php');
    exit;
} else { 
    echo "Error: " . $stmt->error; 
} 
?> 



<?php 
include '../includes/db.php'; 

// 1. Capture all input
$first_name = $_POST['first_name'];
$middle_initial = $_POST['middle_initial'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$email = $_POST['email']; 
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

// Prepare derived variables
$name = trim($first_name . ' ' . $middle_initial . ' ' . $last_name);
$role = 'owner';

// 2. Start Transaction (Ensures both inserts happen, or neither happens)
$conn->begin_transaction();

try {
    // --- STEP A: Insert into 'users' table ---
    $stmt1 = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $name, $email, $password, $role);
    
    if (!$stmt1->execute()) {
        throw new Exception("Error inserting user: " . $stmt1->error);
    }
    
    // Get the ID of the user we just created
    $new_user_id = $conn->insert_id;
    $stmt1->close();

    // --- STEP B: Insert into 'business_owners' table ---
    // Note: I added 'user_id' as the first column here. 
    // Make sure your database table has this column!
    $stmt2 = $conn->prepare("INSERT INTO business_owners (user_id, first_name, middle_initial, last_name, age, gender, barangay, city, province) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind params: 'i' for integer (user_id), 's' for strings, 'i' for age
    // Adjust types if age is string in your DB (e.g., "isssissss")
    $stmt2->bind_param("isssissss", $new_user_id, $first_name, $middle_initial, $last_name, $age, $gender, $barangay, $city, $province);

    if (!$stmt2->execute()) {
        throw new Exception("Error inserting owner details: " . $stmt2->error);
    }
    $stmt2->close();

    // --- STEP C: Commit Transaction ---
    // If we got here, both inserts worked!
    $conn->commit();

    header('Location: ../login_owner.php');
    exit;

} catch (Exception $e) {
    // If anything went wrong, undo changes (Rollback)
    $conn->rollback();
    echo "Registration failed: " . $e->getMessage();
}

$conn->close();
?>
