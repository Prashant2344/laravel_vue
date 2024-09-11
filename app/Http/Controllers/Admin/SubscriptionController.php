<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendSubscriptionEmailJob;
use App\Models\Comment;
use App\Models\CommentCopy;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {

        $results = DB::table('customers')
            ->select(
                'customers.name as customer_name',
                'users.email as email',
                'customers.type as type',
                'orders.user_id as user_id',
                DB::raw('SUM(CASE WHEN orders.status = "pending" THEN orders.price ELSE 0 END) as pending_total'),
                DB::raw('SUM(CASE WHEN orders.status = "completed" THEN orders.price ELSE 0 END) as completed_total')
            )
            ->join('users','users.customer_id','=','customers.id')
            ->join('orders','orders.user_id','=','users.id')
            ->groupBy('orders.user_id')
            ->get();

        $startTime = microtime(true);
        // DB::table('comment_copies')->insert(
        //     DB::table('comments')
        //         ->select('id', 'email', 'comment', 'user_id', 'created_at', 'updated_at')
        //         ->get()
        //         ->toArray()
        // );
        // DB::table('comments')->select('id', 'email', 'comment', 'user_id', 'created_at', 'updated_at')
        //     ->orderBy('id')
        //     ->chunk(10000,function($comments){
        //         $finalArr = $comments->map(function($comment){
        //             return [
        //                 'id' => $comment->id,
        //                 'email' => $comment->email,
        //                 'comment' => $comment->comment,
        //                 'user_id' => $comment->user_id,
        //                 'created_at' => $comment->created_at,
        //                 'updated_at' => $comment->updated_at
        //             ];
        //         })->toArray();
        //         DB::table('comment_copies')->insert($finalArr);
        //     });
        // $endTime = microtime(true);
        dd(round($endTime - $startTime, 4));
    // Fetch users in chunks to avoid memory overload
    // User::select('id', 'email')
    //     ->whereIn('id', $request->ids)
    //     ->chunk(3, function ($users) {
    //         foreach ($users as $user) {
    //             $subjects = "This is test mail";
    //             $data = [
    //                 'greeting' => "Hello",
    //                 'title' => "Title",
    //             ];
    //             $sendToEmail = $user->email;

    //             // Dispatch the job to the queue
    //             SendSubscriptionEmailJob::dispatch($data, $subjects, $sendToEmail);
    //         }
    //     });

    return response()->json(['message' => 'Mails queued successfully']);

    }
}
