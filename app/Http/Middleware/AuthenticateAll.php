<?php

namespace App\Http\Middleware;

/*
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
*/

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Auth;
use DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use DateTime;

use Closure;
class AuthenticateAll extends Middleware
{

    
    public function handle($request, Closure $next, ...$guards){
        //echo "zzzzzzzzzzzzzzzzzzzzzzz";
        //print_r($request->cookie('otra'));
        //$request->headers->set('Authorization', $request->cookie('otra'));

        //$request->header->$requestadd($parameter);

        //$response = $next($request);

     //$user_id = DB::table('oauth_access_tokens')->where('id', trim($request->cookie('otra')))->value('user_id');
     #$user = \App\User::find($user_id);
     #Auth::login($user, true);
       // echo $user_id;
        //echo "////";

$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAuzWHNM5f+amCjQztc5QTfJfzCC5J4nuW+L/aOxZ4f8J3Frew
M2c/dufrnmedsApb0By7WhaHlcqCh/ScAPyJhzkPYLae7bTVro3hok0zDITR8F6S
JGL42JAEUk+ILkPI+DONM0+3vzk6Kvfe548tu4czCuqU8BGVOlnp6IqBHhAswNMM
78pos/2z0CjPM4tbeXqSTTbNkXRboxjU29vSopcT51koWOgiTf3C7nJUoMWZHZI5
HqnIhPAG9yv8HAgNk6CMk2CadVHDo4IxjxTzTTqo1SCSH2pooJl9O8at6kkRYsrZ
WwsKlOFE2LUce7ObnXsYihStBUDoeBQlGG/BwQIDAQABAoIBAFtGaOqNKGwggn9k
6yzr6GhZ6Wt2rh1Xpq8XUz514UBhPxD7dFRLpbzCrLVpzY80LbmVGJ9+1pJozyWc
VKeCeUdNwbqkr240Oe7GTFmGjDoxU+5/HX/SJYPpC8JZ9oqgEA87iz+WQX9hVoP2
oF6EB4ckDvXmk8FMwVZW2l2/kd5mrEVbDaXKxhvUDf52iVD+sGIlTif7mBgR99/b
c3qiCnxCMmfYUnT2eh7Vv2LhCR/G9S6C3R4lA71rEyiU3KgsGfg0d82/XWXbegJW
h3QbWNtQLxTuIvLq5aAryV3PfaHlPgdgK0ft6ocU2de2FagFka3nfVEyC7IUsNTK
bq6nhAECgYEA7d/0DPOIaItl/8BWKyCuAHMss47j0wlGbBSHdJIiS55akMvnAG0M
39y22Qqfzh1at9kBFeYeFIIU82ZLF3xOcE3z6pJZ4Dyvx4BYdXH77odo9uVK9s1l
3T3BlMcqd1hvZLMS7dviyH79jZo4CXSHiKzc7pQ2YfK5eKxKqONeXuECgYEAyXlG
vonaus/YTb1IBei9HwaccnQ/1HRn6MvfDjb7JJDIBhNClGPt6xRlzBbSZ73c2QEC
6Fu9h36K/HZ2qcLd2bXiNyhIV7b6tVKk+0Psoj0dL9EbhsD1OsmE1nTPyAc9XZbb
OPYxy+dpBCUA8/1U9+uiFoCa7mIbWcSQ+39gHuECgYAz82pQfct30aH4JiBrkNqP
nJfRq05UY70uk5k1u0ikLTRoVS/hJu/d4E1Kv4hBMqYCavFSwAwnvHUo51lVCr/y
xQOVYlsgnwBg2MX4+GjmIkqpSVCC8D7j/73MaWb746OIYZervQ8dbKahi2HbpsiG
8AHcVSA/agxZr38qvWV54QKBgCD5TlDE8x18AuTGQ9FjxAAd7uD0kbXNz2vUYg9L
hFL5tyL3aAAtUrUUw4xhd9IuysRhW/53dU+FsG2dXdJu6CxHjlyEpUJl2iZu/j15
YnMzGWHIEX8+eWRDsw/+Ujtko/B7TinGcWPz3cYl4EAOiCeDUyXnqnO1btCEUU44
DJ1BAoGBAJuPD27ErTSVtId90+M4zFPNibFP50KprVdc8CR37BE7r8vuGgNYXmnI
RLnGP9p3pVgFCktORuYS2J/6t84I3+A17nEoB4xvhTLeAinAW/uTQOUmNicOP4Ek
2MsLL2kHgL8bLTmvXV4FX+PXphrDKg1XxzOYn0otuoqdAQrkK4og
-----END RSA PRIVATE KEY-----
EOD;

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

            return $next($request);

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
