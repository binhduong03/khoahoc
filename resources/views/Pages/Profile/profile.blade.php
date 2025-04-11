@extends('welcome')
@section('content')

<style>
    /* Thẻ hồ sơ */
    .profile-card {
        transition: transform 0.3s ease;
        border-radius: 1rem;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .profile-card:hover {
        transform: scale(1.05);
    }

    .profile-card .edit-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 20px;
        background-color: #fff;
        color: #007bff;
        border: 1px solid #007bff;
        transition: background-color 0.3s, color 0.3s;
    }

    .profile-card .edit-btn:hover {
        background-color: #007bff;
        color: #fff;
    }

    .img-area {
        background-color: #007bff;
        height: 120px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: flex-end;
    }

    .img-area img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #fff;
        position: absolute;
        bottom: -30px;
    }

    .profile-info {
        text-align: center;
        padding: 60px 20px 20px;
        background-color: #fff;
    }

    .profile-info h3 {
        margin: 10px 0;
    }

    .profile-info p {
        color: #666;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .social-icons a {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 20px;
        color: #fff;
        transition: all 0.3s;
    }

    .social-icons a:hover {
        transform: scale(1.2);
    }

    .social-icons .facebook { background-color: #3b5998; }
    .social-icons .twitter { background-color: #1da1f2; }
    .social-icons .instagram { background-color: #e1306c; }
    .social-icons .youtube { background-color: #ff0000; }

    /* Thống kê */
    .statistics {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .statistics table {
        margin-top: 20px;
    }

    .progress {
        height: 15px;
    }

    .course-detail {
        border-radius: 1rem; /* Thêm bo góc cho thẻ khóa học */
        transition: transform 0.3s ease;
        overflow: hidden;
    }

    .course-detail:hover {
        transform: scale(1.02);
    }
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Thông tin cá nhân -->
        <div class="col-md-4">
            <div class="profile-card text-center position-relative">
                <!-- Nút chỉnh sửa -->
                <button class="btn btn-outline-primary edit-btn">
                    <i class="fas fa-edit"></i>
                </button>
                <div class="img-area">
                    <img src="{{ asset('public/backend/images/user/' . session('Avatar')) }}" alt="Profile Picture">
                </div>
                <div class="profile-info">
                    <h3 class="fw-bold">{{ session('fullName') }}</h3>
                    <p class="text-secondary">Học viên</p>
                    <p class="text-secondary">Email: {{ session('Email') }}</p>
                    <p class="text-secondary">SĐT: {{ session('SDT') }}</p>
                    <div class="social-icons">
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê khóa học -->
        <div class="col-md-8">
            <div class="statistics">
                <h4 class="text-center fw-bold">Khóa học đang học</h4>
                <div class="row">
                    @foreach ($registeredCourses as $course)
                    <div class="col-md-6 mb-4">
                        <div class="course-detail card bg-dark text-light" style="border-radius: 1rem;">
                            <div class="card-body d-flex">
                                <!-- Thông tin khóa học bên trái -->
                                <div class="flex-grow-1 me-3">
                                    <h5 class="course-title text-warning">{{ $course->course_name }}</h5>
                                    <div class="progress rounded-pill mt-2">
                                        <div 
                                            class="progress-bar 
                                            @if($course->progress_percentage >= 50) bg-info 
                                            @elseif($course->progress_percentage >= 30) bg-warning 
                                            @else bg-danger @endif progress-bar-striped progress-bar-animated" 
                                            role="progressbar" 
                                            style="width: {{ $course->progress_percentage }}%;" 
                                            aria-valuenow="{{ $course->progress_percentage }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ number_format($course->progress_percentage, 0) }}% <!-- Hiển thị phần trăm trong thanh tiến trình -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Hình ảnh khóa học bên phải -->
                                <div class="ms-3">
                                    <img src="{{ asset('public/backend/images/courses/' . $course->image) }}" 
                                         alt="Course Image" 
                                         class="img-fluid rounded-3 border border-light" 
                                         style="max-height: 120px; width: auto; height: auto; object-fit: contain;"> <!-- Sử dụng object-fit để tránh bóp méo -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
