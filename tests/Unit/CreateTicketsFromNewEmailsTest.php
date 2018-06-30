<?php

namespace Tests\Unit;

use App\Jobs\ParseNewEmails;
use App\Requester;
use App\Services\Pop3\FakeMailbox;
use App\Services\Pop3\FakeIncomingMail;
use App\Services\Pop3\Mailbox;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTicketsFromNewEmailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_from_requester_email_changes_status_to_open(){
        Notification::fake();
        $fakePop = new FakeMailbox();
        $agent                              = factory(User::class)     ->create(["email" => "tony@stark.com"]);
        $ticketWithCommentRequester         = factory(Requester::class)->create(["email" => "peter@parker.com"]);
        $ticketThatWillGetTheCommentByMail  = factory(Ticket::class)   ->create(["id" => 18, "requester_id" => $ticketWithCommentRequester, "status" => Ticket::STATUS_SOLVED ]);

        $this->assertEquals(Ticket::STATUS_SOLVED, $ticketThatWillGetTheCommentByMail->fresh()->status);
        $ticketReplyBody = "The email reply##- Please type your reply above this line -##</span>\r\n\r\nA new comment for the ticket\r\n\r\nAaaaand another one\r\n\r\nSee the ticket\r\nThank you for using our application!\r\n\r\nticket-id:18.</span>\r\n\r\nRegards,\r\nHandesk\r\n\r\nIf you’re having trouble clicking the \"See the ticket\" button, copy and paste the URL below into your web browser: http://handesk.dev/requester/tickets/eQDXxiSRwPwS0tFGpj9jQJH2\r\n\r\n© 2017 Handesk. All rights reserved. ticket-id:19.";
        $fakePop->messages = [
            new FakeIncomingMail(["name" => "Peter Parker", "email" => "peter@parker.com"], "Reply to of ticket 2", $ticketReplyBody    ),
        ];

        app()->instance(Mailbox::class, $fakePop);

        dispatch( new ParseNewEmails() );

        $this->assertEquals(1, Ticket::count());
        $this->assertEquals(Ticket::STATUS_OPEN, $ticketThatWillGetTheCommentByMail->fresh()->status);
    }
}
