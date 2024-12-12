<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
//use App\Mail;
use Mail;
use App\Mail\ConatctMail;
use App\Mail\RestauracionContrasena;
//use Illuminate\Support\Facades\Mail;
use DB;
use App\Models\User;
use App\Models\HistoricoLog;



class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lang = UtilityFacades::getActiveLanguage();
        \App::setLocale($lang);
        return view('auth.forgot-password', compact('lang'));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (UtilityFacades::getsettings('login_recaptcha_status') == 1) {
            request()->validate([
                'g-recaptcha-response' => 'required',
            ]);
        }
        request()->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where("email", $request->email)->first();

        //print_r($user);

        $contrasenia = "Dea-2024.$";

        
        if(!$user){
            return back()->withInput($request->only('email'))->with('errors', "No se ha encontrado el correo ingresado");
        }


        $user->password = bcrypt("Dea-2024.$");
        $user->save();

            
        $to = [
            [
                'email' => $request->email, 
                'name' => $request->name,
            ]
        ];

        \Mail::mailer('smtp')->to($to)
            ->send(new RestauracionContrasena("",$contrasenia));


        $log = new HistoricoLog();
        $log->crear($userId, "Cambio contraseña: ", join(",", $request->ips()));
        $log->save();

        //if ($status != Password::RESET_LINK_SENT) {
            //return back()->withInput($request->only('email'))->with('errors', __($status));
        //}
        return back()->with('status', "Se ha enviado un correo con instrucciones para recuperar su contraseña");
    }
}
