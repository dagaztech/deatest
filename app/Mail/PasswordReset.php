<?php

namespace App\Mail;

use Spatie\MailTemplates\TemplateMailable;

class PasswordReset extends TemplateMailable
{
    //protected $table = 'tbl_password_resets';

    public $password;

    public function __construct($user, $password)
    {
        $this->password = $password;
        //$this->url = $url;
        //$this->$table = 'tbl_password_resets';
    }
    
    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }
}
