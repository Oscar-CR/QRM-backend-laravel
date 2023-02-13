<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;

class TestController extends Controller
{
    public function testUpdateFiles()
    {
        return view('test.updatefiles');
    }

    public function testUpdateFilesStore(Request $request)
    {
        
        if ($request->hasFile('xml')) {
            $request->validate([
                'xml' => 'required|mimes:xml',
            ]);
            $xml =  $request->file('xml');

            $nombreXML = time() . ' ' . str_replace(',', ' ', $xml->getClientOriginalName());
            $xml->move(public_path('storage/xml/'), $nombreXML); 
        } 

        if ($request->hasFile('pdf')) {
            $request->validate([
                'pdf' => 'required|mimes:pdf',
            ]);
            $pdf =  $request->file('pdf');

            $nombrePDF = time() . ' ' . str_replace(',', ' ', $pdf->getClientOriginalName());
            $pdf->move(public_path('storage/pdf/'), $nombrePDF); 
        } 


      
        return $nombreXML . "      " . $nombrePDF;
    }
}
