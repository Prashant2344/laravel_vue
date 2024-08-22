<?php

namespace App\ScheduledTasks;

use App\Jobs\SendSubscriptionEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SubscriptionEmailTask
{
    public function __invoke()
    {
        $users = User::select('id', 'email')->limit(10)->get();

        foreach ($users as $user) {
            $subjects = "This is test mail";
            $data = [
                'greeting' => "Hello User",
                'title' => "Title",
            ];
            $sendToEmail = $user->email;

            // Dispatch the job
            SendSubscriptionEmailJob::dispatch($data, $subjects, $sendToEmail);
        }

        Log::info('Subscription emails have been dispatched.');
    }
}
