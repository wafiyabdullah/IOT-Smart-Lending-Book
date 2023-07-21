<?php 
  // Connect to database
    include 'conn.php';
    
?>
<!DOCTYPE html>
<html>
<head>
  <title>Perpustakaan SMK Sri Mahligai</title>
  
  <style>
    html{
      height: 100%;
    }
    body {
      margin: 0;
      padding: 0;
      min-height: 100%;
      display: flex;
      flex-direction: column;
      font-family: Arial, sans-serif;
      background-image: linear-gradient( 109.6deg,  rgba(254,253,205,1) 11.2%, rgba(163,230,255,1) 91.1% );
      background-repeat: no-repeat;
    }

    .tab-container {
      display: flex;
      height: 94.84vh;
    }

    .tab-links {
      width: 200px;
      background-color: #f1f1f1;
    }

    .tab-link {
      display: block;
      width: 100%;
      padding: 30px;
      border: none;
      background-color: inherit;
      text-align: left;
      cursor: pointer;
    }

    .tab-link:hover {
      background-color: #ddd;
    }

    .tab-link.active {
      background-color: #ccc;
    }

    .tab-content {
      flex-grow: 1;
      padding: 20px;
    }

    .tab {
      display: none;
    }

    .tab.active {
      display: block;
    }

    table,th,td{
      border: 1px solid black;
      border-collapse: collapse;
    }
		 .table-all {
		 	margin-left: auto;
		  margin-right: auto;
			font-size: 16px;
			min-width: 400px;
			color: black;
			text-align: center;
		 }
		 .table-all td a{
		 	text-decoration: none;
		 	color: #FA101D;
		 	font-family: monospace;
		 }
		 .table-all th, .table-all td{
			padding: 12px 15px;
		}
     .main h2{
      	color: #373737;
      	font-size: 23px;
      	text-align: center;
      	
      }
      .table-all {
       margin: 30px;
			 margin-left: auto;
		   margin-right: auto;
       min-width: 400px;
			 font-size: 16px;
			 color: black;
			 float: center;
		}
    .table-all th, .table-all td{
			padding: 12px 15px;
		}
    .greet {
    text-align: center;
    margin-bottom: 5%;
  }
  
  
  .form-container {
    display: flex;
    justify-content: center;
  }
  
  /* Wrap the forms within another container for additional spacing */
  .form-wrap {
    display: flex;
  }
  
  /* Style for Form 1 */
  .form1 {
    flex: 1;
    margin-right: 5%; /* Add some spacing between forms */
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
    background-color: #f9f9f9;
  }
  
  
  
  .form1 input[type="text"] {
    width: 80%;
    padding: 5px;
    margin-bottom: 10px;
  }
  
  /* Style for Form 2 */
  .form2 {
    flex: 1;
    margin-left: 5%; /* Add some spacing between forms */
    border: 1px solid #ddd;
    padding: 15px;
    box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
    background-color: #f9f9f9;
  }
  
  .form2 label {
    color: #333;
  }
  
  .form2 input[type="text"] {
    width: 80%;
    padding: 8px;
    margin-bottom: 12px;
  }

  /* Style for Form 3 */

  .form3 {
    flex: 1;
    border: 1px solid #ddd;
    padding: 15px;
    box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
    background-color: #f9f9f9;
  }
  
  .form3 label {
    color: #333;
  }
  
  .form3 input[type="text"] {
    width: 80%;
    padding: 8px;
    margin-bottom: 12px;
  }
  
  form {
    max-width: 400px;
    border-radius: 5%;
  }

  .button button[type=submit]{
  text-align: center;
  background-color: #f1f1f1;
  padding: 13px;
  width: 200px;
  cursor: pointer;
  }

  footer {
  overflow: hidden;
  background-color: #ccc;
  text-align: center;
  margin-top: auto;
  }

  .container {
  max-width: 960px;
  margin: 0 auto;
  }

    </style>
</head>
<body>

        <!left tab bar->
  <div class="tab-container">
    <div class="tab-links">
      <button class="tab-link active" onclick="openTab(event, 'tab1')">LENDING BOOK</button>
      <button class="tab-link" onclick="openTab(event, 'tab2')">RETURN BOOK</button>
    </div>

    <div class="tab-content">
     <!-------------------------- Lending book -------------------------------------->  
     <div id="tab1" class="tab active">
         <div class="greet">
             <h2>Welcome to Perpustakaan SMK Sri Mahligai</h2>
             <h4>The place where students can borrow their favorite book</h4> 
         </div>
         <div class="form-container">
             <form class="form1">
                 <h2>Book Information</h2>
                 <label for="bname">Book Name:</label><br>
                 <input type="text" id="bname" name="bname" value="<?php echo getBookNameFromCardUID(); ?>" ><br>
                 <label for="bid">Book Id:</label><br>
                 <input type="text" id="bid" name="bid" value="<?php echo getRecentCardUID(); ?>" ><br>
                 <p style="color:red; font-size:small">Please place your book above the RFID scanner and then click "update."</p>
             </form>
             <form class="form2" method="post" action="">
                <h2>Student Information</h2>
                <label for="stuid">Student ID:</label><br>
                <input type="text" id="stuid" name="stuid" required><br>
                <label for="fname">Full name:</label><br>
                <input type="text" id="fname" name="fname" readonly><br>
                
                <input type="submit" name="submit" value="Check">
                <input type="reset" value="Clear">
                <br><br>
                <button type="button" onclick="lendBookFunction()">Lending Book</button>
            </form>
         </div>
         <div class="greet">
          <br><br>
             <button type="button" onclick="refreshBookID()">Update</button><br><br><br>
             <p style="color:red; font-size:small">Disclaimer: Please stand in front of the machine. The green light blink indicates that you are ready to borrow a book. </p>
         </div>
        
     </div>
  
       <!------------------------------Return Book--------------------------------->
      <div id="tab2" class="tab">
      <div class="greet">
        <h2>Welcome to Perpustakaan SMK Sri Mahligai </h2>
        <h4>Book Return</h4>
    </div>
    <div class="form-container">
          <form class="form3">
            <h2>Return Book Detail</h2>
            <label for="stuidReturn">Student Id:</label><br>
            <input type="text" id="stuidReturn" name="stuidReturn">
            <p style="color:red; font-size:small">Ensure that you place the book above the RFID scanner for its return.</p>
            <button type="button" onclick="returnBookFunction()">Get Lending Details</button>
          </form>

        <!-- Display the lending details here -->
        <div id="lendingDetails" class="table-all" style="display: none;">
          <h2>Lending Details</h2>
          <table>
            <tr>
              <th>Lend Date</th>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Book ID</th>
              <th>Book Name</th>
            </tr>
            <!-- PHP code to display lending details goes here -->
          </table>
        </div>
        </div>
        
      </div>
      </div>
       
      
    </div>
  
  <footer>
  <div class="container">
    <p>&copy; 2023 Perpustakaan SMK Sri Mahligai</p>
  </div>
    </footer>


  <script> //script for left tab bar in admin Dashboard panel

        function openTab(evt, tabId) {
      // Get all elements with class "tab" and hide them
      var tabs = document.getElementsByClassName("tab");
      for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
      }

      // Remove the "active" class from all tab links
      var tabLinks = document.getElementsByClassName("tab-link");
      for (var i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
      }

      // Show the selected tab and add the "active" class to the corresponding tab link
      document.getElementById(tabId).style.display = "block";
      evt.currentTarget.classList.add("active");
    }

    // Set the first tab as active by default
    document.getElementsByClassName("tab-link")[0].click();

    // JavaScript function to refresh the page
    function refreshBookID() {
          location.reload();
      }
      
      // Function to handle the form submission for lending the book
      function lendBookFunction() {
        // Get the values from the form
        var bookID = document.getElementById("bid").value;
        var bookName = document.getElementById("bname").value;
        var studentID = document.getElementById("stuid").value;
        var studentName = document.getElementById("fname").value;

        // Perform some basic client-side validation 
        if (bookID === "" || bookName === "" || studentID === "" || studentName === "") {
          alert("Please fill in all fields.");
          return;
        }

        // Call the PHP script to handle the form submission and lend the book
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Request successful, show the result
              alert(xhr.responseText);

              // Clear all form inputs after successful lending
              document.getElementById("bid").value = "";
              document.getElementById("bname").value = "";
              document.getElementById("stuid").value = "";
              document.getElementById("fname").value = "";

            } else {
              // Request failed
              alert("Failed to lend the book. Please try again.");
            }
          }
        };
        xhr.open("POST", "lend_book.php", true); 
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("lend_book=1&bid=" + encodeURIComponent(bookID) + "&bname=" + encodeURIComponent(bookName) + "&stuid=" + encodeURIComponent(studentID) + "&fname=" + encodeURIComponent(studentName));
      }

      // Function to handle the form submission for returning the book
      function returnBookFunction() {
        // Get the student ID from the form
        var studentID = document.getElementById("stuidReturn").value;

        // Perform some basic client-side validation 
        if (studentID === "") {
          alert("Please enter a Student ID.");
          return;
        }

        // Call the PHP script to handle the form submission and get the lending details
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Request successful, display the lending details
              document.getElementById("lendingDetails").innerHTML = xhr.responseText;
              document.getElementById("lendingDetails").style.display = "block";
            } else {
              // Request failed
              alert("Failed to get lending details. Please try again.");
            }
          }
        };
        xhr.open("POST", "get_lending_details.php", true); 
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("return_book=1&stuid=" + encodeURIComponent(studentID));
      }

      // Function to handle the delete button click event
      function deleteRecord(studentID) {
        // Call the PHP script to handle the delete operation
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Request successful, show the result
              alert(xhr.responseText);
              // Refresh the lending details after successful deletion
              returnBookFunction(); 
            } else {
              // Request failed
              alert("Failed to delete the record. Please try again.");
            }
          }
        };
        xhr.open("POST", "delete_record.php", true); 
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("delete_record=1&stuid=" + encodeURIComponent(studentID));
      }

    </script>
</body>
</html>

<?php
function getRecentCardUID() {
  
    require 'conn.php';

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to get the most recent card_uid from the devices table
    $sql = "SELECT card_uid FROM devices ORDER BY id DESC LIMIT 1";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and if there is any data
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['card_uid'];
    } else {
        return "No recent card found";
    }
}

function getBookNameFromCardUID() {
   
    require 'conn.php';

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the card_uid from the most recent record in the devices table
    $card_uid = getRecentCardUID();

    // Query to get the Book_Name from the book table based on the card_uid
    $sql = "SELECT Book_Name FROM book WHERE BOOK_UID = ?";

    // Prepare the statement
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind the card_uid parameter
        mysqli_stmt_bind_param($stmt, "s", $card_uid);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if the query was successful and if there is any data
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['Book_Name'];
        } else {
            return "Book Not Found";
        }
    } else {
        return "SQL Error";
    }
}

// Function to get Student ID based on Full Name
function getStudentIDFromFullName($stuid) {
  
  require 'conn.php';

  // Check if the connection is successful
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Query to get Student_ID from the student table based on the Full Name
  $sql = "SELECT Student_Name FROM student WHERE Student_ID = ?";

  // Prepare the statement
  $stmt = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt, $sql)) {
      // Bind the Student ID parameter
      mysqli_stmt_bind_param($stmt, "s", $stuid);

      // Execute the query
      mysqli_stmt_execute($stmt);

      // Get the result
      $result = mysqli_stmt_get_result($stmt);

      // Check if the query was successful and if there is any data
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          return $row['Student_Name'];
      } else {
          return "Student Not Found";
      }
  } else {
      return "SQL Error";
  }
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
  // Get the Student ID from the form
  $stuid = $_POST['stuid'];

  // Get Student ID based on Full Name
  $studentName = getStudentIDFromFullName($stuid);

  // Display Student ID in the form
  echo '<script>';
  echo 'document.getElementById("fname").value = "' . $studentName . '";';
  echo 'document.getElementById("stuid").value = "' . $stuid . '";';
  echo '</script>';
}

?>

