<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class AppTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test Email
     */
    public function testEmail()
    {
        $emailTest = \Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
        {
            $message->subject('Test');
            $message->from('no-reply@website_name.com', 'Website Name');
            $message->to('tejada.terrence@gmail.com');
        });

         echo json_encode(['Sent '. Carbon::now()], JSON_PRETTY_PRINT);
    }

}
