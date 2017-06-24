<?php

namespace App\Classes;

use App\Contact as Contact;
use Mail;

class ContactHelper {

    /**
     * Extract the contact request details from the supplied input array and save them to the database for review
     * Also send the email to the required email address and react on disposition of the email failures. If there were failures
     * delete the contact request record and return an error code.
     *
     * @param array $input
     * @return number | \App\Contact
     */
    public function addContactRequest($input) {
        $name        = $input['name'];
        $email       = $input['email'];
        $userMessage = $input['message'];

        if ($input['phone']) {
            $phone = $input['phone'];
        } else {
            $phone = null;
        }

        $emailOptions = [
            'name'        => $name,
            'email'       => $email,
            'userMessage' => $userMessage
        ];
        if (isset($phone)) {
            $emailOptions['phone'] = $phone;
        }
        $contact = $this->saveNewContact($name, $email, $userMessage, $phone);
        $status  = $this->sendContactRequestEmail($emailOptions, $contact);
        return array($contact, $status);
    }

    /**
     * Save the database entry for the contact record
     *
     * @param string $name
     * @param string $email
     * @param string $userMessage
     * @param string $phone
     */
    protected function saveNewContact($name, $email, $userMessage, $phone) {
        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->message = $userMessage;
        if (isset($phone)) {
            $contact->phone = $phone;
        }
        $contact->save();
        return $contact;
    }

    /**
     * Attempt to send an email using the configured mail transport service. If there are errors, react
     * accordingly and return an error status code.
     *
     * @param array $emailOptions
     * @param Contact $contact
     * @return number
     */
    protected function sendContactRequestEmail($emailOptions, Contact $contact) {
        Mail::send('emails.contact', $emailOptions, function($message) {
            $message->from('contact@example.com', 'Contact Request');
            $message->to('guy-smiley@example.com', 'Guy Smiley');
            $message->subject('Contact request');
        });
        if (count(Mail::failures()) > 0) {
            $status = 500;
            $contact->delete();
        } else {
            $status = 200;
        }
        return $status;
    }
}