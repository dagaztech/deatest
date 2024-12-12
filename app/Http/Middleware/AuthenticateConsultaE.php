<?php

namespace App\Http\Middleware;


use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Auth;
use DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTime;

use Closure;
class AuthenticateConsultaE extends Middleware
{

    
    public function handle($request, Closure $next, ...$guards){
      
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

        try {

            $encoded_token = explode(" ", $request->cookie('laravel_a'))[1];
            $decoded = JWT::decode($encoded_token, new Key($publicKey, 'RS256'));

            $decoded_array = (array) $decoded;
            $decoded_token = $decoded_array['jti'];
            $user_id = DB::table('oauth_access_tokens')->where('id', $decoded_token)->value('user_id');

            $expires = DB::table('oauth_access_tokens')->where('id', $decoded_token)->value('created_at');
            $cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($expires)));
            $now = new DateTime(); //now
            $cenvertedTimee = new DateTime($cenvertedTime); //now
            if($now > $cenvertedTimee){
                return redirect(route('login'));
            }

             
             if(!$user_id){
                return redirect(route('login'));
             }


            $request->headers->set('Authorization', $request->cookie('laravel_a'));

            $rol = DB::table('tbl_users')->where('id', $user_id)->value('rol');

             if($rol != "Usuario consulta E"){
                //return redirect(route('login'));
             } 

            //return $next($request);
            $response = $next($request);

            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
    
            return $response;

        } catch (\Exception $e) {
                return redirect(route('login'));
        }

        
    }
     
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        print_r($request->cookie('laravel_a'));
        echo "adadadad";
        echo "===";
        //echo Auth::guard('api')->check();
        print_r(Auth::guard('api')->user());
        echo "===";
        echo "adadadad";
        $request->headers->set('Authorization', $request->cookie('laravel_a'));
        
        if (!$request->expectsJson()) {
            //return route('login');
        }
            //return route('login');
        //return null;
    }
}
