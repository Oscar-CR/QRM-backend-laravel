<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
    public function blackList(Request $request)
    {
        if($request->rfc == null){
            return array(['message' =>'RFC vacio, verifica e intentalo nuevamente']);
        }

        $api_url = 'https://www.boxfactura.com/';
        

        $api_user ='GF7Db';
        $api_key = '2zKE_kfA6VfXZvVxE8Nx';

        $params = [
        'usuario_uid' => $api_user,
        'usuario_key' => $api_key,
        'rfc' => $request->rfc
        ];
        
        $query = http_build_query($params);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . 'api/v0.1/listanegra/revision');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $result = curl_exec($ch);
    
        curl_close($ch);

        return json_encode($result);
    }
}
