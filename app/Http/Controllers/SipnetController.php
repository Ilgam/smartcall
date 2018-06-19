<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SipnetController extends Controller
{
    protected $fields;

    public function __construct($sip_uid, $sip_password)
    {
        $this->middleware('auth');

        $this->fields = [
            "sipuid" => $sip_uid,
            "password" => $sip_password,
            "format" => "2",
            "lang" => "ru"
        ];
    }

    public function request($fields, $json = true)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, getenv('SIPNET_API_HOST'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        if ($json){
            return json_decode($response);
        }else{
            return $response;
        }
    }

    public function getCidButton($phone)
    {
        $fields = [
            "operation" => "addwebbutton",
            "phone" => $phone,
        ];
        $this->fields['format'] = 1;

        $this->fields = array_collapse([$this->fields, $fields]);

        $cid = $this->request($this->fields, false);

        return $cid;
    }
}
