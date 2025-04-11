@extends('welcome')
@section('content')
<div class="container my-5 text-white">
    <div class="row course-detail bg-dark p-4 shadow justify-content-between"
        style="border-radius: 2rem; border-top: 0.8px solid #007bff; border-left: 0.8px solid #007bff; border-right: 0.8px solid #007bff;">

        <!-- Nội dung combo khóa học -->
        <div class="col-md-7">
            <h2 class="course-title text-warning">{{ $combo_detail->name }}</h2>
            <p><i class="fas fa-info-circle"></i> <span class="text-light">{{ $combo_detail->description }}</span></p>
            <p><i class="fas fa-dollar-sign"></i> <span>Giá: {{ number_format($combo_detail->price) }} VNĐ</span></p>

            <!-- Số lượng khóa học trong combo -->
            <div class="mt-2">
                <span class="icon"><i class="fas fa-book"></i> <span></span> Số khóa học: {{$total_courses}}</span>
            </div>

            <!-- Nút Đăng ký combo -->
            <div class="mt-4">
                <form action="{{ URL::to('save-combo-cart') }}" method="post">
                    @csrf
                    <input type="hidden" name="combo_id_hidden" value="{{ $combo_detail->combo_id }}">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="fas fa-clipboard-check me-2"></i> Đăng ký ngay
                    </button>
                </form>
            </div>
        </div>

        <!-- Hình ảnh combo khóa học -->
        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <img src="{{ asset('public/backend/images/combo/'. $combo_detail->image) }}" alt="Combo Image"
                class="img-fluid rounded-3 border border-light" style="max-height: 200px;">
        </div>
    </div>
    <div class="container mt-4">
        <div class="content-section">
            <h2 class="mt-4">Nội dung Combo Khóa Học</h2>
            <div class="accordion" id="comboContent">
                @foreach($course_details as $course)
                <div class="accordion-item">
                    <h4 class="accordion-header" id="course-{{ $course->course_id }}">
                        <button class="accordion-button bg-info text-white" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $course->course_id }}" aria-expanded="true"
                            aria-controls="collapse-{{ $course->course_id }}">
                            <i class="fa fa-book me-2"></i>
                            {{ $course->details['course_detail']->name }} 
                        </button>
                    </h4>
                    <div id="collapse-{{ $course->course_id }}" class="accordion-collapse collapse show"
                        aria-labelledby="course-{{ $course->course_id }}" data-bs-parent="#comboContent">
                        <div class="accordion-body">
                            @foreach($course->details['course_detail']->chapters as $chapter)
                            <div class="chapter-item mb-4">
                                <h5 class="fw-bold">{{ $chapter->title }}</h5>
                                <div class="lecture-list">
                    
                                    @foreach($chapter->lectures as $lecture)
                                    <div class="mb-2">
                                        <a href="{{ URL::to('khoa-hoc/bai-giang/'. $lecture->lecture_id) }}"
                                            class="text-decoration-none text-dark">
                                            <i class="fa fa-play-circle me-2"></i>{{ $lecture->title }}
                                        </a>
                                       
                                        <ul class="list-unstyled ms-3">
                                            @foreach($lecture->exercise as $exercise)
                                            <li>
                                                <a href="{{ URL::to('khoa-hoc/bai-tap/'. $exercise->exercises_id) }}"
                                                    class="text-decoration-none">
                                                    <i class="fa fa-check-circle me-2"></i>Bài {{ $loop->iteration }}:
                                                    {{ $exercise->title }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection