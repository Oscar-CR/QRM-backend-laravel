<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GlobalApiController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'rfc' => 'required',
            'password' => 'required',
        ]);

        $user_data = [];
        $user = User::where('rfc', $request->rfc)->first();
        
        //Valida rfc 
        if($user == null){
            return 'RFC no encontrado, verifica e intentalo de nuevo';
        }
       
        //Valida password encriptado
        if (!Hash::check($request->password, $user->password)) {
            return 'Contraseña incorrecta, verifica e intentalo de nuevo';
        }

        //El proyecto se configuro para un solo token por usuario (se puede camibiar esta condicion)
        //Por lo que se elimina en caso de existir mas de un token
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        //Se crea un nuevo token
        $user->createToken($request->rfc)->plainTextToken;

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

    public function providerOrder(Request $request){
        
    }
}
