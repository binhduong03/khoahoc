<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- link css -->
    <link rel="stylesheet" href="{{asset('public/frontend/css/stylelogin.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" integrity="sha512-ZnR2wlLbSbr8/c9AgLg3jQPAattCUImNsae6NHYnS9KrIwRdcY9DxFotXhNAKIKbAXlRnujIqUWoXXwqyFOeIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập/Đăng ký</title>
</head>
<body>
    <div class="container">

        <div class="box">
            <div class="form sign_in">
                <h3>Đăng nhập</h3>
                <span>Sử dụng tài khoản của bạn</span>

                <form action="{{route('authdang-nhap')}}" method="post" id="form_input">
                    @csrf
                    <div class="type">
                        <input type="email" placeholder="Nhập email" name="email" id="email">
                    </div>
                    <div class="type">
                        <input type="password" placeholder="Nhập mật khẩu" name="password" id="password">
                    </div>

                    <div class="forgot">
                        <span>Quên mật khẩu?</span>
                    </div>

                    <button class="btn bkg">Đăng nhập</button>
                </form>
            </div>
    
            <div class="form sign_up">
                <h3>Đăng ký</h3>
                <span>sử dụng email của bạn để đăng ký</span>

                <form action="{{URL::to('lay-otp')}}" method="post" id="form_input">
                    @csrf
                    <div class="type">
                        <input type="email" name="email" placeholder="Nhập email" id="email" required>
                    </div>
                    <button type="submit" class="btn bkg">
                        <i class="bi bi-key"></i> Lấy mã OTP
                    </button>
                </form>

                <form action="{{URL::to('dang-ky')}}" method="post" id="form_input">
                    @csrf
                    <div class="type">
                        <input type="text" name="fullname" placeholder="Nhập họ và tên" id="name" required>
                    </div>
                    <div class="type">
                        <input type="text" name="username" placeholder="Nhập tên tài khoản" id="username" required>
                    </div>
                    <div class="type">
                        <input type="email" name="email" placeholder="Nhập email" id="email" required>
                    </div>
                    <div class="type">
                        <input type="password" name="password" placeholder="Nhập mật khẩu" id="password" required>
                    </div>

                    <div class="type">
                        <input type="otp" name="otp" placeholder="Nhập mã xác nhận" required>
                    </div>
                    <button type="submit" class="btn bkg">Đăng ký</button>
                </form>
            </div>
        </div>

        <div class="overlay">
            <div class="page page_signIn">
                <h3>Chào mừng trở lại!</h3>
                <p>Để theo dõi chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>

                <button class="btn btnSign-in">Đăng ký <i class="bi bi-arrow-right"></i></button>
            </div>

            <div class="page page_signUp">
                <h3>Chào bạn!</h3>
                <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình cùng chúng tôi</p>

                <button class="btn btnSign-up">
                    <i class="bi bi-arrow-left"></i> Đăng nhập</button>
            </div>
        </div>
    </div>
    
    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                swal("Thành công!", "{{ session('success') }}", "success");
            @endif

            @if (session('error'))
                swal("Có lỗi xảy ra!", "{{ session('error') }}", "error");
            @endif
        });
    </script>

    <!-- link script -->
    <script src="{{asset('public/frontend/js/mainlogin.js')}}"></script>
    
</body>
</html>