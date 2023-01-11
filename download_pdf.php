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
    $echipaAleasa = $_SESSION['echipa'];

    unset($_SESSION['numbers']);
    unset($_SESSION['names']);
    unset($_SESSION['positions']);
    unset($_SESSION['echipaAleasa']);
    $url = file_get_contents('https://lpf.ro/cluburi/' . $echipaAleasa);
    $doc = new \DOMDocument();
    @$doc->loadHTML($url);
    $divs = $doc->getElementsByTagName('div');
    foreach($divs as $div){
        if($div->hasAttribute('class') && $div->getAttribute('class') == 'club-logo-big'){
            $mydiv = $div;
            break;
        }
    }
    $pdf->Image('https://lpf.ro/' . $mydiv->getElementsByTagName('img')->item(0)->getAttribute('src'), 180, 0, 30, 30);
    $pdf->SetFont('Courier', '', 16);
    $pdf->Cell(40,10,'Portari:');
    $pdf->SetFont('Courier','',12);
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Portar"){
            $pdf->Cell(40,10, $numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->SetFont('Courier', '', 16);
    $pdf->Cell(40,10, 'Fundasi:');
    $pdf->SetFont('Courier','',12);
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Fundaș"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->SetFont('Courier', '', 16);
    $pdf->Cell(40,10,'Mijlocasi:');
    $pdf->SetFont('Courier','',12);
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Mijlocaș"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->SetFont('Courier', '', 16);
    $pdf->Cell(40,10,'Atacanti:');
    $pdf->SetFont('Courier','',12);
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "Atacant"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->SetFont('Courier', '', 16);
    $pdf->Cell(40,10,'Nespecificat:');
    $pdf->SetFont('Courier','',12);
    $pdf->Ln();
    for($i=0;$i<count($names);$i++)
        if($positions[$i] == "-"){
            $pdf->Cell(40,10,$numbers[$i] . ' ' . $names[$i]);
            $pdf->Ln();
        }
    $pdf->Output('lot.pdf', 'D');
}
?>
