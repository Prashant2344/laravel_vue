<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::latest()->get()->map(function($user) {
        //     return [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         'created_at' => $user->formated_created_at
        //     ];
        // });
        // $orders = Order::select('id', 'price', 'tax_rate')
        //     ->addSelect(DB::raw('calculate_total_price(price, tax_rate) as total_price_with_tax'))
        //     ->limit(10)
        //     ->get();
        //     dd($orders);
            
        $users = User::latest()->paginate(10);
        return $users;
    }

    public function store()
    {
        request()->validate([
            'email' => 'required|unique:users,email'
        ]);

        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);
    }

    public function update(User $user)
    {
        request()->validate([
            'email' => 'required|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password
        ]);

        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public function changeRole(User $user)
    {
        $user->update([
            'role' => request('role')
        ]);

        return response()->json(['success' => true]);
    }

    public function search()
    {
        $searchQuery = request('query');
        $users = User::where('name', 'like', "%{$searchQuery}%")->latest()->paginate(10);

        return response()->json($users);
    }

    public function bulkDelete()
    {
        User::whereIn('id',request('ids'))->delete();

        return response()->json(['message' => 'Users deleted successfully']);
    }

}
