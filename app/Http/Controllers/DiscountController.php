<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Discounts;
use App\Models\Users;

class DiscountController extends Controller
{
    public function all_discount(){
        $all_discount = Discounts::all();
        return view('Admin.Discount.all-discount')
        ->with('all_discount', $all_discount);
    }

    public function add_discount(){
        return view('Admin.Discount.add-discount');
    }

    public function checkuser(){
        $userId = Session::get('user_Id');
        $user = Users::find($userId);
        if ($user) {
            $registrationDate = new \Carbon\Carbon($user->created_at);
            $now = \Carbon\Carbon::now();
            if ($registrationDate->diffInDays($now) <= 30) {
                return 'new'; 
            } else {
                return 'old';
            }
        }
        return null; 
    }
}
