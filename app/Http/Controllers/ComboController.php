<?php

namespace App\Http\Controllers;
use DB;
use Session;
session_start();
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Combos;
use App\Models\ComboCourse;
use App\Models\Courses;
use App\Models\Users;


class ComboController extends Controller
{

    public function combo_course(){
        $userId = Session::get('user_Id');
        $totalItems = DB::table('tb_carts')
        ->where('user_id', $userId)
        ->where('status', 'unpaid')
        ->count();
        $all_combo = Combos::all();
        return view('Pages.Combo.combo-course')
        ->with('all_combo', $all_combo)
        ->with('totalItems',$totalItems);
    }

    public function combo_detail($id) {
        $userId = Session::get('user_Id');

        $combo_detail = DB::table('tb_combos')->where('combo_id', $id)->first();

        $courses = DB::table('tb_combo_course')
            ->join('tb_course', 'tb_combo_course.course_id', '=', 'tb_course.course_id')
            ->where('tb_combo_course.combo_id', $id)
            ->select('tb_course.*', 'tb_combo_course.sequence')
            ->orderBy('tb_combo_course.sequence') 
            ->get();

      
        $course_details = [];
        foreach ($courses as $course) {
            $course_detail = Courses::with('user', 'chapters.lectures.exercise')->find($course->course_id);

            $course->details = [
                'course_detail' => $course_detail,
            ];
            $course_details[] = $course;
        }
        $total_courses = $courses->count();

        return view('Pages.Combo.combo-detail')
            ->with('combo_detail', $combo_detail)
            ->with('course_details', $course_details)
            ->with('total_courses', $total_courses);
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

    public function all_combo(){
        $this->AuthLogin();
        $combos = Combos::with('comboCourses.course.user')->get();
        return view('Admin.Combo.all-combo')
        ->with('combos', $combos);
    }

    public function add_combo(){
        $courses = Courses::all();
        return view('Admin.Combo.add-combo')
        ->with('courses', $courses);
    }

    public function edit_combo($id){
        $combos = Combos::with('comboCourses.course.user')->find($id);
        $courses = Courses::all();
        return view('Admin.Combo.edit-combo')
        ->with('courses', $courses)
        ->with('combos', $combos);
    }

    public function delete_combo(Request $request){
        $combo_id = $request->combo_id;
        Combos::find($combo_id)->delete();
        return redirect()->route('admin.all-combo')
        ->with('msgcb', 'Thông báo: Xóa combo thành công');
    }

    public function update_combo(Request $request, $id)
    {
        $combo = Combos::findOrFail($id);
        $combo->name = $request->input('name');
        $combo->description = $request->input('description');
        $combo->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($combo->image) {
                $oldImagePath = public_path('backend/images/combo/' . $combo->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newImageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/images/combo'), $newImageName);
            $combo->update([
                'image' => $newImageName,
            ]);
        }


        $combo->save();

        $courseIds = $request->input('course_ids', []); 
        $orders = $request->input('orders', []);

        $combo->comboCourses()->delete();

        $totalPrice = 0;
        foreach ($courseIds as $courseId) {
            $course = Courses::find($courseId);
            if ($course) {
                $totalPrice += $course->price;
                $combo->comboCourses()->create([
                    'combo_id' => $id,
                    'course_id' => $courseId, 
                    'sequence' => $orders[$courseId] ?? null 
                ]);
            }
        }

        $combo->price = $totalPrice;
        $combo->save();

        return redirect()->route('admin.all-combo')
        ->with('msgcb', 'Thông báo: Cập nhật thành công');
    }



    public function save_combo(Request $request){
        $imagesName = null;
        if($request->hasFile('image')){
            $imagesName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/images/combo'), $imagesName);
        }

        $combo = Combos::create([
            'name' => $request->name,
            'image' => $imagesName,
            'description' => $request->description,
            'price' => null,
            'status' => $request->status ? 1 : 0,
        ]);

        $totalPrice = 0;
        if($request->has('course_ids')){
            foreach ($request->course_ids as $courseId) {
                $course = Courses::find($courseId);
                if($course){
                    ComboCourse::create([
                        'combo_id' => $combo->combo_id,
                        'course_id' => $courseId,
                        'sequence' => $request->orders[$courseId] ?? null,
                    ]);

                    $totalPrice += $course->price;
                }
            }

            $combo->update(['price' => $totalPrice]);
        }

        return redirect()->route('admin.all-combo')
        ->with('msgcb', 'Thông báo: Thêm combo thành công');
    }


}
