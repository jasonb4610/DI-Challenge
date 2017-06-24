<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class CreateContactTest extends TestCase
{
    use DatabaseTransactions;

    public function testValidStatusReturnedFromCreateContactNoPhone()
    {
        config(['mail.driver' => 'log']);
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(200);
    }

    public function testValidDataReturnedFromCreateContactNoPhone()
    {
        config(['mail.driver' => 'log']);
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $expectedData = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => null, 'status' => 200];
        $response->assertExactJson($expectedData);
    }

    public function testValidStatusReturnedFromCreateContactWithPhone() 
    {
        config(['mail.driver' => 'log']);
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => '7576509978'];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(200);
    }

    public function testValidDataReturnedFromCreateContactWithPhone()
    {
        config(['mail.driver' => 'log']);
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => '7576509978'];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $expectedData = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => '7576509978', 'status' => 200];
        $response->assertExactJson($expectedData);
    }

    public function testErrorCodeReturnedFromBadDataNoPhoneBadName()
    {
        $data = ['name' => '48390840', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(422);
    }

    public function testErrorMessageReturnedFromBadDataNoPhoneBadName()
    {
        $data = ['name' => '48390840', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $expectedData = ['name' => ['The name format is invalid.']];
        $response->assertJson($expectedData);
    }

    public function testErrorCodeReturnedFromBadDataNoPhoneBadEmail()
    {
        $data = ['name' => 'Jason Bell', 'email' => 'notanemail', 'message' => 'This is a message', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(422);
    }

    public function testErrorMessageReturnedFromBadDataNoPhoneBadEmail()
    {
        $data = ['name' => 'Jason Bell', 'email' => 'notanemail', 'message' => 'This is a message', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $expectedData = ['email' => ['The email must be a valid email address.']];
        $response->assertJson($expectedData);
    }

    public function testErrorCodeReturnedFromBadDataNoPhoneBadMessage()
    {
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => '*&()^&*%^&(*&*(&*(', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(422);
    }

    public function testErrormEssageReturnedFromBadDataNoPhonebadMessage()
    {
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => '*&()^&*%^&(*&*(&*(', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $expectedData = ['message' => ['The message format is invalid.']];
        $response->assertJson($expectedData);
    }

    public function testErrorCodeReturnedFromBaadDataWithPhoneBadPhone()
    {
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => 'not a phone'];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(422);
    }

    public function testErrorMessageReturnedFromBadDataWithPhoneBadPhone()
    {
        $data = ['name' => 'Jason Bell', 'email' => 'test@bob.com', 'message' => 'This is a message', 'phone' => 'not a phone'];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $expectedData = ['phone' => ['The phone must be a number.']];
        $response->assertJson($expectedData);
    }

    public function testErrorCodeReturnedFromEmptyData()
    {
        $data = ['name' => '', 'email' => '', 'message' => '', 'phone' => ''];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(422);
    }

    public function testErrorCodeReturndeFromNoData()
    {
        $data = [];

        $response = $this->json('post', '/ajax-contact-form', $data);

        $response->assertStatus(500);
    }
}
