<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Facades\UtilityFacades;
use Twilio\Rest\Client;

class SmsTemplate extends Model
{
    use HasFactory;
    protected $table = 'tbl_sms_templates';

    protected $fillable = [
        'event',
        'template',
        'variables',
    ];

    public function send($number, $data)
    {
        $message = __($this->template, $data);
        return $this->__sendSMS($number, $message);
    }

    private function __sendSMS($number, $message)
    {
        try {
            $sid = UtilityFacades::keysettings('TWILIO_SID', 1);
            $token = UtilityFacades::keysettings('TWILIO_AUTH_TOKEN', 1);
            $twilioNumber = UtilityFacades::keysettings('TWILIO_NUMBER', 1);
            $client = new Client($sid, $token);
            $client->messages->create($number, [
                'from' => $twilioNumber,
                'body' => $message
            ]);
            return ['is_success' => true];
        } catch (\Exception $e) {
            return ['is_success' => false, 'message' => $e->getMessage()];
        }
    }
}
