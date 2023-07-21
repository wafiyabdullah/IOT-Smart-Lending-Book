<?php
    
// Function to handle the delete button click event
if (isset($_POST['delete_record']) && $_POST['delete_record'] === "1") {
    // Get the student ID from the AJAX request
    $studentID = $_POST['stuid'];

    require 'conn.php';

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to delete the record from the lending table based on the student ID
    $sql = "DELETE FROM lending WHERE Student_ID = ?";

    // Prepare the statement
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind the student ID parameter
        mysqli_stmt_bind_param($stmt, "s", $studentID);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Check if the delete operation was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Success message after deletion
            echo 'Book with Student ID ' . $studentID . ' has been return successfully.';
        } else {
            // Error message if the record was not found or couldn't be deleted
            echo 'Book with Student ID ' . $studentID . ' not found or there are error.';
        }
    } else {
        // SQL Error
        echo 'SQL Error';
    }
}
?>