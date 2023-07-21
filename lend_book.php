<?php
    // Function to insert lending details into the lending table
function lendBook($studentID,  $studentName, $bookID, $bookName) {
    require 'conn.php';
  
    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
  
    // Get the current date
    $lendDate = date('Y-m-d');
  
    // Prepare the SQL statement to insert the data into the lending table
    $sql = "INSERT INTO lending (Lend_date, Student_ID, Student_Name, Book_ID, Book_Name) VALUES (?, ?, ?, ?, ?)";
  
    // Prepare the statement
    $stmt = mysqli_stmt_init($conn);
  
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sssss", $lendDate, $studentID, $studentName, $bookID, $bookName);
  
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            return true; // Lending details inserted successfully
        } else {
            return false; // Failed to insert lending details
        }
    } else {
        return false; // SQL Error
    }
  }
  // Check if the form is submitted for lending book
  if (isset($_POST['lend_book'])) {
    // Get the values from the form
    $bookID = $_POST['bid'];
    $bookName = $_POST['bname'];
    $studentID = $_POST['stuid'];
    $studentName = $_POST['fname'];
  
    // Call the function to insert lending details into the lending table
    $result = lendBook($studentID,  $studentName, $bookID, $bookName);
  
    if ($result) {
        echo "Book lending successful!";
    } else {
        echo "Failed to lend the book. Please try again.";
    }
  }
?>