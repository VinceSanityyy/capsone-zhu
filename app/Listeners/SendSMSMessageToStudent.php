<?php

namespace App\Listeners;

use App\Events\SchedulePlotted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSMSMessageToStudent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SchedulePlotted $event)
    {
        return true; //remove this line to enable sms sending
        $apiUsername = config('app.sms.username');
        $apiPassword = config('app.sms.password');
        $userPhone = $event->user->phone_number;
        $text = $event->message;
    
        // Construct the query string and URL (copied from the API documentation)
        $query_string = "api.aspx?apiusername=$apiUsername&apipassword=$apiPassword"
                      . "&senderid=ronald&mobileno=$userPhone"
                      . "&message=" . rawurlencode(stripslashes($text)) . "&languagetype=1";
    
        $url = "http://gateway.onewaysms.com.au:10001/$query_string";
        $fd = @implode('', file($url));
        if ($fd) {
            if ($fd > 0) {
              print("MT ID : " . $fd);
              $ok = "success";
            } else {
              print("Please refer to API on Error : " . $fd);
              $ok = "fail";
            }
          } else {
            // no contact with gateway                      
            $ok = "fail";
          }
          echo $ok;
    }
}
