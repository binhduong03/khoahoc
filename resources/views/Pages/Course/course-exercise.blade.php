@extends('welcome')
@section('content')

<div class="container my-5 text-white">
  <div class="row course-detail bg-dark p-4 shadow justify-content-between" 
       style="border-radius: 2rem; border-top: 0.8px solid #007bff; border-left: 0.8px solid #007bff; border-right: 0.8px solid #007bff;">
    <!-- Nội dung khóa học -->
    <div class="col-md-7">
      <h2 class="course-title text-warning">{{ $course->name }}</h2>
      <p><i class="fas fa-chalkboard-teacher"></i> <span class="text-light">{{ $course->fullname }}</span></p>
      <p><i class="fas fa-clock"></i> <span>4 tuần</span></p>
      <p><i class="fas fa-info-circle"></i> <span>{{ $course->description }}</span></p>
      <div class="mt-4">
          <span class="icon"><i class="fas fa-book"></i> <span>{{ $countlecture }}</span> Bài giảng</span>
          <span class="icon ms-3"><i class="fas fa-pencil-alt"></i> <span>{{ $countexercise }}</span> Bài tập</span>
      </div>
    </div>

    <!-- Hình ảnh khóa học -->
    <div class="col-md-4 d-flex justify-content-center align-items-center">
      <img src="{{ asset('public/backend/images/courses/'. $course->image) }}" 
           alt="Course Image" 
           class="img-fluid rounded-3 border border-light" 
           style="max-height: 200px;">
    </div>
  </div>
</div>

<div class="container mt-4">
    <div class="row">
        <h2 class="pdf-title text-warning mt-2">{{ $course_exercise->title }}</h2>
        <div class="col-lg-8">
           <div class="pdf-container text-center">
                <!-- Hiển thị tên file và liên kết mở file trong tab mới -->
                <p> Bài tập: 
                    <a href="{{ asset('public/Backend/images/exercise/'.$course_exercise->file_path) }}" 
                       target="_blank" class="text-decoration-none fw-bold text-primary">
                        {{ basename($course_exercise->file_path) }}
                    </a>
                </p>
            </div>

            <!-- Form nạp bài tập -->
            <div class="upload-section mt-4 p-4 rounded border border-primary bg-light shadow-sm">
                <h5 class="text-primary text-center mb-3">Nạp bài tập của bạn</h5>
                <form action="{{URL::to('save-exercise-progress')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="exercise_id" value="{{$course_exercise->exercises_id}}">
                    <div class="mb-4">
                        <label for="exerciseFile" class="form-label fw-bold">Chọn file bài tập</label>
                        <div class="input-group">
                            <div class="input-group-text bg-primary text-white">
                                <i class="fas fa-upload"></i> <!-- Icon tải lên -->
                            </div>
                            <input type="file" class="form-control" id="exerciseFile" name="file_path" required>
                        </div>
                        <small class="form-text text-muted">Chấp nhận các định dạng PDF, DOCX, hoặc các định dạng file khác.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Nạp bài tập</button>
                </form>
            </div>

        </div>

        <div class="col-lg-4">
            <p class="list-group-item list-group-item-header bg-info text-white border-0 m-0">Bài tập: {{ $course_exercise->name }}</p>
            <ul class="list-group bg-light list-unstyled" style="max-height: 450px; overflow-y: auto;">
                @foreach($all_exercise as $all)
                    <li class="list-group-item bg-light padding-0 border-0">
                        <a class="{{ request()->is('khoa-hoc/bai-tap/'. $all->exercises_id) ? 'active text-danger fw-bold' : '' }}" 
                           href="{{ URL::to('khoa-hoc/bai-tap/'. $all->exercises_id) }}">Bài {{$loop->iteration}}:
                            {{$all->title}}
                        </a>
                    </li>
                @endforeach   
            </ul>

            
        </div>
    </div>
</div>





@endsection
