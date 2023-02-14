<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;


class OrdersTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene las ordenes apartir del bmps';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $page = 1;

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2Rldi1hcGktYnBtcy5wcm9tb2xpZmUubGF0L2FwaS9sb2dpbiIsImlhdCI6MTY3NjM4NzU0NSwiZXhwIjoxNjc2NjQ2NzQ1LCJuYmYiOjE2NzYzODc1NDUsImp0aSI6IlVlMVFSSFJnMklFYWpQblQiLCJzdWIiOiI3MCIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJyb2xlIjpbXSwidXNlciI6eyJuYW1lIjoiSXZvbm5lIEzDs3BleiBFc2NvYmVkbyIsImVtYWlsIjoiaXZvbm5lLmxvcGV6QHByb21vbGlmZS5jb20ubXgiLCJwaG90byI6Imh0dHBzOi8vaW50cmFuZXQucHJvbW9saWZlLmxhdC9zdG9yYWdlL3Bvc3QvMTUuLSUyMEl2b25uZSUyMExvcGV6LmpwZyJ9fQ.h0qGyzUzH-sNch6yhXKFhxHosO4Uqxwl4oVyhjlMX9s';
        $init_url = 'https://dev-api-bpms.promolife.lat/api/pedidos?page='.$page.'&token='. $token;
        $init_ch = curl_init();
        curl_setopt($init_ch, CURLOPT_URL, $init_url);
        curl_setopt($init_ch, CURLOPT_RETURNTRANSFER, true);
        $init_res = curl_exec($init_ch);
        curl_close($init_ch);
        $init_res = json_decode($init_res);
        
        $total_pages = $init_res->data->sales->last_page;
        
        for($i = 1; $i <= $total_pages; $i++){
            $page = $i;

            $url = 'https://dev-api-bpms.promolife.lat/api/pedidos?page='.$page.'&token='. $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($res);

            //Validacion dordenes nulas
            if($res <> null){
                foreach ($res->data->sales->data as $full_detail_orders){

                    foreach($full_detail_orders->details_orders as $order){
                        $find_order = Order::all()->where('code_sale',$order->code_sale)->last();
                        $find_company = Companies::all()->where('social_reason', $order->company)->last();
                        $find_provider = Companies::all()->where('social_reason', $order->provider_name)->last();


                        if($find_company ==null){
                            $create_company = new Companies();
                            $create_company->social_reason =  $order->company;
                            $create_company->rfc =  'SIN ASIGNAR';
                            $create_company->save(); 
                        }

                        if($find_provider ==null){
                            $create_provider = new Companies();
                            $create_provider->social_reason =  $order->provider_name;
                            $create_provider->rfc =  'SIN ASIGNAR';
                            $create_provider->save(); 
                        }
                        
                        if($find_order == null){
                            $create_order = new Order();
                            $create_order->code_sale =  $order->code_sale;
                            $create_order->type_purchase =  'Pedido';
                            $create_order->sequence =  $order->sequence;
                            $create_order->company =  $order->company;
                            $create_order->code_purchase =  $order->code_order;
                            $create_order->order_date =  $order->order_date;
                            $create_order->provider_name =  $order->provider_name;
                            $create_order->provider_address =  $order->provider_address;
                            $create_order->planned_date =  $order->planned_date;
                            $create_order->supplier_representative =  $order->supplier_representative;
                            $create_order->total =  $order->total;
                            $create_order->status =  $order->status;
                            $create_order->invoice =  null;
                            $create_order->xml =  null;
                            $create_order->payment_status = 'En validacion';
                            $create_order->save();

                            $order_id = Order::all()->where('code_sale',$order->code_sale)->value('id');

                            foreach($order->products as $product){
                                $create_product = new Product();
                                $create_product->odoo_product_id = strval($product->odoo_product_id);
                                $create_product->product =   $product->product;
                                $create_product->description =  $product->description;
                                $create_product->planned_date =  $product->planned_date;
                                $create_product->company =  $product->company;
                                $create_product->quantity =  $product->quantity;
                                $create_product->quantity_delivered =  $product->quantity_invoiced;
                                $create_product->quantity_invoiced =  $product->quantity_delivered;
                                $create_product->measurement_unit =  $product->measurement_unit;
                                $create_product->unit_price =  $product->unit_price;
                                $create_product->subtotal =  $product->subtotal;
                                $create_product->pucharse_order_id  =  $order_id ;
                                $create_product->save();
                            }
                        }

                    }
                }
            }
            
        } 

        return Command::SUCCESS;
    }
}
