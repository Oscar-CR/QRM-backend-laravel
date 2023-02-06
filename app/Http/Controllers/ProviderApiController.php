<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderApiController extends Controller
{
    public function providerOrders(Request $request){

        $provider_data = [];
        $token_id =  DB::table('personal_access_tokens')->where('token', $request->token)->value('tokenable_id');  
        $user = User::all()->where('id', $token_id)->first();
        $company = Companies::all()->where('id',$user->company_id)->first();
        $orders = Order::all()->where('provider_name',$company->social_reason)->all();

        foreach($orders as $order){
            $products = Product::all()->where('pucharse_order_id',$order->id);
            array_push($provider_data, (object)[
                'id' => $order->id,
                'code_sale'=> $order->code_sale,
                'type_purchase'=> $order->type_purchase,
                'sequence'=> $order->sequence,
                'company'=> $order->company,
                'code_purchase'=> $order->code_purchase,
                'order_date'=> $order->order_date,
                'provider_name'=> $order->provider_name,
                'provider_address'=> $order->provider_address,
                'planned_date'=> $order->planned_date,
                'supplier_representative'=> $order->supplier_representative,
                'total'=> $order->total,
                'status'=> $order->status,
                'invoice'=> $order->invoice,
                'xml'=> $order->xml,
                'payment_status'=> $order->payment_status,
                'products'=> $products
            ]);
        }
        return $provider_data;


    }
}
