<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use Mail;

class FormController extends Controller
{
    public function ajaxContactForm(ContactFormRequest $request) {

        $input = $request->all();


        $name = $input['name'];
        $email = $input['email'];
        $userMessage = $input['message'];
        if ($input['phone']) {
            $phone = $input['phone'];
        }
        $emailOptions = array(
            'name' => $name,
            'email' => $email,
            'userMessage' => $userMessage
        );
        if (isset($phone)) {
            $emailOptions['phone'] = $phone;
        }
        // Send mail
        //Mail::pretend();

        Mail::send('emails.contact', $emailOptions, function($message) {
            $message->to('5e4a986243-1aba8e@inbox.mailtrap.io', 'Guy Smiley');
            $message->subject('Contact request');
        });

        return response()->json([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'status' => $status
        ]);
    }
}
