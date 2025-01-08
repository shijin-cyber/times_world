<?php

namespace App\Jobs;
use App\Mail\EventRegistered;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    /**
     * Maximum number of attempts to retry the job.
     */
    public $tries = 3; 

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function handle()
    {
       
        try {
            //uncoment the bellow line to make a error
             //throw new \Exception('Simulated email sending failure');
            Mail::to($this->event->email)->send(new EventRegistered($this->event));
            $this->event->update(['email_status' => 1]);
        } catch (\Exception $e) {
        
            $this->event->update(['email_status' => 0]);
            \Log::error('Error sending email: ' . $e->getMessage());
            throw $e; 
        }
    }

    public function failed(\Exception $exception)
    {
        $this->event->update(['email_status' => 0]);
    }
}