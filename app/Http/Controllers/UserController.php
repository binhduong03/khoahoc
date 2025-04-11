<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Users;

class UserController extends Controller
{
    //Admin
    public function AuthLogin(){
        $userad_id = Session::get('user_id');
        if($userad_id){
            return Redirect::to('Admin/dashboard-admin');
        } else{
            return Redirect::to('Admin/login-admin')->send();
        }
    }

    public function all_teacher(){
        $this->AuthLogin();
        $all_teacher = Users::where('role','teacher')->get();
        return view('Admin.User.Teacher.all-teacher')
        ->with('all_teacher', $all_teacher);
    }

    public function edit_teacher($id){
        $edit_teacher = Users::find($id);
        return view('Admin.User.Teacher.edit-teacher')
        ->with('edit_teacher', $edit_teacher);
    }

    public function save_teacher(Request $request){
        $data = array();
        $data['fullname'] = $request->fullname;
        $data['username'] = $request->username;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['gender'] = $request->gender;
        $data['date_of_birt'] = $request->date_of_birt;
        $data['address'] = $request->address;
        $data['status'] = $request->status ? 1 : 0;
        $data['role'] = 'teacher';
        $data['password'] = md5('123456');
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar'); 
            $extension = $file->extension();
            $filename = time() . '.' . $extension; 
            $file->move(public_path('backend/images/user'), $filename);
            $data['avatar'] = $filename; 
        } else {
            $data['avatar'] = 'teacher.jpg';
        }

        Users::create($data);
        return redirect()->route('admin.all-teacher')
        ->with('msgu', 'Thông báo: Thêm giáo viên thành công');
    }

    public function delete_teacher(Request $request){
        $teacher_id = $request->user_id;
        Users::find($teacher_id)->delete();
        return redirect()->route('admin.all-teacher')
        ->with('msgu', 'Thông báo: Đã xóa thành công');
    }

    public function update_teacher(Request $request, $id){

        $user = Users::find($id);
        $updateData = [
            'fullname' => $request->fullname,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_of_birt' => $request->date_of_birt,
            'address' => $request->address,
            'role' => $request->role,
            'status' => $request->status ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = md5($request->password);
        }

        $user->update($updateData);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && $user->avatar != 'teacher.jpg') {
                $oldAvatarPath = public_path('backend/images/user/' . $user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
            $filename = time() . '.' . $request->file('avatar')->extension();
            $request->file('avatar')->move(public_path('backend/images/user'), $filename);
            $user->update(['avatar' => $filename]);
        }

        return redirect()->route('admin.all-teacher')
        ->with('msgu', 'Thông báo: Sửa giáo viên thành công');

    }

    // Học viên
    public function all_student(){
        $this->AuthLogin();
        $all_student = Users::where('role','student')->get();
        return view('Admin.User.Student.all-student')
        ->with('all_student', $all_student);
    }

    public function edit_student($id){
        $edit_student = Users::find($id);
        return view('Admin.User.Student.edit-student')
        ->with('edit_student', $edit_student);
    }

    public function save_student(Request $request){
        $data = array();
        $data['fullname'] = $request->fullname;
        $data['username'] = $request->username;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['gender'] = $request->gender;
        $data['date_of_birt'] = $request->date_of_birt;
        $data['address'] = $request->address;
        $data['status'] = $request->status ? 1 : 0;
        $data['role'] = 'student';
        $data['password'] = md5('123456');
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar'); 
            $extension = $file->extension();
            $filename = time() . '.' . $extension; 
            $file->move(public_path('backend/images/user'), $filename);
            $data['avatar'] = $filename; 
        } else {
            $data['avatar'] = 'student.jpg';
        }

        Users::create($data);
        return redirect()->route('admin.all-student')
        ->with('msgu', 'Thông báo: Thêm học viên thành công');
    }

    public function delete_student(Request $request){
        $student_id = $request->user_id;
        Users::find($student_id)->delete();
        return redirect()->route('admin.all-student')
        ->with('msgu', 'Thông báo: Đã xóa học viên thành công');
    }

    public function update_student(Request $request, $id){

        $user = Users::find($id);
        $updateData = [
            'fullname' => $request->fullname,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_of_birt' => $request->date_of_birt,
            'address' => $request->address,
            'role' => $request->role,
            'status' => $request->status ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = md5($request->password);
        }

        $user->update($updateData);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && $user->avatar != 'student.jpg') {
                $oldAvatarPath = public_path('backend/images/user/' . $user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
            $filename = time() . '.' . $request->file('avatar')->extension();
            $request->file('avatar')->move(public_path('backend/images/user'), $filename);
            $user->update(['avatar' => $filename]);
        }

        return redirect()->route('admin.all-student')
        ->with('msgu', 'Thông báo: Sửa học viên thành công');

    }

    public function profile() {
        $userId = Session::get('user_Id');

        $totalItems = DB::table('tb_carts')
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->count();

        $registeredCourses = DB::table('tb_carts')
            ->join('tb_course', 'tb_carts.course_id', '=', 'tb_course.course_id')
            ->where('tb_carts.user_id', $userId)
            ->where('tb_carts.status', 'paid') 
            ->select(
                'tb_course.course_id',
                'tb_course.name as course_name',
                'tb_course.image',
                'tb_course.description',
                'tb_course.price',
                'tb_course.duration',
                'tb_course.status as course_status'
            )
            ->get();

        foreach ($registeredCourses as $course) {
           
            $totalLectures = DB::table('tb_lectures')
                ->join('tb_chapters', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
                ->where('tb_chapters.course_id', $course->course_id)
                ->count('tb_lectures.lecture_id'); 

            $completedLectures = DB::table('tb_lecture_progress')
                ->join('tb_lectures', 'tb_lecture_progress.lecture_id', '=', 'tb_lectures.lecture_id')
                ->join('tb_chapters', 'tb_lectures.chapter_id', '=', 'tb_chapters.chapter_id')
                ->where('tb_lecture_progress.user_id', $userId)
                ->where('tb_chapters.course_id', $course->course_id)
                ->where('tb_lecture_progress.status', 1)
                ->count('tb_lecture_progress.lecture_progress_id');

            $course->total_lectures = $totalLectures;
            $course->completed_lectures = $completedLectures;
            
            // Tính toán tiến độ
            $progressPercentage = 0;
            if ($totalLectures > 0) {
                $progressPercentage = ($completedLectures / $totalLectures) * 100; 
            }
            $course->progress_percentage = $progressPercentage; 
        }



        return view('Pages.Profile.profile')
            ->with('totalItems', $totalItems)
            ->with('registeredCourses', $registeredCourses); 
    }

}
