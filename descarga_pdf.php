<?php

//require_once 'lib/fpdf.php';
require($_SERVER['DOCUMENT_ROOT'].'/lib/rotation.php');


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

    $dirImg = $_SERVER['DOCUMENT_ROOT'] . '/planitos/' . $file;
    $pdf->AddPage();
    //$pdf->Image($dirImg, 10, 10, 0, 150);
    $pdf->RotatedImage($dirImg,180,10,0,150,-90);

}

//Log descargas
//$DLString = date(DATE_RFC1123) . " " . $fileName . "\n";
//$logDLFile = "/descargas-log.txt";
//file_put_contents(__DIR__ . $logDLFile, $DLString , FILE_APPEND);

$pdf->Output('I', $fileName, true);

?>
