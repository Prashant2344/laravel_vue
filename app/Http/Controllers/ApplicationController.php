<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function __invoke()
    {   
        // $startTime = microtime(true);
        // $userCount = User::join('comments','users.id','=','comments.user_id')
        //         ->select('users.*',DB::raw('Count(comments.user_id) as comment_count'))
        //         ->groupBy('users.id')
        //         // ->having('comment_count','>',13000)
        //         ->orderByDesc('comment_count')
        //         ->limit(1);

        // // $userCount = User::where('id',function($query){
        // //     $query->select('user_id')
        // //         ->from('comments')
        // //         ->groupBy('user_id')
        // //         ->orderByRaw('COUNT(user_id) DESC')
        // //         ->limit(1);
        // // })->first();
        // dd($userCount);
        // // Comment::where('id','>',0)->update([
        // //     'email'=> null
        // // ]);
        // // User::join('comments','users.id','=','comments.user_id')
        // //     ->whereNull('comments.email')
        // //     ->update([
        // //         'comments.email' => DB::raw('users.email')
        // //     ]);
        // $endTime = microtime(true);
        // dd(round($endTime - $startTime, 4));
        // // $startTime = microtime(true);
        // // Order::where('price','<',5000.00)
        // //     ->update([
        // //         'tax_rate' => 14.00
        // //     ]);
        // // $endTime = microtime(true);
        // // dd(round($endTime - $startTime, 4));

        // // $latestComment = Comment::select('user_id',DB::raw('MAX(id) as latest_comment_id'))
        // //                 ->groupBy('user_id');
        // // $usersWithLatestComments = User::leftJoinSub($latestComment,'latest_comments',function($join){
        // //     $join->on('users.id','=','latest_comments.user_id');
        // // })
        // // ->leftJoin('comments','comments.id','=','latest_comments.latest_comment_id')
        // // ->select('users.id','users.name','comments.comment')
        // // ->get();



        // $usersWithLatestComments = User::select('users.*',DB::raw('MAX(comments.id)'))
        //         ->leftJoin('comments','users.id','=','comments.user_id')
        //         ->groupBy('users.id')
        //         ->get();
        //     dd($usersWithLatestComments);
        // // User
        // $usersWithLatestComments = User::with('latestComment')->get();
        //     // dd($usersWithLatestComments);


        // $latestCommentsSubquery = DB::table('comments')
        //     ->select('user_id', DB::raw('MAX(id) as latest_comment_id'))
        //     ->groupBy('user_id');


        // $usersWithLatestComments = DB::table('users')
        //     ->leftJoinSub($latestCommentsSubquery, 'latest_comments', function ($join) {
        //         $join->on('users.id', '=', 'latest_comments.user_id');
        //     })
        //     ->leftJoin('comments', 'comments.id', '=', 'latest_comments.latest_comment_id')
        //     ->select('users.id', 'users.name', 'comments.comment as latest_comment')
        //     ->get();


        // dd($usersWithLatestComments);
        return view('admin.layouts.app');
    }
}
