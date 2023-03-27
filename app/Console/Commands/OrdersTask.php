<?php

namespace App\Console\Commands;

use App\Mail\RecoveryMail;
use Illuminate\Console\Command;
use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use App\Models\RoleUser;
use App\Models\SalesOrders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
                //Consumo de api paginado
        //Ejemplo:
        //https://dev-api-bpms.promolife.lat/api/pedidos?page=1&token=NE3JBE2UEU
        //https://dev-api-bpms.promolife.lat/api/pedidos?page=2&token=NE3JBE2UEU

        $page = 1;

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2Rldi1hcGktYnBtcy5wcm9tb2xpZmUubGF0L2FwaS9sb2dpbiIsImlhdCI6MTY3OTk0MzkyMSwiZXhwIjoxNjgwMjAzMTIxLCJuYmYiOjE2Nzk5NDM5MjEsImp0aSI6IkIyd0o3Q1VIbFlRWUVZenAiLCJzdWIiOiI3MCIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJyb2xlIjpbXSwidXNlciI6eyJuYW1lIjoiSXZvbm5lIEzDs3BleiBFc2NvYmVkbyIsImVtYWlsIjoiaXZvbm5lLmxvcGV6QHByb21vbGlmZS5jb20ubXgiLCJwaG90byI6Imh0dHBzOi8vaW50cmFuZXQucHJvbW9saWZlLmxhdC9zdG9yYWdlL3Bvc3QvMTUuLSUyMEl2b25uZSUyMExvcGV6LmpwZyJ9fQ.d3PqOWeUBHhWw0mTWKoJ174Q22xx66yr5aLkQljRa5Y';
        $init_url = 'https://dev-api-bpms.promolife.lat/api/pedidos?page='.$page.'&token='. $token;
        $init_ch = curl_init();
        curl_setopt($init_ch, CURLOPT_URL, $init_url);
        curl_setopt($init_ch, CURLOPT_RETURNTRANSFER, true);
        $init_res = curl_exec($init_ch);
        curl_close($init_ch);
        $init_res = json_decode($init_res);
        
        $total_pages = $init_res->data->sales->last_page;
        
        //Valida el total de paginas del api
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

                foreach ($res->data->sales->data as $sale_order){
               
                    $find_sale_order = SalesOrders::all()->where('order_date',$sale_order->code_sale)->last();

                    //   Pedidos de venta
                    //    ╚ Ordenes
                    //       ╚ Productos

                    //Registro de nuevos pedido de venta
                    if($find_sale_order == null){
                            
                        $create_sale_order = new SalesOrders();
                        $create_sale_order->code_sale = $sale_order->code_sale;
                        $create_sale_order->name_sale = $sale_order->name_sale;
                        $create_sale_order->sequence = $sale_order->sequence;
                        $create_sale_order->invoice_address = $sale_order->invoice_address;
                        $create_sale_order->delivery_address = $sale_order->delivery_address;
                        $create_sale_order->delivery_time = $sale_order->delivery_time;
                        $create_sale_order->delivery_instructions = $sale_order->delivery_instructions;
                        $create_sale_order->order_date = $sale_order->order_date;
                        $create_sale_order->incidence = $sale_order->incidence;
                        $create_sale_order->sample_required = $sale_order->sample_required;
                        $create_sale_order->additional_information = $sale_order->additional_information;
                        $create_sale_order->tariff = $sale_order->tariff;
                        $create_sale_order->commercial_name = $sale_order->commercial_name;
                        $create_sale_order->commercial_email = $sale_order->commercial_email;
                        $create_sale_order->commercial_odoo_id = $sale_order->commercial_odoo_id;
                        $create_sale_order->subtotal = $sale_order->subtotal;
                        $create_sale_order->taxes = $sale_order->taxes;
                        $create_sale_order->total = $sale_order->total;
                        $create_sale_order->status_id = $sale_order->status_id;
                        $create_sale_order->save();

                        $find_sale_id = SalesOrders::all()->where('code_sale',$sale_order->code_sale)->last()->value('id');

                        foreach($sale_order->details_orders as $order){

                            $find_order = Order::all()->where('code_sale',$order->code_sale)->last();
                            $find_company = Companies::all()->where('social_reason', $order->company)->last();
                            $find_provider = Companies::all()->where('social_reason', $order->provider_name)->last();
                            $find_user_to_send_mail = User::all()->where('email',$sale_order->commercial_email)->last();

                            //Registro de nuevos proveedores
                            if($find_company ==null){
                                $create_company = new Companies();
                                $create_company->social_reason =  $order->company;
                                $create_company->rfc =  'SIN ASIGNAR';
                                $create_company->save(); 
                            }
                            
                            //Registro de nuevos proveedores
                            if($find_provider ==null){
                                $create_provider = new Companies();
                                $create_provider->social_reason =  $order->provider_name;
                                $create_provider->rfc =  'SIN ASIGNAR';
                                $create_provider->save(); 
                            }

                            $find_provider_id = Companies::all()->where('social_reason', $order->provider_name)->last();

                            //Si no encuentra el usuario en la BD se creara un nuevo registro y enviara su acceso
                            if($find_user_to_send_mail == null){

                                $password= Str::random(10);
                                $encrypted_password = Hash::make($password);

                                $create_user = new User();
                                $create_user->fullname = $sale_order->commercial_name;
                                $create_user->rfc = null;
                                $create_user->email = $sale_order->commercial_email;
                                $create_user->password = $encrypted_password; 
                                $create_user->status_id = 1;
                                $create_user->company_id = $find_provider_id->id;
                                $create_user->save();

                                $find_user_id = User::all()->where('fullname', $sale_order->commercial_name)->last();
                                $create_role = new RoleUser();
                                $create_role->role_id = 2;
                                $create_role->user_id = $find_user_id->id;
                                $create_role->user_type ='App\Models\User';
                                $create_role->save();

                                try {

                                    Mail::to($sale_order->commercial_email)->send(new RecoveryMail($sale_order->commercial_email,$password));
                                  
                                } catch (\Exception $e) {
      
                                }

                            }
                            
                            //Registro de nuevas ordenes
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
                                $create_order->payment_status = 1;
                                $create_order->sales_order_id = $find_sale_id;
                                $create_order->save();
        
                                $order_id = Order::all()->where('code_sale',$order->code_sale)->value('id');
                                
                                //Registro de productos de cada ordern
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
        } 

        return Command::SUCCESS;
    }
}
