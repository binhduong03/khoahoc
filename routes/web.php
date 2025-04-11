<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SendPdfController;

Route::get('send-email-pdf', [SendPdfController::class, 'sendEmailPDF']);

//Trang chủ
Route::get('/', [HomeController::class, 'trangchu']);
Route::get('/trang-chu', [HomeController::class, 'trangchu'])->name('trangchu');

//Khóa học
Route::get('/khoa-hoc', [CourseController::class, 'course'])->name('khoahoc');
Route::get('/khoa-hoc/{course_id}', [CourseController::class, 'course_detail']);
Route::get('/khoa-hoc/bai-giang/{lecture_id}', [CourseController::class, 'course_lecture']);
Route::get('/khoa-hoc/bai-tap/{exercise_id}', [CourseController::class, 'course_exercise']);


//Combo Khóa học
Route::get('/combo-khoa-hoc', [ComboController::class, 'combo_course'])->name('combo-khoa-hoc');
Route::get('/combo-khoa-hoc/{combo_id}', [ComboController::class, 'combo_detail']);

//Đăng nhập
Route::get('/dang-nhap', [AuthController::class, 'dang_nhap'])->name('dang-nhap');
Route::post('/dang-nhap/auth', [AuthController::class, 'auth_dangnhap'])->name('authdang-nhap');

Route::get('/thong-tin-ca-nhan', [UserController::class, 'profile'])->name('profile');

//Đăng ký
Route::post('/lay-otp', [SendPdfController::class, 'sendOtp']);
Route::post('/dang-ky', [AuthController::class, 'auth_dangky']);


//Giỏ Hàng
Route::get('/gio-hang', [CartController::class, 'show_cart'])->name('gio-hang');
Route::post('/save-cart', [CartController::class, 'save_cart'])->name('save-cart');
Route::post('/save-discount',[CartController::class, 'save_discount'])->name('save-discount');
Route::post('/delete-cart/{id}',[CartController::class, 'delete_cart']);

//Thanh toán
Route::post('/save-payment', [PaymentController::class, 'save_payment'])->name('luu-thanh-toan');
Route::get('/thanh-toan', [PaymentController::class, 'payment'])->name('thanh-toan');


//Tiến độ học
Route::post('/save-video-progress', [ProgressController::class, 'saveVideoProgress']);
Route::post('/save-exercise-progress', [ProgressController::class, 'save_exercise_progress']);


//ADMIN

//Home
Route::get('Admin/dashboard', [HomeController::class, 'dashboard_admin'])->name('admin.dashboard');


//Course
Route::get('Admin/all-course', [CourseController::class, 'all_course'])->name('admin.all-course');
Route::get('Admin/edit-course/{id}', [CourseController::class, 'edit_course'])->name('admin.edit-course');
Route::post('Admin/save-course', [CourseController::class, 'save_course'])->name('admin.save-course');
Route::post('Admin/delete-course', [CourseController::class, 'delete_course'])->name('admin.delete-course');

Route::post('Admin/update-course/{id}',[CourseController::class, 'update_course'])->name('admin.update-course');

//User
//Giáo viên
Route::get('Admin/all-teacher', [UserController::class, 'all_teacher'])->name('admin.all-teacher');
Route::get('Admin/edit-teacher/{id}', [UserController::class, 'edit_teacher'])->name('admin.edit-teacher');
Route::post('Admin/update-teacher/{id}', [UserController::class, 'update_teacher'])->name('admin.update-teacher');
Route::post('Admin/save-teacher', [UserController::class, 'save_teacher'])->name('admin.save-teacher');
Route::post('Admin/delete-teacher',[UserController::class, 'delete_teacher'])->name('admin.delete-teacher');

//Học viên
Route::get('Admin/all-student', [UserController::class, 'all_student'])->name('admin.all-student');
Route::get('Admin/edit-student/{id}', [UserController::class, 'edit_student'])->name('admin.edit-student');
Route::post('Admin/update-student/{id}', [UserController::class, 'update_student'])->name('admin.update-student');
Route::post('Admin/save-student', [UserController::class, 'save_student'])->name('admin.save-student');
Route::post('Admin/delete-student',[UserController::class, 'delete_student'])->name('admin.delete-student');

// Combo
Route::get('Admin/all-combo', [ComboController::class, 'all_combo'])->name('admin.all-combo');
Route::get('Admin/edit-combo/{id}', [ComboController::class, 'edit_combo'])->name('admin.edit-combo');
Route::post('Admin/update-combo/{id}', [ComboController::class, 'update_combo'])->name('admin.update-combo');
Route::get('Admin/add-combo', [ComboController::class, 'add_combo'])->name('admin.add-combo');
Route::post('Admin/save-combo', [ComboController::class, 'save_combo'])->name('admin.save-combo');
Route::post('Admin/delete-combo', [ComboController::class, 'delete_combo'])->name('admin.delete-combo');

//Lecture
Route::get('Admin/course-lecture',[LectureController::class, 'all_course'])->name('admin.course-lecture');
Route::get('Admin/all-lecture/{course_id}',[LectureController::class, 'all_lecture'])->name('admin.all-lecture');
Route::get('Admin/add-lecture/{course_id}', [LectureController::class, 'add_lecture'])->name('admin.add-lecture');
Route::post('Admin/save-lecture',[LectureController::class, 'save_lecture'])->name('admin.save-lecture');
Route::post('Admin/delete-lecture', [LectureController::class, 'delete_lecture'])->name('admin.delete-lecture');
Route::get('Admin/edit-lecture/{lecture_id}/{course_id}', [LectureController::class, 'edit_lecture'])->name('admin.edit-lecture');
Route::post('Admin/update-lecture',[LectureController::class, 'update_lecture'])->name('admin.update-lecture');

//Exercise 
Route::get('Admin/course-exercise',[ExerciseController::class, 'all_course'])->name('admin.course-exercise');
Route::get('Admin/all-exercise/{course_id}',[ExerciseController::class, 'all_exercise'])->name('admin.all-exercise');
Route::post('Admin/update-exercise', [ExerciseController::class, 'update_exercise'])->name('admin.update-exercise');
Route::post('Admin/delete-exercise', [ExerciseController::class, 'delete_exercise'])->name('admin.delete-exercise');
Route::post('Admin/save-exercise', [ExerciseController::class, 'save_exercise'])->name('admin.save-exercise');

//Progress
Route::get('Admin/course-progress', [ProgressController::class, 'all_course'])->name('admin.course-progress');
Route::get('Admin/course-progress/student/{course_id}', [ProgressController::class, 'all_student_progress']);
Route::get('Admin/lecture-progress/{course_id}/{user_id}', [ProgressController::class, 'lecture_progress']);
Route::get('Admin/exercise-progress/{course_id}/{user_id}', [ProgressController::class, 'exercise_progress']);
Route::get('Admin/exercise-submission/{exercises_id}/{course_id}/{user_id}', [ProgressController::class, 'exercise_submission']);
Route::post('Admin/update-submission',[ProgressController::class, 'exercise_grading']);

//Payment
Route::get('Admin/all-payment', [PaymentController::class, 'all_payment'])->name('admin.all-payment');
Route::post('Admin/update-payment-status', [PaymentController::class, 'update_payment_status'])->name('admin.update-payment-status');
Route::get('Admin/detail-payment/{payment_id}', [PaymentController::class, 'detail_payment']);

//Chapter
Route::post('Admin/save-chapter',[ChapterController::class, 'save_chapter'])->name('admin.save-chapter');
Route::get('Admin/course-chapter',[ChapterController::class, 'all_course'])->name('admin.course-chapter');
Route::get('Admin/all-chapter/{course_id}',[ChapterController::class, 'all_chapter'])->name('admin.all-chapter');
Route::post('Admin/delete-chapter', [ChapterController::class, 'delete_chapter'])->name('admin.delete-chapter');
Route::post('Admin/update-chapter', [ChapterController::class, 'update_chapter'])->name('admin.update-chapter');

//Discount
Route::get('Admin/all-discount', [DiscountController::class, 'all_discount'])->name('admin.all-discount');

//Đăng nhập
Route::get('Admin/login-admin',[AuthController::class, 'login_admin'])->name('admin.dang-nhap');
Route::post('Admin/login-admin/auth', [AuthController::class, 'auth_login'])->name('admin.auth');
Route::get('Admin/logout', [AuthController::class, 'logout_admin']);