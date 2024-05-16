<?php
namespace app\components;

use TCPDF;

class MyTcpdf extends TCPDF
{
    public $customHeaderText;

    // Page header
    public function Header()
    {
        // Logo
        // $imageFile = K_PATH_IMAGES . 'logo_example.png';
        // $this->Image($imageFile, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font

        // $this->SetFont('helvetica', 'B', 8);
        // Title
        $this->Cell(0, 10, $this->customHeaderText, 0, 0, 'R');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->Line($this->getX(), $this->getY(), $this->getX() + $this->getPageWidth() - $this->getMargins()['left'] - $this->getMargins()['right'], $this->getY());

         // Left footer text
        $this->Cell(0, 10, 'SURAT KETERANGAN PENDAMPING IJAZAH | Diploma Supplement', 0, 0, 'L');

        // Right footer text
        $right_label = 'Halaman '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages();
        $right_label .= '| Page '.$this->getAliasNumPage().' from '.$this->getAliasNbPages();
        $this->Cell(25, 10, $right_label, 0, 0, 'R');
    }
}