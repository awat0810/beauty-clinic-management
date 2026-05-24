<?php
ob_start(); 

require '../connection/conn.php';
require '../fpdf/fpdf.php';

$date_filter = isset($_GET['appointment_date']) ? $_GET['appointment_date'] : date('Y-m-d');


$query = "SELECT a.*, p.patient_name 
          FROM appointment a
          JOIN patient p ON a.appointment_patient = p.patient_id
          WHERE a.appointment_date = '$date_filter'
          ORDER BY a.appointment_operation ASC";
$result = $conn->query($query);


$total_patients = 0;
$total_price_d = 0;
$total_price_p = 0;
$appointments = [];
while($row = mysqli_fetch_array($result)){
    $appointments[] = $row;
    $total_patients++;
    $total_price_p += $row['appointment_payment'];
	$total_price_d += $row['appointment_price'];
	
}

$remain = $total_price_d - $total_price_p;

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);


$pdf->Cell(0,10,"Appointments for " . date('d-m-Y', strtotime($date_filter)),0,1,'C');
$pdf->Ln(5);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'#',1);
$pdf->Cell(50,10,'Patient',1);
$pdf->Cell(60,10,'Operations',1);
$pdf->Cell(25,10,'Price',1);
$pdf->Cell(25,10,'Paid',1);
$pdf->Cell(25,10,'Remain',1);

$pdf->Ln();

$pdf->SetFont('Arial','',12);
$i = 1;
foreach($appointments as $app){
    $pdf->Cell(10,10,$i++,1);
    $pdf->Cell(50,10,$app['patient_name'],1);
    $text = $app['appointment_operation'];
	$maxLength = 30; 
	if(strlen($text) > $maxLength){
		$text = substr($text,0,$maxLength-3) . '...';
	}
	$pdf->Cell(60,10,$text,1);
	$pdf->Cell(25,10,number_format($app['appointment_price']),1);
	$pdf->Cell(25,10,number_format($app['appointment_payment']),1);
	$pdf->Cell(25,10,number_format($app['appointment_price'] - $app['appointment_payment']),1);
	

  
    
    $pdf->Ln();
}

  
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,"Total Money: " . number_format($total_price_d) . " IQD   |   Total Paid: " .  number_format($total_price_p) . " IQD |   Total Remain: " .  number_format($remain) . " IQD", 0, 1, 'C');
$pdf->Cell(0,10,"Total Patients: ".$total_patients , 0, 1, 'C');

ob_end_clean();


$pdf->Output('D','appointments_'.$date_filter.'.pdf');
exit;
?>
