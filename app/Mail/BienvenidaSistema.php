<?php

namespace App\Mail;

use Spatie\MailTemplates\TemplateMailable;

class BienvenidaSistema extends TemplateMailable
{
    public $email;
    public $name;
    public $contactNo;
    public $message;
    public $password;
    protected $table = 'tbl_mail_templates';

    public function __construct($details)
    {
        $this->name         = $details['name'];
        // $this->email        = $details['email'];
        // $this->contactNo    = $details['contact_no'];
        // $this->message      = $details['message'];
        $this->password      = $details['password'];
    }

    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }

    
    
}
