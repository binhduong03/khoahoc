<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Users;

class PaymentController extends Controller
{
    public function payment(){
        $userId = Session('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        return view('Pages.Payment.payment')
         ->with('totalItems',$totalItems);
    }

    public function save_payment(Request $request){
        $userId = Session('user_Id');
        $user = Users::find($userId);
        $cartItems = DB::table('tb_carts')
        ->where('tb_carts.user_id', $userId)
        ->where('tb_carts.status', 'unpaid')
        ->join('tb_course', 'tb_carts.course_id', '=', 'tb_course.course_id')
        ->select('tb_carts.*', 'tb_course.name', 'tb_course.price', 'tb_course.image')
        ->get();

        $sub_total = $request->final_price;
        $discount = $request->total_discount;

        $paymentId = DB::table('tb_payments')->insertGetId([
            'user_id' => $userId,
            'discount' => $discount,
            'amount' => $sub_total,
            'payment_method' => 'MOMO',
            'payment_status' => 0,
            'payment_date' => now(),
        ]);

        foreach ($cartItems as $cart) {
        DB::table('tb_payment_details')->insert([
            'payment_id' => $paymentId,
            'cart_id' => $cart->cart_id,
            'amount' => $cart->price,
        ]);

        DB::table('tb_carts')->where('cart_id', $cart->cart_id)->update(['status' => 'paid']);
        }

        return redirect()->route('thanh-toan');
    }

    //Admin
    public function AuthLogin(){
        $userad_id = Session::get('user_id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }

    public function all_payment(){
        $this->AuthLogin();
        $all_payment = DB::table('tb_payments')
        ->join('tb_user', 'tb_user.user_id', '=', 'tb_payments.user_id')
        ->select('tb_payments.*', 'tb_user.fullname', 'tb_user.phone')
        ->orderBy('tb_payments.payment_id', 'desc')
        ->get();
        return view('Admin.Payment.all-payment')
        ->with('all_payment', $all_payment);
    }

    public function update_payment_status(Request $request){
        $paymentId = $request->payment_id;

        $currentStatus = DB::table('tb_payments')
        ->where('payment_id', $paymentId)
        ->value('payment_status');

        if ($currentStatus == 1) {
            return redirect()->back()
                ->with('error', 'Trạng thái thanh toán đã hoàn tất, không thể sửa đổi!');
        }

        DB::table('tb_payments')
            ->where('payment_id', $paymentId)
            ->update(['payment_status' => $request->payment_status]);

        return redirect()->back()
        ->with('msg', 'Cập nhật trạng thái thanh toán thành công!');
    }

    public function detail_payment($id){
        $payment = DB::table('tb_payments')
            ->join('tb_user', 'tb_user.user_id', '=', 'tb_payments.user_id')
            ->select('tb_payments.*', 'tb_user.fullname', 'tb_user.phone')
            ->where('tb_payments.payment_id', $id)
            ->first();

        $payment_details = DB::table('tb_payment_details')
            ->join('tb_carts', 'tb_payment_details.cart_id', '=', 'tb_carts.cart_id')
            ->join('tb_course', 'tb_course.course_id', '=', 'tb_carts.course_id')
            ->select('tb_course.name', 'tb_course.price', 'tb_course.image', 'tb_payment_details.*')
            ->where('tb_payment_details.payment_id', $id)
            ->get();

        return view('Admin.Payment.detail-payment')
            ->with('payment', $payment)
            ->with('payment_details', $payment_details);
    }


}
