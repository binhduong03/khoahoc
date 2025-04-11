<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Chapters;
use App\Models\Courses;
use App\Models\Users;

class ChapterController extends Controller
{
    public function AuthLogin(){
        $userad_id = Session::get('user_id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }

    public function save_chapter(Request $request){
        Chapters::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->back()
        ->with('msg', 'Thông báo: Thêm chương thành công');
    }

    public function all_course(){
        $this->AuthLogin();
        $all_courses = Courses::all();
        return view('Admin.Chapter.all-course')
        ->with('all_courses', $all_courses);
    }

    public function all_chapter($course_id){
        $all_chapter = DB::table('tb_chapters')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id)
        ->select('tb_course.course_id', 'tb_course.name', 'tb_chapters.*')
        ->get();

        $courseID = Courses::find($course_id);

        return view('Admin.Chapter.all-chapter')
        ->with('all_chapter', $all_chapter)
        ->with('courseID', $courseID);
    }

    public function delete_chapter(Request $request){
        $chapterId = $request->chapter_id;
        Chapters::find($chapterId)->delete();
        return redirect()->back()
        ->with('msg', 'Thông báo: Xóa chương thành công');
    }

    public function update_chapter(Request $request){
        $chapterId = $request->chapter_id;
        $data = array();
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        Chapters::where('chapter_id', $chapterId)->update($data);
        return redirect()->back()
        ->with('msg', 'Thông báo: Sửa chương thành công');
    }

}
