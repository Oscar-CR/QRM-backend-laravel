<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    public function allOrders()
    {
        $company_data = [];
        $order_data = [];
        $product_data = [];
        $orders = Order::all();
        $products = Product::all();
        $companies = Companies::all();

        foreach($companies as $company){    
            foreach($orders as $order){
                if($company->social_reason == $order->company){
                    foreach($products as $product){
                        if($product->pucharse_order_id == $order->id){
                            array_push($product_data, (object)[
                                'data' => $product,
                            ]);
                        }
                        
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
                        'product' => $product_data
                        
                    ]);

                    array_push($order_data, (object)[
                        'id' => $company->id,
                        'social_reason' => $company->social_reason,
                        'rfc' => $company->rfc,
                        'orders' => $order_data,
                    ]);

                }
            }
    
            
    
        }
        return $company_data;
    }
        
}
