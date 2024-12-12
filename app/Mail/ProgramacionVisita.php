<?php

namespace App\Mail;

use Spatie\MailTemplates\TemplateMailable;

class ProgramacionVisita extends TemplateMailable
{
    public $email;
    public $name;
    public $contactNo;
    public $message;
    public $password;
    // protected $table = 'tbl_mail_templates';

    public function __construct($details)
    {
        $this->name = $details['name'];
    }

    public function getHtmlLayout(): string
    {
        return view('emails.layout')->render();
    }

    
    
}
