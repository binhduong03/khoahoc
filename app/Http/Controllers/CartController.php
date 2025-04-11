<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Carts;
use App\Models\Discounts;
use App\Models\Users;

class CartController extends Controller
{
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

    public function save_cart(Request $request){
        $courseid = $request->courseid_hidden;
        $comboid = $request->comboid_hidden;
        $course_info = Courses::find($courseid);
        $userId = session('user_Id');
        if(!$userId){
            return Redirect()->route('dang-nhap');
        }

        $data['course_id'] = $courseid;
        $data['combo_id'] = $comboid;
        $data['user_id'] = $userId;
        $data['status'] = 'unpaid';

        Carts::create($data);
        return redirect()->route('gio-hang');
    }

    public function show_cart(){
        $userId = Session('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();

        $cartItems = DB::table('tb_carts')
        ->where('tb_carts.user_id', $userId)
        ->where('tb_carts.status', 'unpaid')
        ->leftjoin('tb_course', 'tb_carts.course_id', '=', 'tb_course.course_id')
        ->leftjoin('tb_combos', 'tb_carts.combo_id', '=', 'tb_combos.combo_id')
        ->select('tb_carts.*', 'tb_course.name','tb_course.price', 'tb_course.image','tb_combos.name as combo_name', 'tb_combos.price as combo_price', 'tb_combos.image as combo_image' )
        ->get();

        $sub_total = 0;
        foreach ($cartItems as $key => $all) {
            $sub_total += $all->price + $all->combo_price;
        }

        $discount_status = $this->checkuser();
        $all_discount = DB::table('tb_discounts')
        ->where('status', 1)
        ->get();

        return view('Pages.Cart.show-cart')
            ->with('cartItems',$cartItems)
            ->with('sub_total',$sub_total)
            ->with('totalItems',$totalItems)
            ->with('discount_status', $discount_status)
            ->with('all_discount', $all_discount);
    }

    public function delete_cart(Request $request, $id){
        Carts::find($id)->delete();
        return redirect()->back();
    }

    public function save_discount(Request $request)
    {
        $title = $request->input('title');
        $discount = DB::table('tb_discounts')->where('title', $title)->first();

        $userId = Session('user_Id');
        $cartItems = DB::table('tb_carts')
        ->where('tb_carts.user_id', $userId)
        ->where('tb_carts.status', 'unpaid')
        ->join('tb_course', 'tb_carts.course_id', '=', 'tb_course.course_id')
        ->select('tb_carts.*', 'tb_course.name', 'tb_course.price', 'tb_course.image')
        ->get();

        $sub_total = 0;
        foreach ($cartItems as $key => $all) {
            $sub_total += $all->price;
        }
        $totalDiscount = $sub_total * ($discount->discount_percentage / 100);
        $finalPrice = $sub_total - $totalDiscount;

        return redirect()->back()
        ->with('cartItems', $cartItems)
        ->with('sub_total', $sub_total)
        ->with('totalDiscount', $totalDiscount)
        ->with('finalPrice', $finalPrice)
        ->with('discountCode', $title);
    }

}
