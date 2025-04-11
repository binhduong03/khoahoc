<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Lectures;
use App\Models\Exercises;
use App\Models\Courses;
use App\Models\Users;
use App\Models\Chapters;

class ExerciseController extends Controller
{
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
        $all_courses = Courses::all();
        $teachers = Users::where('role', 'teacher')->get();
        return view('Admin.Exercise.all-course')
        ->with('all_courses', $all_courses)
        ->with('teachers', $teachers);
    }

    public function all_exercise($id){
        $all_exercise = DB::table('tb_exercises')
        ->join('tb_lectures', 'tb_exercises.lecture_id', '=', 'tb_lectures.lecture_id')
        ->join('tb_chapters', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $id)
        ->select('tb_exercises.*', 'tb_course.name as course_name', 'tb_course.course_id', 'tb_lectures.title as l_title')
        ->get();

        $lectures = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
        ->join('tb_course', 'tb_chapters.course_id', '=', 'tb_course.course_id')
        ->where('tb_course.course_id', $id)
        ->select('tb_lectures.*', 'tb_chapters.title as chapter_title', 'tb_course.name as course_name')
        ->get();

        return view('Admin.Exercise.all-exercise')
        ->with('all_exercise', $all_exercise)
        ->with('lectures', $lectures);
    }

    public function update_exercise(Request $request){
        $data = array();
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['lecture_id'] = $request->lecture_id;
        $data['due_date'] = $request->due_date;
        $data['status'] = $request->status ? 1 : 0;
        $exercise_id = $request->exercise_id;
        $oldexercise = Exercises::find($exercise_id); 

        if($request->hasFile('file_path')){
            if ($oldexercise->file_path && file_exists(public_path('backend/images/exercise/' . $oldexercise->file_path))){
                unlink(public_path('backend/images/exercise/'.$oldexercise->file_path));
            }
            $file_path = $request->file_path;
            $file_name = time() . '.' .$file_path->getClientOriginalExtension();
            $file_path->move(public_path('backend/images/exercise'), $file_name);

            $data['file_path'] = $file_name;
        } else {
            $data['file_path'] = $oldexercise->file_path;
        }

        $oldexercise->update($data);
        return redirect()->back()
        ->with('msg', 'Thông báo: Sửa bài tập thành công');

    }

    public function delete_exercise(Request $request){
        $exercise_id = $request->exercise_id;
        Exercises::find($exercise_id)->delete();
        return redirect()->back()
        ->with('msg', 'Thông báo: Xóa bài tập thành công');
    }

    public function save_exercise(Request $request){
        $data = array();
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['lecture_id'] =  $request->lecture_id;
        $data['due_date'] = $request->due_date;
        $data['status'] = $request->status ? 1 : 0;
        $file_path = null;
        if($request->hasFile('file_path')){
            $file_path = time() . '.' . $request->file_path->extension();
            $request->file_path->move(public_path('backend/images/exercise'), $file_path);
        }

        Exercises::create($data);
        return redirect()->back()
        ->with('msg','Thông báo: Thêm bài tập thành công');
    }


}
