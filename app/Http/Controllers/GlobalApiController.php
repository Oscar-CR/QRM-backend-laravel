<?php

namespace App\Http\Controllers;

use App\Mail\RecoveryMail;
use App\Models\ProviderCompany;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class GlobalApiController extends Controller
{
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user_data = [];
        $provider_data = [];
        $user = User::where('email', $request->email)->first();
        $provider = ProviderCompany::where('email', $request->email)->first();
        //Valida rfc 
        if($user != null){

            //Valida password encriptado
            if (!Hash::check($request->password, $user->password)) {
                return array(['message' =>'Contraseña incorrecta, verifica e intentalo de nuevo']); 
            }

            //El proyecto se configuro para un solo token por usuario (se puede camibiar esta condicion)
            //Por lo que se elimina en caso de existir mas de un token
            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
            //Se crea un nuevo token
            $user->createToken($request->email)->plainTextToken;

            $token =  DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->value('token');

            $role_user = RoleUser::all()->where('user_id',$user->id)->first();
            
            $role = Role::all()->where('id', $role_user->role_id)->first();

            array_push($user_data, (object)[
                'fullname' => $user->fullname,
                'token' => $token,
                'role' => $role->display_name,
            ]);
            
            return $user_data;

        }elseif($provider != null){

            if(!Hash::check($request->password, $provider->password)){
                return array(['message' =>'Contraseña incorrecta, verifica e intentalo de nuevo']); 
            }

            //El proyecto se configuro para un solo token por usuario (se puede camibiar esta condicion)
            //Por lo que se elimina en caso de existir mas de un token
            DB::table('provider_access_tokens')->where('tokenable_id', $user->id)->delete();
            //Se crea un nuevo token
            $provider->createToken($request->email)->plainTextToken;

            $token =  DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->value('token');

            array_push($provider_data, (object)[
                'fullname' => $user->fullname,
                'token' => $token,
                'role' => 'Proveedor',
            ]);
            
            return $provider_data;
        
        }elseif($user != null && $provider != null ){
            return array(['message' =>'Email no encontrado, verifica e intentalo de nuevo']); 
        }
        
    }

    public function loginUser(Request $request)
    {
       
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user_data = [];
        $user = User::where('email', $request->email)->first();
        
        //Valida si el usuario existe 
        if($user == null){
            return array(['message' =>'Email no encontrado, verifica e intentalo de nuevo']); 
        }
       
        //Valida password encriptado
        if (!Hash::check($request->password, $user->password)) {
            return array(['message' =>'Contraseña incorrecta, verifica e intentalo de nuevo']); 
        }

        //El proyecto se configuro para un solo token por usuario (se puede camibiar esta condicion)
        //Por lo que se elimina el token, cuando el usuario inicio sesion nuevamente
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        //Se crea un nuevo token
        $user->createToken($request->email)->plainTextToken;

        $token =  DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->value('token');

        $role_user = RoleUser::all()->where('user_id',$user->id)->first();
        
        $role = Role::all()->where('id', $role_user->role_id)->first();

        array_push($user_data, (object)[
            'fullname' => $user->fullname,
            'token' => $token,
            'role' => $role->display_name,
            'provider_company' => $user->provider_company,
            'local_company_id' => $user->local_company_id,  
        ]);
        
        return $user_data;
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $user = User::all()->where('email', $request->email)->first();
        
        if($user == null){
            return array(['message' =>'Usuario no encontrado']);
        }

        $new_password = Str::random(10);
        $encrypted_password = Hash::make($new_password);

        DB::table('users')->where('id', $user->id)->update([
            'password' => $encrypted_password, 
        ]);

        try {
            Mail::to($user->email)->send(new RecoveryMail($user->email,$new_password));
            DB::table('personal_access_tokens')->where('name', $request->email)->delete();
        } catch (\Exception $e) {
        }
        
        return array(['message' =>'Email enviado con exito']);
    }

    
}
