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
use App\Models\Exercises;
use App\Models\ExerciseSubmission;

class ProgressController extends Controller
{
     public function saveVideoProgress(Request $request)
    {
        // Lấy thông tin người dùng từ session
        $userId = Session::get('user_Id');
        $lectureId = $request->lecture_id;
        $progress = $request->progress;

        // Xác định status dựa vào progress
        $status = ($progress >= 100) ? 1 : 0; // 1 nếu hoàn thành, 0 nếu chưa hoàn thành

        // Kiểm tra xem tiến độ đã tồn tại chưa
        $existingProgress = DB::table('tb_lecture_progress')
            ->where('user_id', $userId)
            ->where('lecture_id', $lectureId)
            ->first();

        try {
            if ($existingProgress) {
                // Cập nhật tiến độ và status
                $updateResult = DB::table('tb_lecture_progress')
                    ->where('lecture_progress_id', $existingProgress->lecture_progress_id) 
                    ->update([
                        'progress' => $progress,
                        'status' => $status,
                    ]);

                if ($updateResult === 0) {
                    \Log::info('Cập nhật thất bại: Không có hàng nào bị ảnh hưởng cho người dùng ' . $userId . ' và bài giảng ' . $lectureId);
                }
            } else {
                // Lưu mới
                DB::table('tb_lecture_progress')->insert([
                    'user_id' => $userId,
                    'lecture_id' => $lectureId,
                    'progress' => $progress,
                    'status' => $status,
                ]);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Ghi lại lỗi nếu có
            \Log::error('Error saving video progress: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function save_exercise_progress(Request $request){
        $userId = Session::get('user_Id');
        $exercise_id = $request->exercise_id;
        $existingProgress = DB::table('tb_exercise_submission')
            ->where('user_id', $userId)
            ->where('exercises_id', $exercise_id)
            ->first();

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName(); 
            $file->move(public_path('backend/exercise/nap_bai'), $fileName);

            if ($existingProgress) {
                DB::table('tb_exercise_submission')
                ->where('user_id', $userId)
                ->where('exercises_id', $exercise_id)
                ->update(['file_path' => $fileName]);
            } else {
                $data = array();
                $data['user_id'] = $userId;
                $data['exercises_id'] = $exercise_id;
                $data['submission_date'] = now();
                $data['file_path'] = $fileName;
                $data['status'] = 1;
                ExerciseSubmission::create($data);
            }
            
        }
        return redirect()->back();
    }

    //Admin 

    public function all_course(){
        $all_courses = Courses::all();
        return view('Admin.Progress.all-course')
        ->with('all_courses', $all_courses);
    }

    public function all_student_progress($id){
        $course = Courses::find($id);
        $all_student = DB::table('tb_user')
        ->join('tb_carts', 'tb_carts.user_id', '=', 'tb_user.user_id')
        ->join('tb_course', 'tb_course.course_id', '=', 'tb_carts.course_id')
        ->where('tb_carts.status', 'paid')
        ->where('tb_course.course_id', $id)
        ->select('tb_user.*')
        ->get();

        return view('Admin.Progress.all-student')
        ->with('all_student', $all_student)
        ->with('course', $course);
    }

    public function lecture_progress($course_id, $user_id){
        $lectures = DB::table('tb_lectures')
        ->leftjoin('tb_lecture_progress', 'tb_lecture_progress.lecture_id', '=', 'tb_lectures.lecture_id')
        ->leftjoin('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->leftjoin('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id)
        ->select('tb_lectures.title', 'tb_course.name', 'tb_lecture_progress.progress', 'tb_lecture_progress.user_id')
        ->get();

        foreach ($lectures as $lecture) {
            if (isset($lecture->user_id) && $lecture->user_id == $user_id) {
                $lecture->user_progress = $lecture->progress; 
            } else {
                $lecture->user_progress = 0; 
            }
        }


        $course = Courses::find($course_id);
        $user = Users::find($user_id);

        return view('Admin.Progress.lecture-progress')
        ->with('user', $user)
        ->with('course', $course)
        ->with('lectures', $lectures);
    } 

    public function exercise_progress($course_id, $user_id){
        $exercise = DB::table('tb_exercises')
        ->leftjoin('tb_lectures', 'tb_lectures.lecture_id', '=', 'tb_exercises.lecture_id')
        ->leftjoin('tb_exercise_submission', 'tb_exercise_submission.exercises_id', '=', 'tb_exercises.exercises_id')
        ->leftjoin('tb_chapters', 'tb_chapters.chapter_id', '=', 'tb_lectures.chapter_id')
        ->leftjoin('tb_course', 'tb_course.course_id', '=', 'tb_chapters.course_id')
        ->where('tb_course.course_id', $course_id)
        ->select('tb_exercises.title', 'tb_exercises.exercises_id', 'tb_course.name', 'tb_exercise_submission.status', 'tb_exercise_submission.file_path', 'tb_exercise_submission.score', 'tb_exercise_submission.user_id')
        ->get();
        
        foreach($exercise as $ex){
             if (isset($ex->user_id) && $ex->user_id == $user_id) {
                $ex->user_progress = $ex->score; 
            } else {
                $ex->user_progress = 0; 
            }
        }

        $course = Courses::find($course_id);
       
        $user = Users::find($user_id);

        return view('Admin.Progress.exercise-progress')
        ->with('user', $user)
        ->with('course', $course)
        ->with('exercise', $exercise);
        
    }

    public function exercise_submission($exercises_id, $course_id ,$user_id){
        $user = Users::find($user_id);
        $course = Courses::find($course_id);
        $exercise = Exercises::find($exercises_id);

        $existingSubmission = DB::table('tb_exercise_submission')
        ->where('exercises_id', $exercises_id)
        ->where('user_id', $user_id)
        ->first();

        return view('Admin.Progress.exercise-grading')
        ->with('user', $user)
        ->with('course', $course)
        ->with('exercise', $exercise)
        ->with('existingSubmission', $existingSubmission);
    }

    public function exercise_grading(Request $request){
        $user_id = $request->user_id;
        $course_id = $request->course_id;
        $exercises_id = $request->exercises_id;
        $existingSubmission = DB::table('tb_exercise_submission')
        ->where('exercises_id', $exercises_id)
        ->where('user_id', $user_id)
        ->first();

        $data = [
            'user_id' => $request->user_id,
            'exercises_id' => $request->exercises_id,
            'file_path' => $request->file_path,
            'score' => $request->score,
            'feedback' => $request->feedback,
            'submission_date' => now(),
            'status' => $request->status ? 1 : 0,

        ];

        if($existingSubmission) {
            DB::table('tb_exercise_submission')
            ->where('exercises_id', $exercises_id)
            ->where('user_id', $user_id)
            ->update($data);
        } else {
            ExerciseSubmission::create($data);
        }

        return Redirect::to('Admin/exercise-progress/'.$course_id.'/'.$user_id)
        ->with('msg', 'Chấm điểm bài tập thành công');
    }


}
