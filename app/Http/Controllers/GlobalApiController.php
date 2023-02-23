<?php

namespace App\Http\Controllers;

use App\Mail\RecoveryMail;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class GlobalApiController extends Controller
{
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user_data = [];
        $user = User::where('email', $request->email)->first();
        
        //Valida rfc 
        if($user == null){
            return array(['message' =>'Email no encontrado, verifica e intentalo de nuevo']); 
        }
       
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
    }

    public function loginUser(Request $request)
    {
        $request->header('Access-Control-Allow-Origin', '*');

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user_data = [];
        $user = User::where('email', $request->email)->first();
        
        //Valida rfc 
        if($user == null){
            return array(['message' =>'Email no encontrado, verifica e intentalo de nuevo']); 
        }
       
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
