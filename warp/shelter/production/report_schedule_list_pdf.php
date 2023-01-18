<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options;
$options->set('defaultFont', 'Helvetica');
$options->setIsRemoteEnabled(true);
$options->setChroot(__DIR__);
$options->setIsPhpEnabled(true);
$dompdf = new Dompdf($options);

// instantiate and use the dompdf class
ob_start();
require('report_schedule_list.php');
$html = ob_get_contents();
ob_get_clean();


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('report_schedule_list.pdf',['Attachment'=>false]);
