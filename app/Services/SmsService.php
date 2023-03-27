<?php

namespace App\Services;

use Vonage\Client\Credentials\Basic;
use Vonage\Client;

class SmsService
{
    public function sendSMS()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("b75fc944", "fgACslIlDtivREM4");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("84365774667", 'Vonage APIs', 'A text message sent using the Nexmo SMS API')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
