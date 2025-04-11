<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Users;

class AuthController extends Controller
{
    public function AuthLogin(){
        $userad_id = Session::get('user_id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }

    public function logout_admin(){
        $this->AuthLogin();
        Session::forget('fullname');
        Session::forget('user_id');
        Session::forget('avatar');
        return Redirect::to('Admin/login-admin');
    }


    public function login_admin(){
        return view('Admin.Auth.login');
    }

    public function auth_login(Request $request){
        $email = $request->input('email');
        $password = md5($request->input('password'));

        $result = DB::table('tb_user')
            ->where('tb_user.email', $email)
            ->where('tb_user.password', $password)
            ->whereIn('tb_user.role', ['Admin', 'Teacher'])
            ->first();

        if($result){
            Session::put('fullname', $result->fullname);
            Session::put('user_id', $result->user_id);
            Session::put('avatar', $result->avatar); 
            return Redirect::to('/Admin/dashboard');

        } else {
             Session::put('error', 'Email hoặc mật khẩu bị sai hoặc bạn không có quyền truy cập vào trang admin');
            return redirect::to('Admin/login-admin');
        }
    }


    
    // Trang người dùng
    public function AuthDangNhap(){
        $userad_id = Session::get('user_Id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }

    public function dang_nhap(){
        return view('Pages.Auth.dang-nhap');
    }

    public function auth_dangnhap(Request $request){
        $email = $request->input('email');
        $password = md5($request->input('password'));

        $result = DB::table('tb_user')
            ->where('tb_user.email', $email)
            ->where('tb_user.password', $password)
            ->where('tb_user.role', 'Student')
            ->first();

        if($result){
            Session::put('fullName', $result->fullname);
            Session::put('user_Id', $result->user_id);
            Session::put('Avatar', $result->avatar); 
            Session::put('Email', $result->email);
            Session::put('SDT', $result->phone);
            return Redirect::to('/trang-chu');

        } else {
            Session::put('error', 'Email hoặc mật khẩu bị sai');
            return redirect::to('dang-nhap');
        }
    }

    public function auth_dangky(Request $request){
        $sessionOtp = Session::get('otp');
        $email = Session::get('otp_email');
        if ($request->otp != $sessionOtp) {
            return redirect()->back()->with('error', 'Mã OTP không đúng. Vui lòng kiểm tra lại.');
        }

        if ($request->email != $email) {
            return redirect()->back()->with('error', 'Email đã nhập không đúng với email mà bạn đã lấy otp. Vui lòng kiểm tra lại.');
        }

        Users::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => md5($request->password),
            'avatar' => 'student.jpg',
            'role' => 'student',
        ]);

        Session::forget('otp');
        return redirect()->back()->with('success', 'Tài khoản của bạn đã đăng ký thành công');
    }

}
