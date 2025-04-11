<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendReportEmail;
use Illuminate\Support\Facades\Mail;
use Session;
session_start();

class SendPdfController extends Controller
{
    public function SendEmailPDF(){
        $title = 'PDF mail từ hoctaptructuyen.com';
        $body = 'Đây là mail được gửi từ hoctaptructuyen.com';
        Mail::to('binhduongx6qs10@gmail.com')->send(new SendReportEmail($title, $body));

        return "Email kèm theo tệp pdf đã được gửi thành công.";
    }

    public function sendEmail(){
        $subject = "Test Email";
        $content = "test thử gửi email";

        Mail::to('binhduongx6qs10@gmail.com')
            ->send(new SendReportEmail($subject, $content));

        return 'Gửi email thành công';
    }

    public function sendOtp(Request $request)
    {
        $otp = rand(1000, 9999);

        Session::put('otp', $otp);
        Session::put('otp_email', $request->email);

        $subject = "Mã OTP xác nhận đăng ký";
        $body = "Xin chào, mã OTP của bạn là: $otp. Mã này có hiệu lực trong 10 phút.";
        Mail::to($request->email)->send(new SendReportEmail($subject, $body, $otp));

        return redirect()->back()->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }



}
