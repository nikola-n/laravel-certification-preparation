<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentPostedNotification implements ShouldQueue
{
    use InteractsWithQueue;


    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'sqs';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 60;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //dispatch the listener after the database transaction is committed.
    public $afterCommit = true;

    /**
     * Handle the event.
     *
     * @param CommentPosted $event
     *
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        if (true) {
            $this->release(30);
        }
    }

    /**
     * Get the name of the listener's queue.
     *
     * @return string
     */
    public function viaQueue()
    {
        return 'listeners';
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param \App\Events\CommentPosted $event
     *
     * @return bool
     */
    public function shouldQueue(CommentPosted $event)
    {
        return $event->comment->subtotal >= 5000;
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\CommentPosted  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(CommentPosted $event, $exception)
    {
        //
    }
}
