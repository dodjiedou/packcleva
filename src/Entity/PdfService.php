<?php

namespace App\Entity;
use Dompdf\Dompdf ;
use Dompdf\Options ;


class PdfService
{
   private $domPdf;

   public function __construct() {

     $this->domPdf = new DomPdf();
     $pdfOptions = new Options();
     $pdfOptions ->set( 'defaultFont' , 'Courrier' );
     $this->domPdf->setOptions($pdfOptions);

   }

    public function showPdfFile($html) {
       
        $this->domPdf->loadHtml($html);
       // $this->domPdf->setPaper('A4', 'landscape');
        $this->domPdf->render();
       // $this->domPdf->stream(filename: 'details.pdf',[ 'Attachment'=> false,]);

   }

   public function generateBinaryPdf($html) {
        $this->domPdf->loadHtml($html);
        //$this->domPdf->setPaper('A4', 'landscape');
        $this->domPdf->render();
        $this->domPdf->output();

   }
    
}
