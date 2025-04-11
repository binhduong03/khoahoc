@extends('admin')     
@section('page-title', 'Chấm điểm bài tập')  
@section('contents')   

<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Sửa</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Chấm điểm bài tập</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="card">
        <div class="card-body">
            <form action="{{ URL::to('Admin/update-submission') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->user_id}}">
                <input type="hidden" name="course_id" value="{{$course->course_id}}">
                <input type="hidden" name="exercises_id" value="{{$exercise->exercises_id}}">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="user_id" class="form-label">Học viên</label>
                        <input class="form-control" type="text" name="fullname" value="{{$user->fullname}}" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label for="exercises_id" class="form-label">Bài tập</label>
                        <input class="form-control" type="text" name="title" value="{{$exercise->title}}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    
                    <div class="col-sm-6">
                        <label for="submission_date" class="form-label">Ngày nộp bài</label>
                        <input type="date" name="submission_date" value="{{$existingSubmission->submission_date ?? ''}}" class="form-control">
                    </div>
                

                    <div class="col-sm-6">
                        <label for="score" class="form-label">Điểm</label>
                        <input type="number" step="0.01" name="score" value="{{$existingSubmission->score ?? ''}}" class="form-control" min="0" max="10">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="feedback" class="form-label">Nhận xét</label>
                        <textarea rows="5" name="feedback" class="form-control">{{$existingSubmission->feedback ?? ''}}
                        </textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="file_path" class="form-label">File bài tập</label>
                        <div class="input-group">
                            <!-- Kiểm tra nếu đã có file bài tập -->
                            @if (!empty($existingSubmission->file_path))
                                <a href="{{ asset('public/backend/exercise/nap_bai/' . $existingSubmission->file_path) }}" target="_blank" class="btn btn-primary">
                                    Xem bài tập
                                </a>
                                <input type="hidden" name="file_path" value="{{$existingSubmission->file_path}}">
                            @else
                                <span class="text-muted">Không có bài tập nào</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-check custom-checkbox mb-3 checkbox-success">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3" 
                            {{ isset($existingSubmission) && $existingSubmission->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="customCheckBox3">Đã nộp</label>
                        </div>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ URL::to('Admin/all-submissions') }}" class="btn btn-secondary">Thoát</a>      
                            <button type="submit" class="btn btn-danger mb-2">Lưu</button>  
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
