<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProviderApiController extends Controller
{
    public function providerOrders($token){
        
        $token_id =  DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        
        if($token_id == null){
            return ['message' =>'Token invalido'];
        }
        
        $user = User::all()->where('id', $token_id)->first();

        $product_data = [];
        $order_data = [];
        
        $orders = Order::all()->where('provider_name',$user->provider_company);
       
        foreach($orders as $order){
            
            $products = Product::all()->where('pucharse_order_id',$order->id);
           
            foreach($products as $product){                        
                    array_push($product_data, (object)[
                        "id"=> $product->id,
                        "odoo_product_id"=> $product->odoo_product_id,
                        "product"=>$product->product,
                        "description"=> $product->description,
                        "planned_date"=>$product->planned_date,
                        "company"=> $product->company,
                        "quantity"=> $product->quantity,
                        "quantity_delivered"=> $product->quantity_delivered,
                        "quantity_invoiced"=>$product->quantity_invoiced ,
                        "measurement_unit"=>$product->measurement_unit,
                        "unit_price"=> $product->unit_price,
                        "subtotal"=> $product->subtotal,
                        "pucharse_order_id"=> $product->pucharse_order_id,
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
        $path_data  = [];
        $xml_data = "";
        $pdf_data = "";
        $order = Order::all()->where('id',$request->order_id)->last();

        if ($request->hasFile('xml')) {
            $request->validate([
                'xml' => 'required|mimes:xml',
            ]);
            
            File::delete($order->xml);
            $xml =  $request->file('xml');

            $nombreXML = time() . ' ' . str_replace(',', ' ', $xml->getClientOriginalName());
            $xml->move(public_path('storage/xml/'), $nombreXML); 

            DB::table('orders')->where('id', $request->order_id)->update([
                'xml' => 'storage/xml/'. $nombreXML, 
            ]);

            $xml_data = 'storage/xml/'. $nombreXML;
        } 

        if ($request->hasFile('pdf')) {
            $request->validate([
                'pdf' => 'required|mimes:pdf',
            ]);
            
            File::delete($order->pdf);
            $pdf =  $request->file('pdf');

            $nombrePDF = time() . ' ' . str_replace(',', ' ', $pdf->getClientOriginalName());
            $pdf->move(public_path('storage/pdf/'), $nombrePDF);
            
            DB::table('orders')->where('id', $request->order_id)->update([
                'invoice' => 'storage/pdf/'. $nombrePDF, 
            ]);

            $pdf_data = 'storage/pdf/'. $nombrePDF;
        } 
        
        array_push($path_data, (object)[
            'xml' => $xml_data,
            'pdf' => $pdf_data,
        ]);

        return $path_data;
    }

}
