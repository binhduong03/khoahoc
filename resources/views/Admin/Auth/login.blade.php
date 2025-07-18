<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard">
    
    <!-- PAGE TITLE HERE -->
    <title>Admin Dashboard</title>
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{asset('public/backend/images/favicon.png')}}">
    <link href="{{asset('public/backend/css/style.css')}}" rel="stylesheet">
    
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <h2 class="text-center title"><strong>Đăng nhập</strong></h2>
                                    </div>
                                    <h4 class="text-center mb-4">Đăng nhập tài khoản của bạn</h4>

                                    <form action="{{route('admin.auth')}}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Mật khẩu</strong></label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <div class="mb-3">
                                                <div class="form-check custom-checkbox ms-1">
                                                    <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Nhớ mật khẩu</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <a href="page-forgot-password.html">Quên mật khẩu?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Chưa có tài khoản? <a class="text-primary" href="page-register.html">Đăng ký</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('public/backend/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('public/backend/js/custom.min.js')}}"></script>
    <script src="{{asset('public/backend/js/dlabnav-init.js')}}"></script>
    <script src="{{asset('public/backend/js/styleSwitcher.js')}}"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('msg'))
                // Hiển thị thông báo lỗi với SweetAlert
                swal({
                    title: "Đăng nhập không thành công!",
                    text: "{{ session('error') }}",
                    type: "error",
                    timer: 3000, // Thời gian tự động đóng sau 3 giây
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</body>
</html>
