<?php

//require_once 'lib/fpdf.php';
require('lib/rotation.php');

class PDF extends PDF_Rotate {

function RotatedImage($file,$x,$y,$w,$h,$angle) {
	//Image rotated around its upper-left corner
	$this->Rotate($angle,$x,$y);
	$this->Image($file,$x,$y,$w,$h);
	$this->Rotate(0);
}

}


$images = array();
$images = explode(",",$_POST['files']);
$patterns[0] = '/([[:upper:]]+-)/';
$patterns[1] = '/(-[[:digit:]])?.jpg/';
//$replacements[0] = '';
$fileName = preg_replace($patterns, '', $images[0]);
//$fileName = preg_replace('/(-[[:digit:]])?.jpg/', '', $images[0]);
$pdf = new PDF('P','mm','A4');
$pdf->SetFont('Arial','B',16);

foreach ($images as $file) {

    $dirImg = '/var/www/html/planitos/' . $file;
    $pdf->AddPage();
    //$pdf->Image($dirImg, 10, 10, 0, 150);
    $pdf->RotatedImage($dirImg,180,10,0,150,-90);

}

$pdf->Output('I', $fileName, true);
?>
