<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;

class pdfController extends Controller
{
    public function createPDF(Request $req){
            $certificate = 'file://'.base_path().'/public/tcpdf.crt';
            $privateKey = 'file://'.base_path().'/public/tcpdf.key';
            $info = array(
                'Name' => 'Smartly Built',
                'Location' => 'Office',
                'Reason' => 'Private Documents',
                'ContactInfo' => 'httpa://www.smartltbuilt.com',
            );
            PDF::setSignature($certificate, $privateKey, 'tcpdfdemo', '', 2, $info);
    
            PDF::SetFont('helvetica', '', 12);
            PDF::SetTitle('Hello World');
            PDF::AddPage();
    
            $text = view('pdf');
    
            PDF::writeHTML($text, true, 0, true, 0);
    
            PDF::Image('tcpdf.png', 180, 80, 15, 15, 'PNG');
    
            PDF::setSignatureAppearance(180, 60, 15, 15);
    
            PDF::Output(public_path('test.pdf'), 'F');
    
            PDF::reset();
    
            return response(['message'=>'PDF Created Successfully!']);
    }
}
