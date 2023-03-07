<?php
include_once './__utils.php';
require_once './Classes/PHPExcel/IOFactory.php';

$title_date = date('F j, Y', strtotime('-1 day', strtotime(date('Y-m-d'))));
$report_sheet = array('PASADATA', 'PASALOAD', 'PASAPROMO', 'PASAPOINTS');
$pasa_status = array('SUCCESS', 'FAILED');
//$file = 'test.xlsx';
$file = 'Pasa Report - ' .date('Ymd', strtotime($title_date)). '.xlsx';

$objPHPExcel = new PHPExcel();

$styleCellCenter = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

$styleCellLeft = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);

function styleHeader($fill, $text) {
    $styleHeader = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => $fill)
        ),
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => $text),
            'size'  => 11,
            'name'  => 'Calibri'
        )
    );

    return $styleHeader;
}

function cellColor($color) {
    $styleCellColor = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => $color)
        ),
    );

    return $styleCellColor;
}

$styleBorder = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$colorList = array('b4c6e7', 'dbdbdb', 'fff2cc');

for ($i = 0; $i < count($report_sheet); $i++) {
    $brand = array();
    $denomination = array();

    if ($report_sheet[$i] == 'PASADATA') $db = 'pasa_data';
    if ($report_sheet[$i] == 'PASALOAD') $db = 'pasa_load';
    if ($report_sheet[$i] == 'PASAPROMO') $db = 'pasa_promo';
    if ($report_sheet[$i] == 'PASAPOINTS') $db = 'pasa_points';

    $pasa_brand_query = mysqli_query($conn, "SELECT DISTINCT(BRAND) FROM $db ORDER BY BRAND ASC");

    //echo $db. '<br />';
    while ($row = mysqli_fetch_object($pasa_brand_query)) {
        array_push($brand, array($row->BRAND));
    }

    $pasa_denomination_query = mysqli_query($conn, "SELECT DISTINCT(denomination_id) FROM $db ORDER BY LENGTH(denomination_id),denomination_id");

    while ($row = mysqli_fetch_object($pasa_denomination_query)) {
        array_push($denomination, array($row->denomination_id));
    }

    if (count($brand) == 2) $highestCol = 'E';
    if (count($brand) == 3) $highestCol = 'G';

    //echo $highestCol.'<br />';

    $objWorkSheet = $objPHPExcel->createSheet($i); // setting index when creating sheet

    //Header
    $objPHPExcel->setActiveSheetIndex($i);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', $title_date. ' - ' .$report_sheet[$i]);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:' .$highestCol. '1');
    $objPHPExcel->getActiveSheet()->getStyle('A1:' .$highestCol. '1')->applyFromArray(styleHeader('000000', 'ffffff'));
    $objPHPExcel->getActiveSheet()->getStyle('A1:' .$highestCol. '1')->applyFromArray($styleBorder);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(cellColor('d9e1f2'));

    //$col = $objPHPExcel->getActiveSheet()->getHighestColumn();
    //$base_col = PHPExcel_Cell::columnIndexFromString($col) + 1;
    
    $range_col = range("A", "Z");

    //B2 with two cells merge, add brand
    $range_count = 1;
    $color_counter = 0;
    for ($br = 0; $br < count($brand); $br++) {
        $merge_col = $range_count;
        //echo $brand[$br][0];
        $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].'2', $brand[$br][0]);
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray($styleCellCenter);
        //$objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray(cellColor($colorList[$color_counter]));
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray($styleBorder);
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray(styleHeader($colorList[$color_counter], '000000'));
        $range_count++;
        $objPHPExcel->getActiveSheet()->mergeCells($range_col[$merge_col].'2:' .$range_col[$range_count]. '2');
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray($styleCellCenter);
        //$objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray(cellColor($colorList[$color_counter]));
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray($styleBorder);
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'2')->applyFromArray(styleHeader($colorList[$color_counter], '000000'));
        $range_count++;
        $color_counter++;
    }

    //A3, add statuses and denom
    $range_count = 0;
    $color_counter = 0;
    $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].'3', 'DENOM');
    //$objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray(cellColor('f4b084'));
    $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray($styleCellCenter);
    $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray($styleBorder);
    $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray(styleHeader('f4b084', '000000'));
    $objPHPExcel->getActiveSheet()->getColumnDimension($range_col[$range_count])->setAutoSize(true);
    for ($br = 0; $br < count($brand); $br++) {    
        for ($x = 0; $x < count($pasa_status); $x++) {
            $range_count++;
            if ($pasa_status[$x] == 'SUCESS') $pasa_alt_status = 'SUCCESS';
            else $pasa_alt_status = $pasa_status[$x];
            $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].'3', $pasa_alt_status);
            //$objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray(cellColor($colorList[$color_counter]));
            $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray($styleBorder);
            $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].'3')->applyFromArray(styleHeader($colorList[$color_counter], '000000'));
            $objPHPExcel->getActiveSheet()->getColumnDimension($range_col[$range_count])->setAutoSize(true);
        }
        $color_counter++;
    }

    //A4, add values and denom
    $range_count = 0;
    $rows_count_value = 4;
    $color_counter = 0;
    foreach ($denomination as $denom) {
        //echo '<tr><td>' .$denom[0]. '</td>';
        $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].$rows_count_value, $denom[0]);
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].$rows_count_value)->applyFromArray($styleBorder);
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].$rows_count_value)->applyFromArray(cellColor('f4b084'));
        $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].$rows_count_value)->applyFromArray($styleCellLeft);
        //$objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].$rows_count_value)->setQuotePrefix(true);
        $range_count++; 
            
        for ($br_count = 0; $br_count < count($brand); $br_count++) {
            foreach ($pasa_status as $status) {
                $brand_temp = $brand[$br_count][0];

                $denom_count = mysqli_query($conn, "SELECT COUNT(denomination_id) FROM $db WHERE denomination_id = '$denom[0]' AND BRAND = '$brand_temp' AND STATUS = '$status'");
                $row = $denom_count->fetch_row();
                if ($row[0] == 0) $row_count = '';
                else $row_count = $row[0];
                    //echo '<td>' .$row_count. '</td>';
                    //echo $range_col[$range_count].$rows_count_value.'<br />';
                    
                    // $objPHPExcel->getActiveSheet()
                    //             ->getStyle($range_col[$range_count].$rows_count_value)
                    //             ->setQuotePrefix(true);
                    $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].$rows_count_value, $row_count);
                    $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].$rows_count_value)->applyFromArray($styleBorder);
                    $objPHPExcel->getActiveSheet()->getStyle($range_col[$range_count].$rows_count_value)->applyFromArray(cellColor($colorList[$color_counter]));
                    $range_count++;
            }
            $color_counter++;
        }
        $rows_count_value++;
        $range_count = 0;
        $color_counter = 0;
    }
    
    //add total
    //echo '<tr><td>TOTAL</td>';
    $range_count = 0;
    $rowHighest = $objPHPExcel->getActiveSheet()->getHighestRow() + 1;
    $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].$rowHighest, 'TOTAL');
    $range_count++;
    for ($br_count = 0; $br_count < count($brand); $br_count++) {
        foreach ($pasa_status as $status) {
            $brand_temp = $brand[$br_count][0];

            $denom_count = mysqli_query($conn, "SELECT COUNT(denomination_id) FROM $db WHERE BRAND = '$brand_temp' AND STATUS = '$status'");
            $row = $denom_count->fetch_row();
            if ($row[0] == 0) $row_count = '';
            else $row_count = $row[0];
                $objPHPExcel->getActiveSheet()->setCellValue($range_col[$range_count].$rowHighest, $row_count);
                $range_count++;
        }
    }

    $rowHighestStyle = $objPHPExcel->getActiveSheet()->getHighestRow();
    $objPHPExcel->getActiveSheet()->getStyle('A' .$rowHighestStyle. ':' .$highestCol.$rowHighestStyle)->applyFromArray(styleHeader('000000', 'ffffff'));

    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

    //rename sheet
    $objWorkSheet->setTitle("$report_sheet[$i]"); // end sheet
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
$objWriter->save('php://output');

?>