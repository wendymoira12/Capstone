<?php
include('config.php');
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;


$sql = "SELECT * FROM adopter_tbl INNER JOIN user_tbl ON adopter_tbl.user_id = user_tbl.user_id WHERE adopter_id";
$result = $conn->query($sql);
if ($result == TRUE) {
  $adata = mysqli_fetch_assoc($result);
}



// instantiate and use the dompdf class
$dompdf = new Dompdf();



ob_start();
require('report.php');
$html =ob_get_contents();
ob_get_clean();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('print-details.pdf',['Attachment'=>false]);

?>