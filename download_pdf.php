<?php
session_start();
if(isset($_POST['download_pdf'])){
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="lot.pdf"');
    header('Cache-Control: max-age=0');
    require('./fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->AddFont('Courier','','courier.php');
    $pdf->SetFont('Courier','',12);

    $numbers = $_SESSION['numbers'];
    $names = $_SESSION['names'];
    $positions = $_SESSION['positions'];
    $pdf->Cell(40,10,'Portari:');
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Portar"){
            $pdf->Cell(40,10, $numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->Cell(40,10, 'Fundasi:');
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Fundaș"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->Cell(40,10,'Mijlocasi:');
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Mijlocaș"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->Cell(40,10,'Atacanti:');
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Atacant"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->Cell(40,10,'Nespecificat:');
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "-"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->Output('lot.pdf', 'D');
}
?>