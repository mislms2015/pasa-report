<?php
date_default_timezone_set('Asia/Manila');

// Create connection
$conn = new mysqli('localhost', 'root', '', 'pasa_report');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// this method is to validate filemimes type
function fileMimes() {
    return array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );
}

// this is a specific declaration of filemimes for excel
function fileMimesExcel() {
    return array(
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );
}

function checkHeader() {
    return array('sequence_number', 'transaction_id', 'date_registered', 'primary_min', 'brand', 'mran', 'recipient_min', 'amount', 'date_initiated', 'date_failed', 'date_requested', 'date_debit_confirmed', 'date_credit_confirmed', 'denomination_id', 'pasa_type', 'BRAND', 'STATUS');
}

function truncateTables($conn) {
    $table_list = array('pasa_data', 'pasa_load', 'pasa_promo', 'pasa_points');
    for ($i = 0; $i < count($table_list); $i++) {
        $table = $table_list[$i];
        $query = "TRUNCATE TABLE $table";
        mysqli_query($conn, $query);
    }
}
?>