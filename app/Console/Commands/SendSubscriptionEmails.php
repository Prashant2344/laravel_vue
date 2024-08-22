<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionEmailJob;
use App\Models\User;
use Illuminate\Console\Command;

class SendSubscriptionEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-subscriptions';
    protected $description = 'Send subscription emails to users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::select('id', 'email')->limit(10)->get();

        foreach ($users as $user) {
            $subjects = "This is test mail";
            $data = [
                'greeting' => "Hello",
                'title' => "Title",
            ];
            $sendToEmail = $user->email;

            // Dispatch the job
            SendSubscriptionEmailJob::dispatch($data, $subjects, $sendToEmail);
        }

        $this->info('Subscription emails have been dispatched.');
    }
}
