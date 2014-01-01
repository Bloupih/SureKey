<?php

class KeyController extends BaseController{

    public function newUniquePassword(){

        //$encryptionkey =  "bcb04b7e103a0cd8"; debug
        $connexion  = UserController::verifyConnection();
        if( $connexion == 1 )
        {
            $deviceKey = Input::get('device');
            $device = Device::where('device' , $deviceKey )->get()->first();

            $length = 13;
            $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);

            DB::table('keys')
                ->where('accountid', Auth::User()->id )
                ->update(array('status' => 0));

            $key = new Key;
            $key->setContent($randomString);
            $key->setAccountid(Auth::User()->id);
            $key->setDeviceid($device->id);
            $key->setStatus(1);

            $key->save();


            $crypted =  ApiCrypt::encrypt($randomString, $device->getPassword());

            Auth::logout();
            return Response::json($crypted);
        }
        elseif( $connexion == 0)
        {
            return Response::json("authError");
        }
        elseif ($connexion == 2)
        {
            return Response::json("deviceError");
        }

    }

}