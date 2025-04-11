@extends('welcome')
@section('content')

<div class="container my-5 text-white">
  <div class="row course-detail bg-dark p-4 shadow justify-content-between" 
       style="border-radius: 2rem; border-top: 0.8px solid #007bff; border-left: 0.8px solid #007bff; border-right: 0.8px solid #007bff;">
    <!-- Nội dung khóa học -->
    <div class="col-md-7">
      <h2 class="course-title text-warning">{{$course->name}}</h2>
      <p><i class="fas fa-chalkboard-teacher"></i> <span class="text-light">{{$course->fullname}}</span></p>
      <p><i class="fas fa-clock"></i> <span>{{$course->duration}} ngày</span></p>
      <p><i class="fas fa-info-circle"></i> <span>{{$course->description}}</span></p>
      <div class="mt-4">
          <span class="icon"><i class="fas fa-book"></i> <span>{{$countlecture}}</span> Bài giảng</span>
          <span class="icon ms-3"><i class="fas fa-pencil-alt"></i> <span>{{$countexercise}}</span> Bài tập</span>
      </div>
    </div>

    <!-- Hình ảnh khóa học -->
    <div class="col-md-4 d-flex justify-content-center align-items-center">
      <img src="{{ asset('public/backend/images/Courses/'. $course->image) }}" 
           alt="Course Image" 
           class="img-fluid rounded-3 border border-light" 
           style="max-height: 200px;">
    </div>
  </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Phần Video -->
        <div class="col-lg-8">
            <div class="ratio ratio-16x9">
                <video id="videoPlayer" controls>
                    <source src="{{ asset('public/backend/images/lecture/'.$course_lecture->media_url) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <h2 class="video-title text-warning mt-2"></h2>
            <hr>

            <!-- Thanh Tiến Độ -->
            <div class="progress" style="height: 20px; border-radius: 10px; position: relative;">
                <div id="progressBar" 
                     class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                     role="progressbar" 
                     style="width: 0%;" 
                     aria-valuenow="0" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
                <span id="progressPercentage" 
                      class="position-absolute w-100 text-center fw-bold" 
                      style="top: 0; color: #212529; line-height: 20px;">
                    0%
                </span>
            </div>

        </div>

        <!-- Phần Danh Sách Bài Giảng -->
        <div class="col-lg-4">
            <p class="list-group-item list-group-item-header bg-info text-white border-0 m-0">Bài giảng:</p>
            <ul class="list-group bg-light" style="max-height: 450px; overflow-y: auto;">
                @foreach($all_lecture as $all)
                    <li class="list-group-item bg-light padding-0 border-0">
                        <a class="{{ request()->is('khoa-hoc/bai-giang/' . $all->lecture_id) ? 'active text-danger fw-bold' : '' }}" 
                           href="{{ URL::to('khoa-hoc/bai-giang/'. $all->lecture_id) }}">
                           Bài {{$loop->index+1}}: {{$all->title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const videoPlayer = document.getElementById('videoPlayer');
    const progressBar = document.getElementById('progressBar');
    const progressPercentage = document.getElementById('progressPercentage'); 
    const lectureId = {{ $course_lecture->lecture_id }};
    const savedProgress = {{ $lecture_progress }}; 

    let lastSentProgress = savedProgress; 

    videoPlayer.addEventListener('loadedmetadata', () => {
        if (savedProgress > 0) {
            videoPlayer.currentTime = (savedProgress / 100) * videoPlayer.duration; 
        }
    });

    function sendProgress(isVideoEnded = false) {
        const currentTime = videoPlayer.currentTime;
        const totalTime = videoPlayer.duration;
        const percentage = (currentTime / totalTime) * 100;

        const progressToSend = isVideoEnded ? 100 : parseFloat(percentage.toFixed(2));

        progressBar.style.width = progressToSend + '%';
        progressBar.setAttribute('aria-valuenow', progressToSend);
        progressPercentage.textContent = progressToSend.toFixed(2) + '%';

        // Gửi tiến độ nếu có sự thay đổi lớn hơn 1%
        if (Math.abs(progressToSend - lastSentProgress) > 1 || isVideoEnded) {
            $.ajax({
                url: "{{ URL::to('/save-video-progress') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    lecture_id: lectureId,
                    progress: progressToSend
                },
                success: function(response) {
                    console.log(response.status);
                },
                error: function(xhr) {
                    console.error("Không thể lưu tiến độ:", xhr);
                }
            });
            lastSentProgress = progressToSend;
        }
    }

    // Cập nhật và gửi tiến độ mỗi giây
    setInterval(() => sendProgress(), 1000);

    // Gửi tiến độ 100% khi video kết thúc
    videoPlayer.addEventListener('ended', () => {
        sendProgress(true);
    });
</script>
@endsection
