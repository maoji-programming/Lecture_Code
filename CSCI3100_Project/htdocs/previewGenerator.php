<!--
/////////////////////////////////////////////////////////////
/* previewGenerator.php from CSCI3100 group 15
   03-05-2019

   Purpose: Conver user's resource into a preview version 
   Module used by upload_file.php
   Included by upload_file.php
*/
////////////////////////////////////////////////////////////
-->
<?php
ob_start();
use setasign\Fpdi;
require_once('tcpdf/tcpdf.php'); //using external library
require_once('FPDI-master/src/autoload.php');
// Original file with multiple pages 
//$name = '1.4notes1';
$fullPathToFile = 'source_database/'.$name.'.pdf';

class PDF extends Fpdi\tcpdffpdi {
    var $_tplIdx;
    function Header() {
        global $fullPathToFile;
        if (is_null($this->_tplIdx)) {
            $this->numPages = $this->setSourceFile($fullPathToFile);
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx);
    }
    function Footer() {}
}
$pdf = new PDF();
$pdf->setFontSubsetting(true);

$pdf->AddPage();
$pdf->SetFont("helvetica", "B", 20);

if($pdf->numPages>1) {
    for($i=2;$i<=$pdf->numPages/2;$i++) { // only allow some page
        $pdf->_tplIdx = $pdf->importPage($i);
        $pdf->Text(10,10,'Download the FULL Version with Token NOW!');
		$pdf->endPage();
		$pdf->AddPage();
		
    }
}

$pdf->Text(10,10,'Download the FULL Version with Token NOW!');
$pdf->SetFillColor(224, 224, 224);
$pdf->writeHTMLCell(185, 10, 13, 250, "This is the bottom of preview version. <br/>Please download the full version with token.", 0, 1, 1, true, 'C');
//Please download the full version with token.
$pdf->endPage();
$pdf->_tplIdx = null;
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'source_database/preview/'.$name.'_preview.pdf', 'F');
//$pdf->Output('HI.pdf');
//$pdf->Output('source_database/'.$name.'_preview.pdf', 'F');
?>
