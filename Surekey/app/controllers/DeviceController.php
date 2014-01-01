<?php

class DeviceController extends BaseController{

    public function addDevice(){

        $device = new Device;
        $device->setDevice(Input::get('device'));
        $device->setPassword($this->randomPassword(16));
        $device->setDescription("Device");
        $device->setUserId(Auth::user()->id);
        $device->save();
        return Redirect::route("user/settings");
    }

    public function deleteDevice(){

        $device = Device::find(Input::get('deviceId'));
        if(Auth::check() && $device!= null )
        if (   (Auth::user()->id) == $device->getUserid() ){
            $device->delete();

            // check si des devices sont encore présentes pour cet user. Sinon, on passe le security level à 1.

            $devices = DB::table('devices')->where('userid', Auth::user()->id)->get();
            if($devices == null)
            {
                UserController::manageSecurityLevel(1);
                return Redirect::route("user/settings");
            }
        }

        return Redirect::route("user/settings");

    }


    private function randomPassword($taille) {
        $password = "";
        $chaine = "abcdefghijklmnpqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$taille; $i++) {
            $password .= $chaine[rand()%strlen($chaine)];
        }
        return $password;
    }

}