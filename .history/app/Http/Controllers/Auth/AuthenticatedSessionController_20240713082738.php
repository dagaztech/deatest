<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\HistoricoLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use HTTP_Request2;



function addBasicAuth($header, $username, $password) {
    $header['Authorization'] = 'Basic '.base64_encode("$username:$password");
    return $header;
}

// method should be "GET", "PUT", etc..
function request($method, $url, $header, $params) {
    $opts = array(
        'http' => array(
            'method' => $method,
        ),
    );

    // serialize the header if needed
    if (!empty($header)) {
        $header_str = '';
        foreach ($header as $key => $value) {
            $header_str .= "$key: $value\r\n";
        }
        $header_str .= "\r\n";
        $opts['http']['header'] = $header_str;
    }

    // serialize the params if there are any
    if (!empty($params)) {
        $params_array = array();
        foreach ($params as $key => $value) {
            $params_array[] = "$key=$value";
        }
        $url .= '?'.implode('&', $params_array);
    }

    $context = stream_context_create($opts);
    $data = file_get_contents($url, false, $context);
    return $data;
}





class AuthenticatedSessionController extends Controller
{
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login'); //redirect to login
    }



    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


// $r = Http::withBasicAuth('eventsClient2@23', 'EventsClient2@23')->post('http://api.semdev.netuxcloud.com/api/client/events', [
//                 "healthArrivalDate"=> 1675809484000,
//                 "lat"=> "6.24495",
//                 "lng"=> "-75.59219",
//                 "address"=> "Calle 31 Sur # 32 - 33",
//                 "callerPhone"=> "3122088325",
//                 "callerName"=> "Pedro Sanchez",
//                 "observations"=> "caso de prueba",
//                 "arrivedBy"=> "AMB_MED",
//                 "createdBy"=> "CIGA"
//             ]);

//             print_r($r->body());
























        // $r = Http::withHeaders([
        //     //'header' => "Authorization: Basic " . base64_encode(" eventsClient2@23:EventsClient2@23"),
        //     'Authorization' =>  'Basic '."eventsClient2@23:EventsClient2@23", 'Content-Type' => 'application/json', 'Accept-Encoding' => 'gzip, deflate, br' ])->acceptJson()->post('http://api.semdev.netuxcloud.com/api/client/events', [
        //         "healthArrivalDate"=> 1675809484000,
        //         "lat"=> "6.24495",
        //         "lng"=> "-75.59219",
        //         "address"=> "Calle 31 Sur # 32 - 33",
        //         "callerPhone"=> "3122088325",
        //         "callerName"=> "Pedro Sanchez",
        //         "observations"=> "caso de prueba",
        //         "arrivedBy"=> "AMB_MED",
        //         "createdBy"=> "CIGA"
        //     ]);

        //     print_r($r->body());

        // return "";

        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('auth.login', compact('lang'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOld(LoginRequest $request)
    {
        if (UtilityFacades::getsettings('login_recaptcha_status') == 1) {
            request()->validate([
                'g-recaptcha-response' => 'required',
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if ($user->active_status == 1) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    if ($user->type == 'Admin') {
                        if (Auth::attempt($credentials)) {
                            $request->session()->regenerate();
                            return redirect()->intended(RouteServiceProvider::HOME);
                        } else {
                            return redirect()->back()->with('errors', __('Invalid username or password.'));
                        }
                    } else {
                        if (Auth::attempt($credentials)) {
                            if ($user->phone_verified_at == ''  && UtilityFacades::keysettings('sms_verification', 1) == '1') {
                                $request->session()->regenerate();
                                return redirect()->route('smsindex.noticeverification');
                            } else {
                                $request->session()->regenerate();
                                return redirect()->intended(RouteServiceProvider::HOME);
                            }
                        } else {
                            return redirect()->back()->with('errors', __('Invalid username or password.'));
                        }
                    }
                } else {
                    return redirect()->back()->with('errors', __('Invalid username or password.'));
                }
            } else {
                return redirect()->back()->with('errors', __('Please Contact to administrator.'));
            }
        } else {
            return redirect()->back()->with('errors', __('User not found.'));
        }
    }

    public function store(LoginRequest $request)
    {
        $response = Http::asForm()->post('http://3.14.220.114:8001/api/login', [
        //$response = Http::asForm()->post('http://10.211.55.11:8001/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

 try {
         $token = $response->json()['token'];
        //print_r();
        //print_r($response->body()->token);
        Cookie::queue('laravel_a', 'Bearer '.$token, 90);


$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAsNgIMl7etP1384zVsTtl
mSCVfiBl8YkBHPKt7bzD4ATZJjoPTqK2BCajAVUpQ1HDAtdmKd2vhaE6UtYCWv5g
aBYpy+EtK506J+NLGt7wknXqv0w8eVkhguduKmuGx1p49nUwd1GiZ6d1O/gHIA6Q
YybwlAln/TDclaSHJnECXqTfTMrG92cdlnXUef1c54dHuSP9Qkgf0YXgi5fBBTYb
SnY346vl2OlKZDzH0q2b4myAhdmjUw4le4YOwktS6xVLRjlC161+IuAszTL5veId
q8m5vSiH9s1+NhMnYGbrQmB7WCjdP4RZuW1KNp6wTZg6bmN2smaEnzRCrLY0g0sf
tbMoxVHGxYLmOV8RvhKX7GgPGVo6zh8czcEyVJX18zISOl6g5tK2UDClkCgsb6wt
TQYZ1UADURb5TB5eh8UUKO/yN5TbAdTpHAFy2RdFtpfhAqexRBQo7M7wam5/vqus
FKVKIs7LeWw1K8MFjb7Sj5OFymwoZbw/pAKN3d9INPz4nlvczcgVkpK/umLH7sLM
+U/MPBs+WITbKs3w1ASD12Mu7wjGydpyOggisfzXvTgPNdfgIMTQCTZUDeQfVJSN
lBVaPfdSx7uRSo1iHlavar9oCXpcOk1Fx2R9XNCbWGBkAbTJFW13/tffHT4ax9qy
97hKC/HLlXFBqyY1Y8rYBpMCAwEAAQ==
-----END PUBLIC KEY-----
EOD;

            //$token = explode(" ", $request->cookie('laravel_a'))[1];
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

            $decoded_array = (array) $decoded;
            $decoded_token = $decoded_array['jti'];
            $user_id = DB::table('oauth_access_tokens')->where('id', $decoded_token)->value('user_id');

             
             if(!$user_id){
                return redirect(route('login'));
             }


            $request->headers->set('Authorization', $request->cookie('laravel_a'));

            $rol = DB::table('tbl_users')->where('id', $user_id)->value('rol');


            $usuario = User::where("id", $user_id)->first();
            $log = new HistoricoLog();
            $log->crear($user_id, "Inicio de Sesión", join(",", $request->ips()));
            $log->save();



             //if($rol == "Operativo SSM"){
                //return redirect('user-administrador');
             //}

             if($rol == "Usuario operador 1"){
                return redirect('user-operador1');
             }

                          if($rol == "Usuario operador 2"){
                return redirect('user-operador2');
             }

             if($rol == "Usuario consulta E"){
                return redirect('user-consultaentidad');
             }

             if($rol == "Operativo SSM"){
                return redirect('user-operativo');
             }

             if($rol == "Consulta SSM"){
                return redirect('user-consultassm');
             }



                return redirect('home');


         } catch (\Exception $e) {
                
                 return redirect()->back()->with('errors', __('Usuario o Contraseña incorrectos.'));

         }
       
         return redirect('user-operador1');
       // return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        //Auth::guard('web')->logout();

        //$request->session()->invalidate();

        //$request->session()->regenerateToken();
        //Cookie::forget('laravel_a');



$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAsNgIMl7etP1384zVsTtl
mSCVfiBl8YkBHPKt7bzD4ATZJjoPTqK2BCajAVUpQ1HDAtdmKd2vhaE6UtYCWv5g
aBYpy+EtK506J+NLGt7wknXqv0w8eVkhguduKmuGx1p49nUwd1GiZ6d1O/gHIA6Q
YybwlAln/TDclaSHJnECXqTfTMrG92cdlnXUef1c54dHuSP9Qkgf0YXgi5fBBTYb
SnY346vl2OlKZDzH0q2b4myAhdmjUw4le4YOwktS6xVLRjlC161+IuAszTL5veId
q8m5vSiH9s1+NhMnYGbrQmB7WCjdP4RZuW1KNp6wTZg6bmN2smaEnzRCrLY0g0sf
tbMoxVHGxYLmOV8RvhKX7GgPGVo6zh8czcEyVJX18zISOl6g5tK2UDClkCgsb6wt
TQYZ1UADURb5TB5eh8UUKO/yN5TbAdTpHAFy2RdFtpfhAqexRBQo7M7wam5/vqus
FKVKIs7LeWw1K8MFjb7Sj5OFymwoZbw/pAKN3d9INPz4nlvczcgVkpK/umLH7sLM
+U/MPBs+WITbKs3w1ASD12Mu7wjGydpyOggisfzXvTgPNdfgIMTQCTZUDeQfVJSN
lBVaPfdSx7uRSo1iHlavar9oCXpcOk1Fx2R9XNCbWGBkAbTJFW13/tffHT4ax9qy
97hKC/HLlXFBqyY1Y8rYBpMCAwEAAQ==
-----END PUBLIC KEY-----
EOD;

            $token = explode(" ", $request->cookie('laravel_a'))[1];
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

            $decoded_array = (array) $decoded;
            $decoded_token = $decoded_array['jti'];
            $user_id = DB::table('oauth_access_tokens')->where('id', $decoded_token)->value('user_id');


        $log = new HistoricoLog();
        $log->crear($user_id, "Cierre de Sesión", join(",", $request->ips()));
        $log->save();

        Cookie::queue('laravel_a', '', 90);
        return redirect('/login');
    }
}
