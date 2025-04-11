<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Courses;

class HomeController extends Controller
{

    public function welcome(){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        return view('welcome')
        ->with('totalItems',$totalItems);
    }

    public function trangchu(){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        $all_course = Courses::with('user')
        ->where('status', 1)
        ->limit(3) 
        ->get();

        return view('Pages.Home.trang-chu')
        ->with('all_course', $all_course)
        ->with('totalItems',$totalItems);
    }


    //admin
    public function AuthLogin(){
        $userad_id = Session::get('user_id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }
    
    public function dashboard_admin(){
        $this->AuthLogin();
        $totalStudents = Users::where('role', 'student')->count();
        $totalTeachers = Users::where('role', 'teacher')->count();
        $totalCourse = Courses::count();
        $totalIncome = DB::table('tb_payments')->sum('amount');

        $courseStatistics = DB::table('tb_course')
        ->select(
            'tb_course.course_id', 
            'tb_course.name',
            'tb_course.price',
            DB::raw('COUNT(tb_carts.cart_id) as total_registrations'), 
            DB::raw('SUM(tb_payment_details.amount) as total_amount')
        )
        ->leftJoin('tb_carts', 'tb_course.course_id', '=', 'tb_carts.course_id')
        ->leftJoin('tb_payment_details', 'tb_carts.cart_id', '=', 'tb_payment_details.cart_id')
        ->leftJoin('tb_payments', 'tb_payment_details.payment_id', '=', 'tb_payments.payment_id')
        ->groupBy('tb_course.course_id', 'tb_course.name', 'tb_course.price') 
        ->orderBy('tb_course.price', 'desc')
        ->get();

        return view('Admin.Home.dashboard-admin')
        ->with('totalStudents', $totalStudents)
        ->with('totalTeachers', $totalTeachers)
        ->with('totalIncome', $totalIncome)
        ->with('totalCourse', $totalCourse)
        ->with('courseStatistics', $courseStatistics);
    }
}
