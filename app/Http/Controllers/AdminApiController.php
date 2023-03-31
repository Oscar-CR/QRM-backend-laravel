<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProviderCompany;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminApiController extends Controller
{
    public function allOrders($token){

        $user_token = Token::all()->where('token',$token)->first();

        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $user = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$user->id)->where('role_id',2);

        //Los proveedores no pueden ver todas las ordenes
        if(count($role) <> 0){
            return array(['message' =>'Acceso restringido']);
        }

        $general_data = [];
        $company_data = [];
        $order_data = [];
        $product_data = [];

        $companies = ProviderCompany::all();
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
                        'id' => $product->id,
                        'odoo_product_id' => $product->odoo_product_id,
                        'product' => $product->product,
                        'description' => $product->description,
                        'planned_date' => $product->planned_date,
                        'company' => $product->company,
                        'quantity' => $product->quantity,
                        'quantity_delivered' => $product->quantity_delivered,
                        'quantity_invoiced' => $product->quantity_invoiced,
                        'measurement_unit' => $product->measurement_unit,
                        'unit_price' => $product->unit_price,
                        'subtotal' => $product->subtotal,
                        'pucharse_order_id' => $product->pucharse_order_id,
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
                    'products_data' => $product_data
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

    public function allOrdersByCompany($token){

        $user_token = Token::all()->where('token',$token)->first();

        if($user_token == null){
            return  array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $user = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$user->id)->where('role_id',2);

        //Los proveedores no pueden ver todas las ordenes
        if(count($role) <> 0){
            return  array(['message' =>'Acceso restringido']);
        }

        $general_companies = array(
            (object) ['social_reason' => 'BH TRADE MARKET SA DE CV'], 
            (object) ['social_reason' => 'PROMO LIFE'],
            (object) ['social_reason' => 'BH TRADEMARKET'], 
            (object) ['social_reason' => 'PROMO SALE'],
        );

        $general_data = [];
        $general_company_data = [];
        $company_data = [];
        $order_data = [];
        $product_data = [];
        $companies = ProviderCompany::all();
        $general_total_to_pay = 0;
        $general_total_debt = 0;
        $general_total_pay = 0;

        foreach($general_companies as $general_company){

            foreach($companies as $company){  
              
                $orders = Order::all()->where('provider_name',$company->social_reason)->where('company',$general_company->social_reason);  
                $total_orders = 0;
                $total_to_pay = 0;
                $total_debt = 0;
                $total_pay = 0;
                        
                foreach($orders as $order){
                    $total_orders = count($orders);
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
                            'id' => $product->id,
                            'odoo_product_id' => $product->odoo_product_id,
                            'product' => $product->product,
                            'description' => $product->description,
                            'planned_date' => $product->planned_date,
                            'company' => $product->company,
                            'quantity' => $product->quantity,
                            'quantity_delivered' => $product->quantity_delivered,
                            'quantity_invoiced' => $product->quantity_invoiced,
                            'measurement_unit' => $product->measurement_unit,
                            'unit_price' => $product->unit_price,
                            'subtotal' => $product->subtotal,
                            'pucharse_order_id' => $product->pucharse_order_id,
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
                        'products_data' => $product_data
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

            array_push($general_company_data, (object)[
                'social_reason' => $general_company->social_reason,
                'companies'=> $company_data
            ]);
        }
        
        array_push($general_data, (object)[
            'general_total_to_pay' => $general_total_to_pay,
            'general_total_debt' => $general_total_debt,
            'general_total_pay' => $general_total_pay,
            'companies'=> $company_data
        ]);
            
        return $general_company_data;
    }


    public function allUsers($token){
        
        $user_token = Token::all()->where('token',$token)->first();

        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $user = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$user->id)->where('role_id',1);

        //Valida si es administrador
        if(count($role) <> 1){
            return array(['message' =>'Acceso restringido']);
        }

        if($token == null) {

        }

        
        $data = [];
        $users_data = [];
        $providers_data = [];
        $users = User::all();
        foreach($users as $user){

            $roles = RoleUser::all()->where('user_id',$user->id)->last();
            
            //Proveedor
            if($user->local_company_id == null){
                array_push($providers_data, (object)[
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'rfc' => $user->rfc,
                    'email' => $user->email,
                    'status_id' => $user->status_id,
                    'local_company_id' => $user->local_company_id,  
                    'provider_company' => $user->provider_company,
                    'role_id'  =>   $roles->role_id,           
                ]);
            }

            //Usuario
            if($user->provider_company == null){
                array_push($users_data, (object)[
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'rfc' => $user->rfc,
                    'email' => $user->email,
                    'status_id' => $user->status_id,
                    'local_company_id' => $user->local_company_id,  
                    'provider_company' => $user->provider_company,
                    'role_id'  =>   $roles->role_id,           
                ]);
            }

            if($user->provider_company != null && $user->local_company_id != null){
                array_push($users_data, (object)[
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'rfc' => $user->rfc,
                    'email' => $user->email,
                    'status_id' => $user->status_id,
                    'local_company_id' => $user->local_company_id,  
                    'provider_company' => $user->provider_company,
                    'role_id'  =>   $roles->role_id,           
                ]);
            }
            
        }

        array_push($data, (object)[
            'users' => $users_data,
            'providers' => $providers_data,           
        ]);

        return $data;
    }


    public function requiredUserData(){
        $required_data = [];

        $roles = Role::all();
        $companies = ProviderCompany::all();

        array_push($required_data, (object)[
            'roles'=> $roles,
            'companies' => $companies,
        ]);
        
        return $required_data;
    }

    public function storeUser(Request $request){

        $request->validate([
            'fullname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status_id' => 'required',
            'role_id' => 'required',
            'token'=>'required'
        ]);

        $user_token = Token::all()->where('token',$request->token)->first();
        $find_email = User::all()->where('email',$request->email)->all(); 

        if(count($find_email)<>0){
            return array(['message' =>'Este correo ya está en uso']);
        }
        
        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $user = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$user->id)->where('role_id',1);

        //Valida si es administrador
        if(count($role) <> 1){
            return array(['message' =>'Acceso restringido']);
        }

        $encrypted_password = Hash::make($request->password);
        $user = new User();
        $user->fullname = $request->fullname;
        $user->rfc = $request->rfc;
        $user->email = $request->email;
        $user->password = $encrypted_password;
        $user->status_id = 1;
        $user->provider_company = $request->provider_company;
        $user->local_company_id = $request->local_company_id;
        $user->save();

        $user_id = User::all()->where('fullname',$request->fullname)->last();
        $role_user = new RoleUser();
        $role_user->role_id = $request->role_id;
        $role_user->user_id = $user_id->id;
        $role_user->user_type = 'App\Models\User';
        $role_user->save();

        return  array (['message' =>'Usuario creado satisfactoriamente']);

    }

    public function editUser($user_id){

        $user_data = [];
        $user = User::all()->where('id',$user_id)->last();

        if($user == null){
            return array (['message' =>'Usuario no encontrado']) ;
        }
        
        $role_user = RoleUser::all()->where('user_id',$user->id)->first();
        $role = Role::all()->where('id', $role_user->role_id)->first();

       
        array_push($user_data, (object)[
            'id' => $user->id,
            'fullname' => $user->fullname,
            'rfc' => $user->rfc,
            'email' => $user->email,
            'status_id' => $user->status_id,
            'provider_company' => $user->provider_company,
            'local_company_id' => $user->local_company_id,
            'role_id' => $role->id
        ]);
        return $user_data;
    }

    public function updateUser(Request $request){

        $request->validate([
            'id' => 'required',
            'fullname' => 'required',
            'email' => 'required',
            'status_id' => 'required',
            'role_id' =>'required',
            'token' => 'required'
        ]);
        
     
        $user_token = Token::all()->where('token',$request->token)->first();

        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $admin = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$admin->id)->where('role_id',1);

        //Valida si es administrador
        if(count($role) <> 1){
            return array(['message' =>'Acceso restringido']);
        }

        if($request->password == null || $request->password == ''){

            DB::table('users')->where('id', $request->id)->update([
                'fullname' => $request->fullname, 
                'rfc' => $request->rfc,
                'email' => $request->email,
                'status_id' => $request->status_id,
                'provider_company' => $request->provider_company,
                'local_company_id' => $request->local_company_id,
            ]); 
        }else{
            $newPassword = Hash::make($request->password);
            DB::table('users')->where('id', $request->id)->update([
                'fullname' => $request->fullname, 
                'rfc' => $request->rfc,
                'email' => $request->email,
                'password' => $newPassword,
                'status_id' => $request->status_id,
                'provider_company' => $request->provider_company,
                'local_company_id' => $request->local_company_id,
            ]); 
        }

        DB::table('role_user')->where('user_id', $request->id)->update([
            'role_id' => $request->role_id, 
        ]);

        return array (['message' =>'Usuario actualizado satisfactoriamente']);
    }

    public function deleteUser(Request $request){
        
        $request->validate([
            'id' => 'required',
            'token' => 'required'
        ]);
        
        $user_token = Token::all()->where('token',$request->token)->first();

        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $user = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$user->id)->where('role_id',1);

        //Valida si es administrador
        if(count($role) <> 1){
            return array(['message' =>'Acceso restringido']);
        }

        DB::table('users')->where('id', $request->id)->update([
            'status_id' => 2, 
        ]);

        return  array (['message' =>'Usuario eliminado satisfactoriamente']);
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

    public function generalInitialInvoinces(){

        $global_data = [];
        $general_companies = array(
            (object) ['social_reason' =>'BH TRADE MARKET SA DE CV'], 
            (object) ['social_reason' =>  'PROMO LIFE'],
            (object) ['social_reason' =>  'TRADE MARKET'], 
            (object) ['social_reason' =>     'PROMO SALE'],
        );

        foreach($general_companies as $general_company){
            //almacenan arreglos de objetos
            $order_data = [];
            $first_date_data = [];
            $second_date_data = [];
            $third_date_data = [];
            $next_order_data = [];

            //contador general 
            $general_total_to_pay = 0;
            $general_total_debt = 0;
            $general_total_pay = 0;

            //contador primer fecha
            $first_date_total_to_pay = 0;
            $first_date_total_debt = 0;
            $first_date_total_pay = 0;

            //contador segunda fecha
            $second_date_total_to_pay = 0;
            $second_date_total_debt = 0;
            $second_date_total_pay = 0;

            //contador tercer fecha
            $third_date_total_to_pay = 0;
            $third_date_total_debt = 0;
            $third_date_total_pay = 0;

            //fecha actual del servidor
            $datetime = Carbon::now();

            //Se debe conocer la fecha actual para obtener las facturas de los dias siguientes del calendario
            $end_date = $datetime->format('Y-m-d');   
           
            //Se debe guardar la fecha anterior al mes actual (2 meses antes)
            $start = strtotime('-2 months', strtotime($end_date));            
            $start_date = date ( 'Y-m-d' , $start );

            //Se debe guardar la fecha anterior al mes actual (1 meses antes)
            $middle_month = strtotime('-1 months', strtotime($end_date));
            $middle_date = date ( 'Y-m-d' , $middle_month );

            $orders = Order::select('*')->where('company',$general_company->social_reason)->orderBy('planned_date', 'asc')->get();
                
            foreach($orders as $order){

                $order_date = strtotime($order->planned_date);
                
                $order_format_date = date ( 'Y-m-d' , $order_date);
               
                //Primer mes
                if($order_format_date < $middle_date && $order_format_date >= $start_date){

                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                    $first_date_total_to_pay =  $first_date_total_to_pay + floatval($order->total);
                    if($order->payment_status == 'Pagado'){
                        $general_total_pay = $general_total_pay + floatval($order->total);
                        $first_date_total_pay = $first_date_total_pay + floatval($order->total);
                    }else{
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                        $first_date_total_debt  = $first_date_total_debt + floatval($order->total);
                    }
                                    
                }
                //Segundo mes
                if($order_format_date >= $middle_date && $order_format_date < $end_date  ){

                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                    $second_date_total_to_pay =  $second_date_total_to_pay + floatval($order->total);
                    if($order->payment_status == 'Pagado'){
                        $general_total_pay = $general_total_pay + floatval($order->total);
                        $second_date_total_pay = $second_date_total_pay + floatval($order->total);
                    }else{
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                        $second_date_total_debt  = $second_date_total_debt + floatval($order->total);
                    }    
                    
                }
                //Tercer mes
                if($order_format_date > $middle_date && $order_format_date <= $end_date  ){
                    
                    $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                    $third_date_total_to_pay =  $third_date_total_to_pay + floatval($order->total);
                    if($order->payment_status == 'Pagado'){
                        $general_total_pay = $general_total_pay + floatval($order->total);
                        $third_date_total_pay = $third_date_total_pay + floatval($order->total);
                    }else{
                        $general_total_debt  = $general_total_debt + floatval($order->total);
                        $third_date_total_debt  = $third_date_total_debt + floatval($order->total);
                    }
                        
                }  
                //Ordenes siguientes del calendario
                if($order_format_date > $end_date && $order->payment_status <> 'Pagado' ){
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

            array_push($first_date_data, (object)[
                'date' => $start_date,
                'first_date_total_to_pay' => $first_date_total_to_pay,
                'first_date_total_debt' => $first_date_total_debt,
                'first_date_total_pay' => $first_date_total_pay,
            ]);

            array_push($second_date_data, (object)[
                'date' => $middle_date,
                'second_date_total_to_pay' => $second_date_total_to_pay,
                'second_date_total_debt' => $second_date_total_debt,
                'second_date_total_pay' => $second_date_total_pay,
            ]);

            array_push($third_date_data, (object)[
                'date' => $end_date,
                'third_date_total_to_pay' => $third_date_total_to_pay,
                'third_date_total_debt' => $third_date_total_debt,
                'third_date_total_pay' => $third_date_total_pay,
            ]);
            
            array_push($order_data, (object)[
                'general_total_to_pay' => $general_total_to_pay,
                'general_total_debt' => $general_total_debt,
                'general_total_pay' => $general_total_pay,
                'first_date_data' => $first_date_data,
                'second_date_data' => $second_date_data,
                'third_date_data' => $third_date_data,
                'next_orders_data' => $next_order_data
            ]);
            array_push($global_data, (object)[
                'social_reason' => $general_company->social_reason,
                'order_data' => $order_data,
            ]);

        }
        
        return $global_data;
       
    }

    public function invoicesByDate(Request $request){
        
        if($request->exists('end')){

            $global_data = [];
            $general_companies = array(
                (object) ['social_reason' =>'BH TRADE MARKET SA DE CV'], 
                (object) ['social_reason' => 'PROMO LIFE'],
                (object) ['social_reason' => 'TRADE MARKET'], 
                (object) ['social_reason' => 'PROMO SALE'],
            );
    
            foreach($general_companies as $general_company){
                //almacenan arreglos de objetos
                $order_data = [];
                $first_date_data = [];
                $second_date_data = [];
                $third_date_data = [];
                $next_order_data = [];
    
                //contador general 
                $general_total_to_pay = 0;
                $general_total_debt = 0;
                $general_total_pay = 0;
    
                //contador primer fecha
                $first_date_total_to_pay = 0;
                $first_date_total_debt = 0;
                $first_date_total_pay = 0;
    
                //contador segunda fecha
                $second_date_total_to_pay = 0;
                $second_date_total_debt = 0;
                $second_date_total_pay = 0;
    
                //contador tercer fecha
                $third_date_total_to_pay = 0;
                $third_date_total_debt = 0;
                $third_date_total_pay = 0;
    
                //Se debe conocer la fecha actual para obtener las facturas de los dias siguientes del calendario
                $end = strtotime($request->end);
                $end_date = date ( 'Y-m-d' , $end);   
               
                //Se debe guardar la fecha anterior al mes actual (2 meses antes)
                $start = strtotime('-2 months', strtotime($end_date));            
                $start_date = date ( 'Y-m-d' , $start );
    
                //Se debe guardar la fecha anterior al mes actual (1 meses antes)
                $middle_month = strtotime('-1 months', strtotime($end_date));
                $middle_date = date ( 'Y-m-d' , $middle_month );

                $orders = Order::select('*')->where('company',$general_company->social_reason)->orderBy('planned_date', 'asc')->get();
                    
                foreach($orders as $order){

                    $order_date = strtotime($order->planned_date);
                    
                    $order_format_date = date ( 'Y-m-d' , $order_date);
                   
                    //Primer mes
                    if($order_format_date < $middle_date && $order_format_date >= $start_date){
    
                        $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                        $first_date_total_to_pay =  $first_date_total_to_pay + floatval($order->total);
                        if($order->payment_status == 'Pagado'){
                            $general_total_pay = $general_total_pay + floatval($order->total);
                            $first_date_total_pay = $first_date_total_pay + floatval($order->total);
                        }else{
                            $general_total_debt  = $general_total_debt + floatval($order->total);
                            $first_date_total_debt  = $first_date_total_debt + floatval($order->total);
                        }
                                        
                    }
                    //Segundo mes
                    if($order_format_date >= $middle_date && $order_format_date < $end_date  ){
    
                        $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                        $second_date_total_to_pay =  $second_date_total_to_pay + floatval($order->total);
                        if($order->payment_status == 'Pagado'){
                            $general_total_pay = $general_total_pay + floatval($order->total);
                            $second_date_total_pay = $second_date_total_pay + floatval($order->total);
                        }else{
                            $general_total_debt  = $general_total_debt + floatval($order->total);
                            $second_date_total_debt  = $second_date_total_debt + floatval($order->total);
                        }    
                        
                    }
                    //Tercer mes
                    if($order_format_date > $middle_date && $order_format_date <= $end_date  ){
                        
                        $general_total_to_pay =  $general_total_to_pay + floatval($order->total);
                        $third_date_total_to_pay =  $third_date_total_to_pay + floatval($order->total);
                        if($order->payment_status == 'Pagado'){
                            $general_total_pay = $general_total_pay + floatval($order->total);
                            $third_date_total_pay = $third_date_total_pay + floatval($order->total);
                        }else{
                            $general_total_debt  = $general_total_debt + floatval($order->total);
                            $third_date_total_debt  = $third_date_total_debt + floatval($order->total);
                        }
                            
                    }  
                    //Ordenes siguientes del calendario
                    if($order_format_date > $end_date && $order->payment_status <> 'Pagado' ){
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
    
                array_push($first_date_data, (object)[
                    'date' => $start_date,
                    'first_date_total_to_pay' => $first_date_total_to_pay,
                    'first_date_total_debt' => $first_date_total_debt,
                    'first_date_total_pay' => $first_date_total_pay,
                ]);
    
                array_push($second_date_data, (object)[
                    'date' => $middle_date,
                    'second_date_total_to_pay' => $second_date_total_to_pay,
                    'second_date_total_debt' => $second_date_total_debt,
                    'second_date_total_pay' => $second_date_total_pay,
                ]);
    
                array_push($third_date_data, (object)[
                    'date' => $end_date,
                    'third_date_total_to_pay' => $third_date_total_to_pay,
                    'third_date_total_debt' => $third_date_total_debt,
                    'third_date_total_pay' => $third_date_total_pay,
                ]);
                
                array_push($order_data, (object)[
                    'general_total_to_pay' => $general_total_to_pay,
                    'general_total_debt' => $general_total_debt,
                    'general_total_pay' => $general_total_pay,
                    'first_date_data' => $first_date_data,
                    'second_date_data' => $second_date_data,
                    'third_date_data' => $third_date_data,
                    'next_orders_data' => $next_order_data
                ]);
                array_push($global_data, (object)[
                    'social_reason' => $general_company->social_reason,
                    'order_data' => $order_data,
                ]);
    
            }
            
            return $global_data;
        }else{
            return array(['message' =>'ordenes no disponibles en fecha seleccionada']);
        }
    }

    public function updateOrderStatus(Request $request)
    { 
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
            'token' => 'required',
        ]);

        $user_token = Token::all()->where('token',$request->token)->first();

        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        //$Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4
        $user = User::all()->where('id',$user_token->tokenable_id)->first();
        $role = RoleUser::all()->where('user_id',$user->id)->where('role_id',1);

        //Valida si es administrador
        if(count($role) <> 1){
            return array(['message' =>'Acceso restringido']);
        }

        DB::table('orders')->where('id', $request->order_id)->update([
            'payment_status' => intval($request->status) 
        ]);

        return array(['message' =>'Orden actualizada correctamente']);

    }
}
