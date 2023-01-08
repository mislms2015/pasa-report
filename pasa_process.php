<?php
include_once './__utils.php';

$header = checkHeader();

if (isset($_POST['submit'])) {
    // Allowed mime types
    $fileMimes = fileMimes();
    $files = $_FILES['file'];

    if (!empty($files)) {

        for ($i = 0; $i < count($files['name']); $i++) {
            $pasa = array();
            $filename = $files['name'][$i];
            if (in_array($files['type'][$i], $fileMimes)) {
                $err_msg = '';
                $database = '';

                // Open uploaded CSV file with read-only mode
                $csvFile = fopen($files['tmp_name'][$i], 'r');

                // Skip the first line
                $numcols = fgetcsv($csvFile);

                $temp_header = array();
                for ($header_column = 0; $header_column < count($numcols); $header_column++) {
                    array_push($temp_header, $numcols[$header_column]);
                }
                
                $header_compare = array_diff($header,$temp_header);

                if (count($header_compare) > 0) {
                    $err_msg = "<b><i>$filename header not match.</i></b>";
                }
    
                if (count($header_compare) == 0) {
                    // insert filename to table for additional validation
                    $elp_date = mb_substr($filename, 0, 10);

                    if (strpos($filename, 'PASADATA') !== FALSE) $database = 'pasa_data';
                    if (strpos($filename, 'PASALOAD') !== FALSE) $database = 'pasa_load';
                    if (strpos($filename, 'PASAPOINTS') !== FALSE) $database = 'pasa_points';
                    if (strpos($filename, 'PASAPROMO') !== FALSE) $database = 'pasa_promo';

                    // Parse data from CSV file line by line
                    $counter = 0;
                    while (($getData = fgetcsv($csvFile, 100000000, ",")) !== FALSE) {
                        
                        array_push($pasa, array($getData[0],$getData[1],$getData[2],$getData[3],$getData[4],$getData[5],$getData[6],$getData[7],$getData[8],$getData[9],$getData[10],$getData[11],$getData[12],$getData[13],$getData[14],$getData[15],$getData[16]));

                        $counter++;
                    }

                    // Close opened CSV file
                    fclose($csvFile);

                    //insert gigapay raw logs here:start
                    $query = "INSERT INTO $database (sequence_number, transaction_id, date_registered, primary_min, brand_emp, mran, recipient_min, amount, date_initiated, date_failed, date_requested, date_debit_confirmed, date_credit_confirmed, denomination_id, pasa_type, BRAND, STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssssssssssssssss", $sequence_number, $transaction_id, $date_registered, $primary_min, $brand, $mran, $recipient_min, $amount, $date_initiated, $date_failed, $date_requested, $date_debit_confirmed, $date_credit_confirmed, $denomination_id, $pasa_type, $brand, $status);

                    $conn->query("START TRANSACTION");
                    foreach ($pasa as $res) {
                        $sequence_number = $res[0];
                        $transaction_id = $res[1];
                        $date_registered = $res[2];
                        $primary_min = $res[3];
                        $brand = $res[4];
                        $mran = $res[5];
                        $recipient_min = $res[6];
                        $amount = $res[7];
                        $date_initiated = $res[8];
                        $date_failed = $res[9];
                        $date_requested = $res[10];
                        $date_debit_confirmed = $res[11];
                        $date_credit_confirmed = $res[12];
                        $denomination_id = $res[13];
                        $pasa_type = $res[14];
                        $brand = $res[15];
                        $status = $res[16];
                        $stmt->execute();
                    }
                    $stmt->close();
                    $conn->query("COMMIT");
                    //insert gigapay raw logs here: end

                    // echo "
                    //     <div class='remark info'>
                    //         <pre class='fg-green'><b><i>$filename</i></b> successfully imported. $counter rows inserted.</pre>
                    //     </div>
                    // ";
                } // else {
                //     echo "
                //         <div class='remark warning'>
                //             <pre class='fg-red'>$err_msg</pre>
                //         </div>
                //     ";
                // }
            } // else {
            //     echo "
            //         <div class='remark warning'>
            //             <pre class='fg-red'>$filename invalid file.</pre>
            //         </div>
            //     ";
            // }
            
        }
    }
    // else {
    //     echo "
    //         <div class='remark warning'>
    //             <pre class='fg-red'>No file selected.</pre>
    //         </div>
    //     ";
    // }

    //---------------------------------------------------------------------------------
    header('Location: ./pasa_link_dl.php');
}
?>



<?php
/*include_once './__utils.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="author" content="Smart OPS">
    <meta name="description" content="Pasa Report tool.">
    <meta name="keywords" content="Pasa Data, Pasa Load, Pasa Points, Pasa Promo">

    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">

    <link href="./metro/css/metro-all.css?ver=@@b-version" rel="stylesheet">
    <link href="start.css" rel="stylesheet">

    <title>Pasa Report</title>
</head>

<body class="bg-black fg-white h-vh-100 m4-cloak">
<div class="container-fluid">
    <div class="grid">
        <div class="row mt-10">

        </div>            
    </div>
</div>

</body>
</html> */ ?>