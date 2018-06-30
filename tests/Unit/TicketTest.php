<?php

namespace Tests\Unit;

use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function adding_the_first_comment_assigns_the_ticket_to_the_user(){
       Notification::fake();
       $user    = factory(User::class)->create();
       $user2   = factory(User::class)->create();

       $ticket  = factory(Ticket::class)->create();
       $this->assertNull($ticket->fresh()->user);

       $ticket->addComment($user, "A comment");
       $ticket->addComment($user2, "A comment");

       $this->assertEquals($ticket->fresh()->user->id, $user->id);
   }

   /** @test */
   public function adding_a_comment_updates_ticket_timestamp(){
       Notification::fake();
       $ticket  = factory(Ticket::class)->create(["updated_at" => Carbon::parse("-5 days")]);

       $ticket->addComment(null, "A comment");

       $this->assertEquals(Carbon::now()->toDateString(), $ticket->fresh()->updated_at->toDateString());
   }

   /** @test */
   public function adding_an_empty_comment_just_changes_the_status(){
       $user    = factory(User::class)->create();
       $ticket = factory(Ticket::class)->create(["status" => Ticket::STATUS_NEW]);

       $ticket->addComment($user, null, Ticket::STATUS_SOLVED);

       $this->assertCount(0, $ticket->comments);
       $this->assertEquals(Ticket::STATUS_SOLVED, $ticket->status);
   }


   /** @test */
   public function adding_a_comment_when_escalated_it_is_added_as_a_note(){
       $user    = factory(User::class)->create();
       $ticket  = factory(Ticket::class)->create(["level" => 1]);
       $comment = $ticket->addComment($user, "this is a comment");
       $this->assertTrue($comment->private);
   }

    /** @test */
    public function adding_a_requester_comment_when_escalated_it_is_not_added_as_a_note(){
        $ticket  = factory(Ticket::class)->create(["level" => 1]);
        $comment = $ticket->addComment(null, "this is a comment");

        $this->assertFalse($comment->private == true);
    }
}
