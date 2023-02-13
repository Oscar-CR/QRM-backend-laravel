<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProviderApiController extends Controller
{
    public function providerOrders($token){
        
        $token_id =  DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        
        if($token_id == null){
            return 'Token invalido';
        }
        
        $user = User::all()->where('id', $token_id)->first();
        $company = Companies::all()->where('id',$user->company_id)->first();

        $product_data = [];
        $order_data = [];
        
        $orders = Order::all()->where('provider_name',$company->social_reason);
       
        foreach($orders as $order){
            
            $products = Product::all()->where('pucharse_order_id',$order->id);
           
            foreach($products as $product){                        
                    array_push($product_data, (object)[
                        'data' => $product,
                    ]);
                }
                
            array_push($order_data, (object)[
                'id' => $order->id,
                'code_sale' => $order->code_sale,
                'type_purchase' => $order->type_purchase,
                'sequence' => $order->sequence,
                'company' => $order->company,
                'code_purchase' => $order->code_purchase,
                'order_date' => $order->order_date,
                'provider_name' => $order->provider_name,
                'provider_address' => $order->provider_address,
                'planned_date' => $order->planned_date,
                'supplier_representative' => $order->supplier_representative,
                'total' => $order->total,
                'status' => $order->status,
                'invoice' => $order->invoice,
                'xml' => $order->xml,
                'payment_status'=> $order->payment_status,
                'product' => $product_data
            ]);
            $product_data = [];
        }
       
        return $order_data;

    }

    public function updateFiles(Request $request)
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

        $path_data  = [];
        array_push($path_data, (object)[
            'xml' => 'storage/xml/'. $nombreXML,
            'pdf' => 'storage/pdf/'. $nombrePDF,
        ]);

        return $path_data;
    }

    public function updateXML(Request $request){

        if ($request->hasFile('xml')) {
            $request->validate([
                'xml' => 'required',
                'order_id' => 'required',
            ]);
            
            $xml =  $request->file('xml');
            $path = Storage::disk('xml')->put('storage/public/xml/', $xml); 

            DB::table('orders')->where('id', $request->id)->update([
                'xml' => $path, 
            ]);

            return $path;

        } else {
            return "No se ha cargado el archivo xml";
        } 
    }

    public function updatePDF(Request $request){

        if ($request->hasFile('pdf')) {
            $request->validate([
                'xml' => 'required',
                'order_id' => 'required',
            ]);
            
            $pdf =  $request->file('pdf');
           
            $path = Storage::disk('pdf')->put('storage/public/xml/', $pdf); 

            DB::table('orders')->where('id', $request->id)->update([
                'pdf' => $path, 
            ]);

            return $path;

        } else {
            return "No se ha cargado el archivo pdf";
        } 
    }
}
