<?php

require('fpdf.php');


$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(55, 5, 'Application ID:', 0, 0);
$pdf->Cell(58, 5, 'application_id', 0, 0);

//right
$pdf->Cell(25, 5, 'Date:', 0, 0);
$pdf->Cell(52, 5, 'date submitted', 0, 1);

$pdf->Cell(55, 5, 'Pet Name:', 0, 0);
$pdf->Cell(58, 5, 'pet_name', 0, 0);

//right
$pdf->Cell(25, 5, 'Shelter:', 0, 0);
$pdf->Cell(52, 5, 'city_id', 0, 1);

$pdf->Cell(55, 5, 'Status:', 0, 0);
$pdf->Cell(58, 5, 'application_status', 0, 1);

$pdf->Line(10, 30, 200, 30);

$pdf->Ln(10);
$pdf->Cell(55, 5, 'First Name:', 0, 0);
$pdf->Cell(58, 5, 'adopter_fname', 0, 1);

$pdf->Cell(55, 5, 'Last Name:', 0, 0);
$pdf->Cell(58, 5, 'adopter_lname', 0, 1);

$pdf->Cell(55, 5, 'Age:', 0, 0);
$pdf->Cell(58, 5, 'adopter_age', 0, 1);

$pdf->Cell(55, 5, 'Home Address:', 0, 0);
$pdf->Cell(58, 5, 'idk', 0, 1);

$pdf->Cell(55, 5, 'Contact Number:', 0, 0);
$pdf->Cell(58, 5, 'adopter_cnum', 0, 1);

$pdf->Cell(55, 5, 'E-mail Address:', 0, 0);
$pdf->Cell(58, 5, 'user_email', 0, 1);

$pdf->Cell(55, 5, 'Occupation:', 0, 0);
$pdf->Cell(58, 5, 'occ', 0, 1);

$pdf->Cell(55, 5, 'Civil Status:', 0, 0);
$pdf->Cell(58, 3, 'status', 0, 1);

$pdf->Line(10, 80, 200, 80);
$pdf->Ln(10);//Line break



$pdf->Output();
?>