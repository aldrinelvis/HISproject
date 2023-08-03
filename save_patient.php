<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    
    // Generate a reference number (you can customize this)
    $referenceNumber = uniqid();

    // Connect to the database
    $mysqli = new mysqli("localhost", "username", "password", "patient_db");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO patients (name, email, phone, address, reference_number) VALUES ('$name', '$email', '$phone', '$address', '$referenceNumber')";

    if ($mysqli->query($sql) === TRUE) {
        // Close the database connection
        $mysqli->close();

        // Send email to the patient
        $to = $email;
        $subject = "Patient Reference Number";
        $message = "Your patient reference number is: $referenceNumber";
        mail($to, $subject, $message);

        header("Location: success.php");
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}
?>
