<?php
include_once './__utils.php';
require_once './Classes/PHPExcel/IOFactory.php';

$title_date = date('F j, Y', strtotime('-1 day', strtotime(date('Y-m-d'))));
$report_sheet = array('PASADATA', 'PASALOAD', 'PASAPROMO', 'PASAPOINTS');
$pasa_status = array('SUCESS', 'FAILED');
//$file = 'test.xlsx';
$file = 'Pasa Report - ' .date('Ymd', strtotime($title_date)). '.xlsx';

$objPHPExcel = new PHPExcel();

$styleHeader = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '000000')
    ),
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'ffffff'),
        'size'  => 11,
        'name'  => 'Calibri'
    )
);

for ($i = 0; $i < count($report_sheet); $i++) {
    $brand = array();
    $denomination = array();

    if ($report_sheet[$i] == 'PASADATA') $db = 'pasa_data';
    if ($report_sheet[$i] == 'PASALOAD') $db = 'pasa_load';
    if ($report_sheet[$i] == 'PASAPROMO') $db = 'pasa_promo';
    if ($report_sheet[$i] == 'PASAPOINTS') $db = 'pasa_points';

    $pasa_brand_query = mysqli_query($conn, "SELECT DISTINCT(BRAND) FROM $db ORDER BY BRAND ASC");

    echo $db. '<br />';
    while ($row = mysqli_fetch_object($pasa_brand_query)) {
        array_push($brand, array($row->BRAND));
    }

    $pasa_denomination_query = mysqli_query($conn, "SELECT DISTINCT(denomination_id) FROM $db ORDER BY LENGTH(denomination_id),denomination_id");

    while ($row = mysqli_fetch_object($pasa_denomination_query)) {
        array_push($denomination, array($row->denomination_id));
    }

    echo '<table border=1>';
    echo "<tr><td>$db</td></tr>";
    echo "<tr><td>&nbsp;</td>";
    for ($br = 0; $br < count($brand); $br++) {
        echo '<td colspan=2>'.$brand[$br][0].'</td>';
    }
    echo "</tr>";

    echo "<tr>";
    echo "<td>Denom</td>";
    for ($br = 0; $br < count($brand); $br++) {    
        for ($x = 0; $x < count($pasa_status); $x++) {
            echo '<td>'.$pasa_status[$x].'</td>';
        }
    }
    echo "</tr>";
    
    foreach ($denomination as $denom) {
        echo '<tr><td>' .$denom[0]. '</td>';
            
        for ($br_count = 0; $br_count < count($brand); $br_count++) {
            foreach ($pasa_status as $status) {
                $brand_temp = $brand[$br_count][0];

                $denom_count = mysqli_query($conn, "SELECT COUNT(denomination_id) FROM $db WHERE denomination_id = '$denom[0]' AND BRAND = '$brand_temp' AND STATUS = '$status'");
                $row = $denom_count->fetch_row();
                if ($row[0] == 0) $row_count = '';
                else $row_count = $row[0];
                    echo '<td>' .$row_count. '</td>';
            }
        }
        echo '</tr>';
    }

    echo '<tr><td>TOTAL</td>';
    for ($br_count = 0; $br_count < count($brand); $br_count++) {
        foreach ($pasa_status as $status) {
            $brand_temp = $brand[$br_count][0];

            $denom_count = mysqli_query($conn, "SELECT COUNT(denomination_id) FROM $db WHERE BRAND = '$brand_temp' AND STATUS = '$status'");
            $row = $denom_count->fetch_row();
            if ($row[0] == 0) $row_count = '';
            else $row_count = $row[0];
                echo '<td>' .$row_count. '</td>';
        }
    }
    echo '</tr>';

    echo "</table>";

}

    /*
    // Add new sheet
    $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

    //Write cells
    // Your existing code to write the data
    $objPHPExcel->setActiveSheetIndex($i);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', $title_date. ' - ' .$report_sheet[$i]);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    $objPHPExcel->getActiveSheet()->getStyle("A1:G1")->applyFromArray($styleHeader);
    //$objPHPExcel->getActiveSheet()->getStyle('G1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:H1','Date Submitted');

    //->mergeCells('G'.$row.':H'.$row
    $row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, 'test1');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, 'test1');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, 'test1');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, 'test1');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, 'test1');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, 'test1');
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row, 'test1');
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $from = "A1";
    $to = "G1";
    $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);

    // Rename sheet
    $objWorkSheet->setTitle("$report_sheet[$i]");
}

$objPHPExcel->removeSheetByIndex(
    $objPHPExcel->getIndex(
        $objPHPExcel->getSheetByName('Worksheet')
    )
);

$objPHPExcel->setActiveSheetIndex('0');



// Save the excel file
//$objWriter->save($file);
header("Content-Disposition: attachment; filename=$file");

// Write file to the browser
$objWriter->save('php://output');*/

die;

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

                    echo "
                        <div class='remark info'>
                            <pre class='fg-green'><b><i>$filename</i></b> successfully imported. $counter rows inserted.</pre>
                        </div>

                        <audio autoplay>
                            <source src='../asset/sound/chime.mp3'>
                        </audio>
                    ";
                } else {
                    echo "
                        <div class='remark warning'>
                            <pre class='fg-red'>$err_msg</pre>
                        </div>
                    ";
                }
            } else {
                echo "
                    <div class='remark warning'>
                        <pre class='fg-red'>$filename invalid file.</pre>
                    </div>
                ";
            }
            
        }
    }
    else {
        echo "
            <div class='remark warning'>
                <pre class='fg-red'>No file selected.</pre>
            </div>
        ";
    }
}
?>