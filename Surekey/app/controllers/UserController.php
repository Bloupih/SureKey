<?php

use Illuminate\Support\MessageBag;

class UserController
extends Controller
{
    public function loginAction()
    {
        $errors = new MessageBag();

        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }

        $data = ["errors" => $errors];

        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "loginUsername" => "required",
                "loginPassword" => "required"
            ]);

            if ($validator->passes())
            {
                $credentials = [
                    "username" => Input::get("loginUsername"),
                    "password" => Input::get("loginPassword")
                ];

                    $auth = 1;
                    $user = DB::table('users')->where('username' , Input::get("loginUsername"))->first();
                    if($user != null)
                    {

                        if( $user->securitylevel == 1 )
                        {
                            if (Auth::attempt($credentials))
                            {
                                return Redirect::route("user/administrator");
                            }
                        }
                        elseif( $user->securitylevel == 2 )
                        {

                            //traitement du password unique ici.

                            /*
                             * 1 - on teste si l'user a un level de securité == 2.
                             * 2 - si c'est le cas, on cherche si l'objet Key where content = input_UniqueKey existe, et si il est associé au bon user.
                             * 3 - si c'est le cas, on delete l'objet Key, on accepte la connexion et on redirige vers l'espace admin.
                             */

                            $uniquePassword = Input::get("loginUniquePassword");

                            if($uniquePassword != null && $uniquePassword != "" )
                            {

                                $key = DB::table('keys')->where('content' , $uniquePassword)->first();
                                if($key == null || $key->accountid != $user->id || $key->status == 0)
                                {
                                    $auth = 0;
                                }


                            }
                            else
                            {
                                $auth = 0;
                            }

                            if ($auth ==1){
                                if (Auth::attempt($credentials))
                                {
                                    $k = Key::find($key->id);
                                    $k->setStatus(0);
                                    $k->save();

                                    return Redirect::route("user/administrator");
                                }
                            }

                        }
                    }
            }
            
            $data["errors"] = new MessageBag([
                "password" => [
                    "Username and/or password invalid."
                ]
            ]);

            $data["username"] = Input::get("username");

            return Redirect::route("user/login")->withInput($data);
        }

        return View::make("user/login", $data);
    }

    public function administratorAction()
    {
        return View::make("user/administrator");
    }

    public function logoutAction()
    {
        Auth::logout();
        return Redirect::route("user/login");
    }

    public function showAction(){

        $user = Auth::user();
        $devices = Device::where('userid', Auth::user()->id)->get();;
        return View::make("user/settings")->with(array('user' => $user , 'devices' => $devices));
    }

    public static function verifyConnection(){

        //$encryptionkey =  "bcb04b7e103a0cd8";

        $deviceKey = Input::get('device');
        $device = Device::where('device' , $deviceKey )->get()->first();
        $error=false;
        if ($device != null){
            $pass = ApiCrypt::decrypt(Input::get("pass"), $device->getPassword());


            $credentials = [
                "username" => Input::get("pseudo"),
                "password" => $pass
            ];

            if (Auth::attempt($credentials))
            {


                if($device != null && $device->userid == Auth::user()->id){
                    UserController::manageSecurityLevel(2);
                    return 1; // OK
                }
            }
            else
            {
                return 0; // login error
            }

        }
        return 2; // device error

    }


    public static function manageSecurityLevel($value){ // function used to check if any device is saved for a chosen account, & if the device connected to the web account at least once. If true, securityLevel.user = 2. If not, = 1.

        $user = Auth::user();
        $user->setSecuritylevel($value);
        $user->save();

    }

}