<?php
if (isset($_POST['return_book']) && $_POST['return_book'] === "1") {
    // Get the student ID from the AJAX request
    $studentID = $_POST['stuid'];

    require 'conn.php';

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to get lending details based on the student ID
    $sql = "SELECT Lend_date, Student_ID, Student_Name, Book_ID, Book_Name FROM lending WHERE Student_ID = ?";

    // Prepare the statement
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind the student ID parameter
        mysqli_stmt_bind_param($stmt, "s", $studentID);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if the query was successful and if there is any data
        if ($result && mysqli_num_rows($result) > 0) {
            // Output the lending details as an HTML table with a delete button
            echo '<table>';
            echo '<p style="color:red; font-size:small">Please be advised that if you return the book 7 days late, you will be unable to borrow any additional books for a duration of 3 days.</p>';
            echo '<tr><th>Lend Date</th><th>Student ID</th><th>Student Name</th><th>Book ID</th><th>Book Name</th><th>Action</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['Lend_date'] . '</td>';
                echo '<td>' . $row['Student_ID'] . '</td>';
                echo '<td>' . $row['Student_Name'] . '</td>';
                echo '<td>' . $row['Book_ID'] . '</td>';
                echo '<td>' . $row['Book_Name'] . '</td>';
                echo '<td><button onclick="deleteRecord(\'' . $row['Student_ID'] . '\')">Return</button></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            // No lending details found for the provided student ID
            echo 'No lending details found for Student ID: ' . $studentID;
        }
    } else {
        // SQL Error
        echo 'SQL Error';
    }
}

?> 


