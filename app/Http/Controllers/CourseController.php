<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Courses;
use App\Models\Users;
use App\Models\Chapters;
use App\Models\Lectures;
use App\Models\Exercises;


class CourseController extends Controller
{

    public function course(){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        $all_course = Courses::with('user')
        ->where('status', 1)
        ->get();
        return view('Pages.Course.course')
        ->with('all_course', $all_course)
        ->with('totalItems',$totalItems);
    }

    public function course_detail($id){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        $course_detail = Courses::with('user', 'chapters.lectures.exercise')->find($id);
        $total_lectures = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $id) 
        ->count();

        $total_exercise = DB::table('tb_exercises')
        ->join('tb_lectures', 'tb_lectures.lecture_id', '=', 'tb_exercises.lecture_id')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $id) 
        ->count();

        $chapters = $course_detail->chapters;
        return view('Pages.Course.course-detail')
        ->with('course_detail', $course_detail)
        ->with('chapters', $chapters)
        ->with('total_lectures', $total_lectures)
        ->with('total_exercise', $total_exercise)
        ->with('totalItems',$totalItems);
    }

    public function course_lecture($id){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        $course_lecture = Lectures::find($id);
        $course = DB::table('tb_course')
        ->join('tb_chapters', 'tb_chapters.course_id', '=', 'tb_course.course_id')
        ->join('tb_lectures', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
        ->join('tb_user', 'tb_user.user_id', '=', 'tb_course.course_id')
        ->select('tb_course.*', 'tb_lectures.lecture_id', 'tb_user.fullname')
        ->where('tb_lectures.lecture_id', $id)
        ->first();
        
        $course_id = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_lectures.lecture_id', $id)
        ->value('tb_course.course_id');

        $countlecture = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id) 
        ->count();

        $countexercise = DB::table('tb_exercises')
        ->join('tb_lectures', 'tb_lectures.lecture_id', '=', 'tb_exercises.lecture_id')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id) 
        ->count();

        $lecture_progress = DB::table('tb_lecture_progress')
        ->where('user_id', $userId)
        ->where('lecture_id', $id)
        ->value('progress') ?? 0;

        $all_lecture = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->join('tb_user', 'tb_user.user_id', '=', 'tb_course.user_id') 
        ->where('tb_course.course_id', $course_id)
        ->select('tb_lectures.*', 'tb_user.fullname')
        ->get();

        return view('Pages.Course.course-lecture')
        ->with('course_lecture', $course_lecture)
        ->with('course', $course)
        ->with('countlecture', $countlecture)
        ->with('countexercise', $countexercise)
        ->with('lecture_progress', $lecture_progress)
        ->with('all_lecture', $all_lecture)
        ->with('totalItems',$totalItems);
        
    }

    public function course_exercise($id){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        $course_exercise = Exercises::find($id);

        $course = DB::table('tb_course')
        ->join('tb_chapters', 'tb_chapters.course_id', '=', 'tb_course.course_id')
        ->join('tb_lectures', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
        ->join('tb_exercises', 'tb_exercises.lecture_id', '=', 'tb_lectures.lecture_id')
        ->join('tb_user', 'tb_user.user_id', '=', 'tb_course.course_id')
        ->select('tb_course.*', 'tb_lectures.lecture_id', 'tb_user.fullname')
        ->where('tb_exercises.exercises_id', $id)
        ->first();

        $course_id = DB::table('tb_exercises')
        ->join('tb_lectures', 'tb_lectures.lecture_id', '=', 'tb_exercises.lecture_id')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_exercises.exercises_id', $id)
        ->value('tb_course.course_id');

        $countlecture = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id) 
        ->count();

        $countexercise = DB::table('tb_exercises')
        ->join('tb_lectures', 'tb_lectures.lecture_id', '=', 'tb_exercises.lecture_id')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id) 
        ->count();

        $all_exercise = DB::table('tb_exercises')
        ->join('tb_lectures', 'tb_lectures.lecture_id', '=', 'tb_exercises.lecture_id')
        ->join('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->join('tb_user', 'tb_user.user_id', '=', 'tb_course.user_id') 
        ->where('tb_course.course_id', $course_id)
        ->select('tb_exercises.*', 'tb_user.fullname')
        ->get();

        return view('Pages.Course.course-exercise')
        ->with('course_exercise', $course_exercise)
        ->with('course', $course)
        ->with('countlecture', $countlecture)
        ->with('countexercise', $countexercise)
        ->with('all_exercise', $all_exercise)
        ->with('totalItems',$totalItems);
    }

    //ADMIN
    public function AuthLogin(){
        $userad_id = Session::get('user_id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }

    public function all_course(){
        $this->AuthLogin();
        $all_courses = Courses::with('user')
        ->orderBy('course_id', 'desc')
        ->get();


        $teachers = Users::where('role', 'teacher')->get();
        return view('Admin.Course.all-course')
        ->with('all_courses', $all_courses)
        ->with('teachers', $teachers);
    }

    public function edit_course($id){
        $edit_courses = Courses::with('user')->find($id);
        $teachers = Users::where('role', 'teacher')->get();
        return view('Admin.Course.edit-course')
        ->with('edit_courses', $edit_courses)
        ->with('teachers', $teachers);
    }

    public function save_course(Request $request){

        $imagesName = null;
        if($request->hasFile('image')){
            $imagesName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/images/courses'), $imagesName);
        }

        Courses::create([
            'name' => $request->name,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
            'image' => $imagesName,
            'status' => $request->has('status') ? 1 : 0,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.all-course')
        ->with('msgc', 'Thông báo: Khóa học đã thêm thành công');
    }

    public function delete_course(Request $request){
        $course_id = $request->course_id;
        Courses::find($course_id)->delete();
        return redirect()->route('admin.all-course')
        ->with('msgc', 'Thông báo: Khóa học đã được xóa');
    }

    public function update_course(Request $request, $id){

        $course = Courses::find($id);
        if ($request->hasFile('image')) {
            if ($course->image) {
                $oldImagePath = public_path('backend/images/courses/' . $course->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newImageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/images/courses'), $newImageName);

            $course->update([
                'image' => $newImageName,
            ]);
        }

        $data = array();
        $data['name'] = $request->name;
        $data['price'] =  $request->price;
        $data['duration'] = $request->duration;
        $data['description'] =$request->description;
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['user_id'] = $request->user_id;

        $course->update($data);
        return redirect()->route('admin.all-course')
        ->with('msgc', 'Thông báo: Khóa học đã sửa thành công');
    }

    
}
