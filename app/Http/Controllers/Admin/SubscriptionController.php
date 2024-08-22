<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendSubscriptionEmailJob;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select('id', 'email')
                ->whereIn('id',$request->ids)
                ->limit(10)->get();

        foreach($users as $user) 
        {
            $subjects = "This is test mail";
            $data = [
                'greeting' => "Hello",
                'title' => "Title",
            ];
            $sendToEmail = $user->email;

            // Dispatch the job
            SendSubscriptionEmailJob::dispatch($data, $subjects, $sendToEmail);
        }

        return response()->json(['message' => 'Mail send successfully']);

    }
}
