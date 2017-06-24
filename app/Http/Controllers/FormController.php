<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Classes\ContactHelper as ContactHelper;

class FormController extends Controller
{
    /**
     * Endpoint action for submission of the contact form through AJAX request
     *
     * @param ContactFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxContactForm(ContactFormRequest $request) {

        $input = $request->all();

        $contactHelper = new ContactHelper();
        list($contact, $status) = $contactHelper->addContactRequest($input);

        return response()->json([
            'name'    => $contact->name,
            'email'   => $contact->email,
            'phone'   => $contact->phone,
            'message' => $contact->message,
            'status'  => $status
        ]);
    }
}
