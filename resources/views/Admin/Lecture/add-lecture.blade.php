@extends('admin')
@section('page-title', 'Bài giảng')
@section('contents')

<div class="custom-alert hide">
    <span class="fas fa-check-circle"></span>
    <span class="msg">
        @if(session('msg'))
            {{ session('msg') }}
        @endif
    </span>
    <div class="close-btn">
        <span class="fas fa-times"></span>
    </div>
</div>

<div class="container fluid">
    
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Bảng</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Bài giảng</a></li>
        </ol>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Thêm Bài Giảng</h4>
            <a data-bs-toggle="modal" data-bs-target="#add-chapter" class="btn btn-primary mb-2">
                <i class="fas fa-plus"></i> Thêm chương
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.save-lecture') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="chapter_id" class="form-label">Chương</label>
                    <select class="form-select" id="chapter_id" name="chapter_id" required>
                        <option value="">Chọn chương</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->chapter_id }}">{{ $chapter->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Tên bài giảng</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="media_type" class="form-label">Loại tài liệu</label>
                    <select class="form-select" id="media_type" name="media_type" required>
                        <option value="">Chọn loại tài liệu</option>
                        <option value="VIDEO">Video</option>
                        <option value="PDF">PDF</option>
                    </select>
                </div>

                <div class="mb-3">
                   <div class="input-group mb-3">
                        <div class="form-file">
                            <input type="file" name="media_url" class="form-file-input form-control" required>
                        </div>
                        <span class="input-group-text">Tải lên</span>
                    </div>
                </div>

                
                <div class="mb-3">
                    <label for="order" class="form-label">Thứ tự hiển thị</label>
                    <input type="number" class="form-control" id="order" name="order" required>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-check custom-checkbox mb-3 checkbox-success">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3">
                            <label class="form-check-label" for="customCheckBox3">Hoạt động</label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="course_id" value="{{$courseID->course_id}}">

                <div class="d-flex justify-content-between">
                    <a href="{{URL::to('Admin/all-lecture/'. $courseID->course_id)}}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="add-chapter" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addChapterLabel">Thêm Chương</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.save-chapter') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Khóa học</label>
                        <input class="form-control" type="text" name="course_name" value="{{ $courseID->name }}" readonly>

                        <input class="form-control" type="hidden" name="course_id" value="{{ $courseID->course_id }}">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề chương</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung chương</label>
                        <textarea class="form-control" id="content" name="content" rows="4"></textarea>
                    </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Quay lại
                </button>
                <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                </button>
                </form>
            </div>
        </div>
    </div>
</div>



    @if (session('msg'))
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
        $(window).on('load', function() {
            $('#preloader').fadeOut(500);
            var alertBox = $('.custom-alert');

            // Đợi 2 giây sau khi trang đã tải xong
            setTimeout(function() {
                // Hiển thị thông báo khi có session 'msgc'
                if (alertBox.length > 0) {
                    alertBox.removeClass('hide');
                    alertBox.addClass('show');
                    alertBox.addClass('showAlert');

                    // Ẩn thông báo sau 5 giây với hiệu ứng trượt ra
                    setTimeout(function() {
                        alertBox.removeClass('show');
                        alertBox.addClass('hide');
                    }, 3000);
                }
            }, 2000);

            // Đóng thông báo khi nhấn nút đóng
            $('.close-btn').click(function() {
                alertBox.removeClass('show');
                alertBox.addClass('hide');
            });
        });
    </script>
    @endif
@endsection
