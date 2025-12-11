<?php
include 'db.php'; // connect to database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['floatingName'];
    $email    = $_POST['floatingEmail'];
    $password = password_hash($_POST['floatingPassword'], PASSWORD_DEFAULT);
    $address  = $_POST['floatingTextarea'];
    $city     = $_POST['floatingCity'];
    $state    = $_POST['floatingSelect'];
    $zip      = $_POST['floatingZip'];

    $sql = "INSERT INTO patients (name, email, password, address, city, state, zip)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $password, $address, $city, $state, $zip);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
