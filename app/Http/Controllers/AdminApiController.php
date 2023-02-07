<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                        'payment_status'=> $order->payment_status,
                        'product' => $product_data
                        
                    ]);

                    array_push($company_data, (object)[
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

}
