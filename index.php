<?php
include_once './__utils.php';

truncateTables($conn);
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

    <script src="./metro/js/jquery.min.js"></script>

    <title>Pasa Report</title>
</head>
<body class="bg-black fg-white h-vh-100 m4-cloak">

    <div class="container-fluid start-screen h-100">
        <h1 class="start-screen-title">PASA REPORT</h1>
        <div class='grid'>
            <div class='row mt-10'>

                <div class='cell'>
                    <form action='pasa_process.php' method='post' enctype='multipart/form-data' class='multi-browse pos-top-center'>
                        <input type='file' data-role='file' data-mode='drop' multiple data-cls-caption='fg-black' id='multiBrowse' name='file[]' onchange='javascript:updateList()' style="cursor: pointer;">
                    
                        <button type='submit' name='submit' id='submitImport' class='command-button primary rounded mt-3 size-small submit-import' disabled='disabled'>
                            <span class='mif-checkmark icon'></span>
                            <span class='caption'>
                                Process Report
                                <small>Click here to process report.</small>
                            </span>
                        </button>

                        <div id='fileList' class='multi-browse pos-top-center'></div>
                    
                    </form>

                </div>
                
            </div>
        </div>

    </div>

    <script src="./script.js"></script>
    <script src="./metro/js/metro.js"></script>
    <script src="start.js"></script>

</body>
</html>