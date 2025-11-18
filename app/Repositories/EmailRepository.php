<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 3/13/2016
 * Time: 12:06 PM
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Mail;

class EmailRepository
{
    public function sendEmail()
    {
        Mail::send('emails.test',[], function ($message) {
            $message->from('developmentdevelopment58@gmail.com', 'Laravel');

            $message->to('mohe1muzemil@gmail.com');

            $message->subject('test email');
        });
    }
}