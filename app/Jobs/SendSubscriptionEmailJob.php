<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SubscriptionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendSubscriptionEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $subject;
    protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $subject, $email)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Mail sending job started");
        Mail::to($this->email)->send(new SubscriptionMail($this->data, $this->subject, $this->email));
        Log::info("Job dispatched for email: " . $this->email);
    }
}
