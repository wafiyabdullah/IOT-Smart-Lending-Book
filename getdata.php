<?php
// Connect to database
require 'conn.php';
date_default_timezone_set('Asia/Kuala_Lumpur');


if (isset($_GET['card_uid']) && isset($_GET['device_token'])) {

    $card_uid = $_GET['card_uid'];
    $device_uid = $_GET['device_token'];

    $sql = "INSERT INTO devices (card_uid, device_uid) VALUES (?, ?)";
    $result = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_INSERT_DATA";
        exit();
    } else {
        mysqli_stmt_bind_param($result, "ss", $card_uid, $device_uid);
        mysqli_stmt_execute($result);

        echo "successful";
        exit();
    }
}
?>
