@extends('welcome')
@section('content')

<div class="container my-5 text-white">
  <div class="row course-detail bg-dark p-4 shadow justify-content-between" 
        style="border-radius: 2rem; border-top: 0.8px solid #007bff; border-left: 0.8px solid #007bff; border-right: 0.8px solid #007bff;">
    
    <!-- Nội dung khóa học -->
    <div class="col-md-7">
      <h2 class="course-title text-warning">{{ $course_detail->name }}</h2>
      <p><i class="fas fa-chalkboard-teacher"></i> <span class="text-light">{{ $course_detail->user->fullname }}</span></p>
      <p><i class="fas fa-clock"></i> <span>{{$course_detail->duration}} ngày</span></p>
      <p><i class="fas fa-info-circle"></i> <span>{{ $course_detail->description }}</span></p>
      <div class="mt-4">
          <span class="icon"><i class="fas fa-book"></i> <span></span>Bài giảng: {{$total_lectures}}</span>
          <span class="icon ms-3"><i class="fas fa-pencil-alt"></i> <span></span> Bài tập: {{$total_exercise}}</span>
      </div>
      <!-- Nút Đăng ký ngay -->
     <div class="mt-4">
      <form action="{{URL::to('save-cart')}}" method="post">
        @csrf
        <input type="hidden" name="courseid_hidden" value="{{$course_detail->course_id}}">
        <button type="submit" 
           class="btn btn-primary rounded-pill px-4 py-2">
          <i class="fas fa-clipboard-check me-2"></i> Đăng ký ngay
        </button>
      </form>
        
      </div>
    </div>

    <!-- Hình ảnh khóa học -->
    <div class="col-md-4 d-flex justify-content-center align-items-center">
      <img src="{{ asset('public/backend/images/courses/'. $course_detail->image) }}" 
           alt="Course Image" 
           class="img-fluid rounded-3 border border-light" 
           style="max-height: 200px;">
    </div>
  </div>
</div>



<div class="container mt-4">
    <div class="content-section">
        <h2 class="mt-4">Nội dung khóa học</h2>
        <div class="accordion" id="courseContent">
            <!-- Chương đầu tiên được đặt là active -->
            @foreach($chapters as $index => $all)
            <div class="accordion-item">
                <h4 class="accordion-header" id="chapter-{{ $index }}">
                    <button class="accordion-button bg-info text-white {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}">
                        <!-- Thêm icon cho chương -->
                        <i class="fa {{ $index == 0 ? 'fa-chevron-down' : 'fa-chevron-right' }} me-2"></i>
                        {{ $all->title }}
                    </button>
                </h4>
                <div id="collapse-{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="chapter-{{ $index }}" data-bs-parent="#courseContent">
                    <div class="accordion-body">
                        <!-- Bài giảng trong chương -->
                        @foreach($all->lectures as $bg)
                        <div class="mb-3">
                            <h5 class="fw-bold">
                                <a href="{{URL::to('khoa-hoc/bai-giang/'. $bg->lecture_id)}}" class="text-decoration-none text-dark">
                                    <!-- Thêm icon cho bài giảng -->
                                    <i class="fa fa-play-circle me-2"></i>{{ $bg->title }}
                                </a>
                            </h5>
                            <ul class="list-unstyled ms-3">
                                @foreach($bg->exercise as $bt)
                                <li>
                                    <a href="{{URL::to('khoa-hoc/bai-tap/'. $bt->exercises_id)}}" class="text-decoration-none">
                                        <i class="fa fa-check-circle me-2"></i>Bài {{ $loop->iteration }}: {{ $bt->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
