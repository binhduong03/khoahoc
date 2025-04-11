@extends('admin')
@section('page-title', 'Bài Giảng')
@section('contents')

<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Sửa</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Bài Giảng</a></li>
        </ol>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Sửa Bài Giảng</h5>
        </div>

        <div class="card-body">
            <form action="{{route('admin.update-lecture')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$edit_lecture->title}}" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="4" required>{{$edit_lecture->content }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="chapter" class="form-label">Chọn Chương</label>
                    <div class="input-group text-">
                        <label for="chapter" class="input-group-text mb-0">Chương</label>
                        <select class="form-select" id="chapter" name="chapter_id">
                            @foreach($chapter as $chapter)
                                <option value="{{ $chapter->chapter_id }}" 
                                        {{ $edit_lecture->chapter_id == $chapter->chapter_id ? 'selected' : '' }}>
                                    {{ $chapter->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="content" class="form-label">Loại tài liệu</label>
                      <div class="input-group">
                            <label for="media-type" class="input-group-text mb-0">Loại tài liệu</label>
                            <select class="form-select" id="media-type" name="media_type" required>
                                <option value="video">Video</option>
                                <option value="PDF" >PDF</option>
                            </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tải tài liệu </label>
                   <div class="input-group mb-3">
                        <div class="form-file">
                            <input type="file" name="media_url" class="form-file-input form-control">
                        </div>
                        <span class="input-group-text">Tải lên</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Thứ tự hiển thị</label>
                    <input type="number" class="form-control" id="order" name="order" value="{{ $edit_lecture->order}}" required>
                </div>

                <input type="hidden" name="lecture_id" value="{{$edit_lecture->lecture_id}}">
                 <input type="hidden" name="course_id" value="{{$courseID->course_id}}">
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ $edit_lecture->status ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Hoạt động</label>
                    </div>
                </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
             <a href="{{URL::to('Admin/all-lecture/'. $courseID->course_id)}}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
            <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>

@endsection
