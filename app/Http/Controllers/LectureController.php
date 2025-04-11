<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Lectures;
use App\Models\Courses;
use App\Models\Users;
use App\Models\Chapters;

class LectureController extends Controller
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
        return view('Admin.Lecture.all-course')
        ->with('all_courses', $all_courses)
        ->with('teachers', $teachers);
    }

    public function all_lecture($course_id){
    	$lectures = DB::table('tb_lectures')
        ->join('tb_chapters', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
        ->join('tb_course', 'tb_chapters.course_id', '=', 'tb_course.course_id')
        ->where('tb_course.course_id', $course_id)
        ->select('tb_lectures.*', 'tb_chapters.title as chapter_title', 'tb_course.name as course_name')
        ->get();

        $chapters = Chapters::where('course_id', $course_id)->get();
        $courseID = Courses::find($course_id);
        return view('Admin.Lecture.all-lecture')
        ->with('lectures', $lectures)
        ->with('chapters', $chapters)
        ->with('courseID', $courseID);
    }

    public function add_lecture($course_id){
        $courseID = Courses::find($course_id);
        $chapters = Chapters::where('course_id', $course_id)->get();
        return view('Admin.Lecture.add-lecture')
        ->with('chapters', $chapters)
        ->with('courseID', $courseID);
    }

    public function save_lecture(Request $request){

        $imagesName = null;
        if($request->hasFile('media_url')){
            $imagesName = time() . '.' . $request->media_url->extension();
            $request->media_url->move(public_path('backend/images/lecture'), $imagesName);
        }

        $lecture = Lectures::create([
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'content' => $request->content,
            'media_type' => $request->media_type,
            'order' => $request->order,
            'media_url' => $imagesName,
            'status' => $request->status ? 1:0,
        ]);

        return redirect()->route('admin.all-lecture',['course_id' => $request->course_id])
        ->with('msg', 'Thông báo: Thêm bài giảng thành công');
    }

    public function delete_lecture(Request $request){
        $lectureId = $request->lecture_id;
        Lectures::find($lectureId)->delete();
        return redirect()->back()
        ->with('msg', 'Thông báo: Xóa bài giảng thành công');
    }

    public function edit_lecture($lecture_id, $course_id){
        $courseID = Courses::find($course_id);
        $edit_lecture = Lectures::find($lecture_id);
        $chapter = Chapters::where('course_id', $course_id)->get();
        return view('Admin.Lecture.edit-lecture')
        ->with('edit_lecture', $edit_lecture)
        ->with('courseID', $courseID)
        ->with('chapter', $chapter);
    }

    public function update_lecture(Request $request){
        $lectureId = $request->lecture_id;
        $oldmedia_url = Lectures::find($lectureId);
        $data = array();
        $data['title'] = $request->title;
        $data['chapter_id'] = $request->chapter_id;
        $data['content'] = $request->content;
        $data['media_type'] = $request->media_type;
        $data['order'] = $request->order;
        $data['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('media_url')) {
            if ($oldmedia_url->media_url && file_exists(public_path('backend/images/lecture/' . $oldmedia_url->media_url))) {
                unlink(public_path('backend/images/lecture/' . $oldmedia_url->media_url));
            }
            $media_file = $request->file('media_url');
            $media_filename = time() . '.' . $media_file->getClientOriginalExtension();  
            $media_file->move(public_path('backend/images/lecture'), $media_filename); 

            $data['media_url'] = $media_filename;
        } else {
            $data['media_url'] = $oldmedia_url->media_url;
        }
        $oldmedia_url->update($data);

        return redirect()->route('admin.all-lecture', ['course_id'=> $request->course_id])
        ->with('msg', 'Thông báo: Sửa bài giảng thành công');
    }

}
