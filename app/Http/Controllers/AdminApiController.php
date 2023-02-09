<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Status;
use App\Models\User;
use ArrayObject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class AdminApiController extends Controller
{
    public function allOrders()
    {
        $general_data = [];
        $company_data = [];
        $order_data = [];
        $product_data = [];
        $companies = Companies::all();
        $general_total_to_pay = 0;
        $general_total_debt = 0;
        $general_total_pay = 0;

        foreach($companies as $company){  
          
            $orders = Order::all()->where('provider_name',$company->social_reason);  
            $total_orders = 0;
            $total_to_pay = 0;
            $total_debt = 0;
            $total_pay = 0;
                
            foreach($orders as $order){
                    $total_orders = Order::all()->where('provider_name',$company->social_reason )->count();
                    $total_to_pay = $total_to_pay + floatval($order->total);
                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);

                    if($order->payment_status == 'Pagado'){
                        $total_pay = $total_pay + floatval($order->total);
                        $general_total_pay = $general_total_pay + floatval($order->total);
                    }else{
                        $total_debt = $total_debt + floatval($order->total);
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                    }
                    
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
            if($total_orders >0){
                array_push($company_data, (object)[
                    'id' => $company->id,
                    'social_reason' => $company->social_reason,
                    'rfc' => $company->rfc,
                    'orders_total' => $total_orders,
                    'total_to_pay' => $total_to_pay,
                    'total_debt' => $total_debt,
                    'total_pay' => $total_pay,
                    'orders' => $order_data,
                ]);
            }
           
            $order_data = [];
            
        }
        array_push($general_data, (object)[
            'general_total_to_pay' => $general_total_to_pay,
            'general_total_debt' => $general_total_debt,
            'general_total_pay' => $general_total_pay,
            'companies'=> $company_data
        ]);
        return $general_data;
    }

    public function allUsers(){
        
        $user_data = [];
        $users = User::all();
        foreach($users as $user){

            $role_id = RoleUser::all()->where('user_id',$user->id)->first();

            array_push($user_data, (object)[
                'id' => $user->id,
                'fullname' => $user->fullname,
                'rfc' => $user->rfc,
                'email' => $user->email,
                'status_id' => $user->status_id,
                'company_id' => $user->company_id,
                'role_id' => $role_id->role_id,                
            ]);
        }

        return $user_data;
    }


    public function requiredUserData(){
        $required_data = [];

        $roles = Role::all();
        $companies = Companies::all();

        array_push($required_data, (object)[
            'roles'=> $roles,
            'companies' => $companies,
        ]);
        
        return $required_data;
    }

    public function storeUser(Request $request){

        $request->validate([
            'fullname' => 'required',
            'rfc' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'company_id' => 'required'
        ]);

        $encrypted_password = Hash::make($request->password);
        $user = new User();
        $user->fullname = $request->fullname;
        $user->rfc = $request->rfc;
        $user->email = $request->email;
        $user->passwod = $encrypted_password;
        $user->status_id = 1;
        $user->company_id = $request->company_id;
        $user->save();

        $user_id = User::all()->where('fullname',$request->fullname)->last();
        $role_user = new RoleUser();
        $role_user->role_id = $request->id;
        $role_user->user_id = $user_id->id;
        $role_user->user_type = 'App\Models\User';
        $role_user->save();

        return 'usuario creado satisfactoriamente';

    }

    public function editUser($user_id){

        $user_data = [];
        $user = User::all()->where('id',$user_id)->last();
        $role_user = RoleUser::all()->where('user_id',$user->id)->first();
        $role = Role::all()->where('id', $role_user->role_id)->first();

        if($user == null){
            return 'Usuario no encontrado';
        }
        
        array_push($user_data, (object)[
            'id' => $user->id,
            'fullname' => $user->fullname,
            'rfc' => $user->rfc,
            'email' => $user->email,
            'status_id' => $user->status_id,
            'company_id' => $user->company_id,
            'role' => $role->id
        ]);
        return $user_data;
    }

    public function updateUser(Request $request){

        $request->validate([
            'id' => 'required',
            'fullname' => 'required',
            'rfc' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'company_id' => 'required'
        ]);
        
        if($request->password == null || $request->password == ''){
            DB::table('users')->where('id', $request->id)->update([
                'fullname' => $request->fullname, 
                'rfc' => $request->rfc,
                'email' => $request->email,
                'fullname' => $request->fullname,
                'company_id' => $request->company_id,
            ]);
        }else{
            $newPassword = Hash::make($request->password);
            DB::table('users')->where('id', $request->id)->update([
                'fullname' => $request->fullname, 
                'rfc' => $request->rfc,
                'email' => $request->email,
                'password' => $newPassword,
                'fullname' => $request->fullname,
                'company_id' => $request->company_id,
            ]);
        }

        DB::table('role_user')->where('user_id', $request->id)->update([
            'role_id' => $request->role_id, 
        ]);

        return 'usuario actualizado satisfactoriamente';
    }

    public function deleteUser(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        
        DB::table('users')->where('id', $request->id)->update([
            'status_id' => 2, 
        ]);

        return 'usuario eliminado satisfactoriamente';
    }

    public function general(){

        $general_companies = array(
            (object) ['social_reason' =>'BH TRADE MARKET SA DE CV'], 
            (object) ['social_reason' =>  'PROMO LIFE S DE RL DE CV'],
            (object) ['social_reason' =>  'TRADE MARKET 57 SA DE CV'], 
            (object) ['social_reason' =>     'PROMO SALE SA DE CV'],
        );
        $datetime = Carbon::now();
        $date = $datetime->format('Y-m-d');             
        
        $general_orders = [];
       
        
        foreach($general_companies as $company){

            $general_total_to_pay = 0;
            $general_total_debt = 0;
            $general_total_pay = 0;
            $next_calendar_orders = [];

            $orders = Order::select('*')->where('company', $company->social_reason)->orderBy('planned_date', 'asc')->get();
          
            foreach ($orders as $order){
                $total_to_pay = 0;
                $total_debt = 0;
                $total_pay = 0;

                $order_datetime = strtotime($order->planned_date);
                $order_date = date('Y-m-d',$order_datetime);
               
                if($date == $order_date || $date < $order_date){ 
                    array_push($next_calendar_orders, (object)[
                        'planned_date' => $order->planned_date,
                        'total' => $order->total,
                        'status' => $order->status,
                        'payment_status' => $order->payment_status,
                        
                    ]);
                }

                $total_to_pay = $total_to_pay + floatval($order->total);
                $general_total_to_pay =  $general_total_to_pay + floatval($order->total);

                if($order->payment_status == 'Pagado'){
                    $total_pay = $total_pay + floatval($order->total);
                    $general_total_pay = $general_total_pay + floatval($order->total);
                }else{
                    $total_debt = $total_debt + floatval($order->total);
                    $general_total_debt  = $general_total_debt + floatval($order->total);
                }
                
            }

            array_push($general_orders, (object)[
                'company_name' => $company->social_reason,
                'general_total_to_pay' => $general_total_to_pay,
                'general_total_debt' => $general_total_debt,
                'general_total_pay' => $general_total_pay,
                'next_calendar_orders' => $next_calendar_orders,
            ]); 
        }
        
        return $general_orders;

    }

    public function generalInitialInvoinces(Request $request){
        
        //almacenan arreglos de objetos
        $order_data = [];
        $first_month_data = [];
        $second_month_data = [];
        $third_month_data = [];
        $next_order_data = [];

        //contador general 
        $general_total_to_pay = 0;
        $general_total_debt = 0;
        $general_total_pay = 0;

        //contador primer mes
        $first_month_total_to_pay = 0;
        $first_month_total_debt = 0;
        $first_month_total_pay = 0;

        //contador segundo mes
        $second_month_total_to_pay = 0;
        $second_month_total_debt = 0;
        $second_month_total_pay = 0;

        //contador tercer mes
        $third_month_total_to_pay = 0;
        $third_month_total_debt = 0;
        $third_month_total_pay = 0;

        //fecha actual del servidor
        $datetime = Carbon::now();

        //Se debe conocer la fecha actual para obtener las facturas de los dias siguientes del calendario
        $end_date = $datetime->format('Y-m-d');   
        //Las facturas se obtienen de acuerdo al mes y anio abarcando 3 periodos completos, con una duracion de 1 mes cada uno 
        $cut_end_date = $datetime->format('Y-m'); 

        //Se debe guardar la fecha anterior al mes actual (2 meses antes)
        $start = strtotime('-2 months', strtotime($end_date));            
        $cut_start_date = date ( 'Y-m' , $start );

        //Se debe guardar la fecha anterior al mes actual (1 meses antes)
        $second_month = strtotime('-1 months', strtotime($end_date));
        $cut_second_month = date ( 'Y-m' , $second_month );

        $orders = Order::select('*')->orderBy('planned_date', 'asc')->get();
            
        foreach($orders as $order){

            $order_date = strtotime($order->planned_date);
            
            $order_date_with_day = date ( 'Y-m-d' , $order_date);
            $order_date_format = date ( 'Y-m' , $order_date);

            //Primer mes
            if($order_date_format < $cut_second_month && $order_date_format >= $cut_start_date){

                $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                $first_month_total_to_pay =  $first_month_total_to_pay + floatval($order->total);
                if($order->payment_status == 'Pagado'){
                    $general_total_pay = $general_total_pay + floatval($order->total);
                    $first_month_total_pay = $first_month_total_pay + floatval($order->total);
                }else{
                    $general_total_debt  = $general_total_debt + floatval($order->total);
                    $first_month_total_debt  = $first_month_total_debt + floatval($order->total);
                }
                                  
            }
            //Segundo mes
            if($order_date_format >= $cut_second_month && $order_date_format < $cut_end_date  ){

                $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                $second_month_total_to_pay =  $second_month_total_to_pay + floatval($order->total);
                if($order->payment_status == 'Pagado'){
                    $general_total_pay = $general_total_pay + floatval($order->total);
                    $second_month_total_pay = $second_month_total_pay + floatval($order->total);
                }else{
                    $general_total_debt  = $general_total_debt + floatval($order->total);
                    $second_month_total_debt  = $second_month_total_debt + floatval($order->total);
                }    
                
               
            }
            //Tercer mes
            if($order_date_format > $cut_second_month && $order_date_format <= $cut_end_date  ){
                
                $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                $third_month_total_to_pay =  $third_month_total_to_pay + floatval($order->total);
                if($order->payment_status == 'Pagado'){
                    $general_total_pay = $general_total_pay + floatval($order->total);
                    $third_month_total_pay = $third_month_total_pay + floatval($order->total);
                }else{
                    $general_total_debt  = $general_total_debt + floatval($order->total);
                    $third_month_total_debt  = $third_month_total_debt + floatval($order->total);
                }
                     
            }  
            //Ordenes siguientes del calendario
            if($order_date_with_day > $end_date && $order->payment_status <> 'Pagado' ){
                array_push($next_order_data, (object)[
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
                   
                ]);
            }
        }

        array_push($first_month_data, (object)[
            'date' => $cut_start_date,
            'first_month_total_to_pay' => $first_month_total_to_pay,
            'first_month_total_debt' => $first_month_total_debt,
            'first_month_total_pay' => $first_month_total_pay,
        ]);

        array_push($second_month_data, (object)[
            'date' => $cut_second_month,
            'second_month_total_to_pay' => $second_month_total_to_pay,
            'second_month_total_debt' => $second_month_total_debt,
            'second_month_total_pay' => $second_month_total_pay,
        ]);

        array_push($third_month_data, (object)[
            'date' => $cut_end_date,
            'third_month_total_to_pay' => $third_month_total_to_pay,
            'third_month_total_debt' => $third_month_total_debt,
            'third_month_total_pay' => $third_month_total_pay,
        ]);
          
        array_push($order_data, (object)[
            'general_total_to_pay' => $general_total_to_pay,
            'general_total_debt' => $general_total_debt,
            'general_total_pay' => $general_total_pay,
            'first_month_data' => $first_month_data,
            'second_month_data' => $second_month_data,
            'third_month_data' => $third_month_data,
            'next_orders_data' => $next_order_data
        ]);
            
        return $order_data;
       
    }

    public function invoicesByDate(Request $request){
        
        if($request->exists('end')){

            //almacenan arreglos de objetos
            $order_data = [];
            $first_month_data = [];
            $second_month_data = [];
            $third_month_data = [];
            $next_order_data = [];

            //contador general 
            $general_total_to_pay = 0;
            $general_total_debt = 0;
            $general_total_pay = 0;

            //contador primer mes
            $first_month_total_to_pay = 0;
            $first_month_total_debt = 0;
            $first_month_total_pay = 0;

            //contador segundo mes
            $second_month_total_to_pay = 0;
            $second_month_total_debt = 0;
            $second_month_total_pay = 0;

            //contador tercer mes
            $third_month_total_to_pay = 0;
            $third_month_total_debt = 0;
            $third_month_total_pay = 0;

            //fecha actual del servidor
            $datetime = Carbon::now();

            //Se debe conocer la fecha de limie superior de acuerdo a la fecha enviada al usuario
            $end =  strtotime($request->end);
            $end_date = date ( 'Y-m-d' , $end );   
            //Las facturas se obtienen de acuerdo al mes y anio abarcando 3 periodos completos, con una duracion de 1 mes cada uno 
            $cut_end_date = date ( 'Y-m' , $end ); 

            //Se debe guardar la fecha anterior al mes actual (2 meses antes)
            $start = strtotime('-2 months', strtotime($end_date));            
            $cut_start_date = date ( 'Y-m' , $start );

            //Se debe guardar la fecha anterior al mes actual (1 meses antes)
            $second_month = strtotime('-1 months', strtotime($end_date));
            $cut_second_month = date ( 'Y-m' , $second_month );

            $orders = Order::select('*')->orderBy('planned_date', 'asc')->get();
                
            foreach($orders as $order){

                $order_date = strtotime($order->planned_date);
                
                $order_date_with_day = date ( 'Y-m-d' , $order_date);
                $order_date_format = date ( 'Y-m' , $order_date);

                //Primer mes
                if($order_date_format < $cut_second_month && $order_date_format >= $cut_start_date){

                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                    $first_month_total_to_pay =  $first_month_total_to_pay + floatval($order->total);
                    if($order->payment_status == 'Pagado'){
                        $general_total_pay = $general_total_pay + floatval($order->total);
                        $first_month_total_pay = $first_month_total_pay + floatval($order->total);
                    }else{
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                        $first_month_total_debt  = $first_month_total_debt + floatval($order->total);
                    }
                                    
                }
                //Segundo mes
                if($order_date_format >= $cut_second_month && $order_date_format < $cut_end_date  ){

                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                    $second_month_total_to_pay =  $second_month_total_to_pay + floatval($order->total);
                    if($order->payment_status == 'Pagado'){
                        $general_total_pay = $general_total_pay + floatval($order->total);
                        $second_month_total_pay = $second_month_total_pay + floatval($order->total);
                    }else{
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                        $second_month_total_debt  = $second_month_total_debt + floatval($order->total);
                    }    
                    
                
                }
                //Tercer mes
                if($order_date_format > $cut_second_month && $order_date_format <= $cut_end_date  ){
                    
                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                    $third_month_total_to_pay =  $third_month_total_to_pay + floatval($order->total);
                    if($order->payment_status == 'Pagado'){
                        $general_total_pay = $general_total_pay + floatval($order->total);
                        $third_month_total_pay = $third_month_total_pay + floatval($order->total);
                    }else{
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                        $third_month_total_debt  = $third_month_total_debt + floatval($order->total);
                    }
                        
                }  
                //Ordenes siguientes del calendario
                if($order_date_with_day > $end_date && $order->payment_status <> 'Pagado' ){
                    array_push($next_order_data, (object)[
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
                    
                    ]);
                }
            }

            array_push($first_month_data, (object)[
                'date' => $cut_start_date,
                'first_month_total_to_pay' => $first_month_total_to_pay,
                'first_month_total_debt' => $first_month_total_debt,
                'first_month_total_pay' => $first_month_total_pay,
            ]);

            array_push($second_month_data, (object)[
                'date' => $cut_second_month,
                'second_month_total_to_pay' => $second_month_total_to_pay,
                'second_month_total_debt' => $second_month_total_debt,
                'second_month_total_pay' => $second_month_total_pay,
            ]);

            array_push($third_month_data, (object)[
                'date' => $cut_end_date,
                'third_month_total_to_pay' => $third_month_total_to_pay,
                'third_month_total_debt' => $third_month_total_debt,
                'third_month_total_pay' => $third_month_total_pay,
            ]);
            
            array_push($order_data, (object)[
                'general_total_to_pay' => $general_total_to_pay,
                'general_total_debt' => $general_total_debt,
                'general_total_pay' => $general_total_pay,
                'first_month_data' => $first_month_data,
                'second_month_data' => $second_month_data,
                'third_month_data' => $third_month_data,
                'next_orders_data' => $next_order_data
            ]);
                
            return $order_data;

        }
    }
}
