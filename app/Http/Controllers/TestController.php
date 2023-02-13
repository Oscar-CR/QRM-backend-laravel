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
                'xml' => 'required|image|mimes:jpg,jpeg,png,gif',
            ]);
            $image =  $request->file('xml');

            $nombreImagen = time() . ' ' . str_replace(',', ' ', $image->getClientOriginalName());
            $image->move(public_path('storage/xml/'), $nombreImagen);

            /* $path = Storage::disk('postImages')->put('storage/posts', $image);  */

            return $nombreImagen;
        } else {
            return "error";
        }
      
    }
}
