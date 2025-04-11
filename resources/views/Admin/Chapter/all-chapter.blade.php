@extends('admin')
@section('page-title', 'Chương')
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

    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Bảng</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">chương</a></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">  
                            <h4 class="card-title">Danh sách chương</h4>
                            <a href="{{URL::to('Admin/add-lecture/'.$courseID->course_id)}}" class="btn btn-primary mb-2">
                                <i class="fas fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display" style="width:100%">
                                <thead class="table-info">
                                    <tr>
                                        <th>#</th>
                                        <th>Khóa học</th>
                                        <th>Tên chương</th>
                                        <th>Nội dung</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_chapter as $all)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $all->name }}</td>
                                            <td>{{ $all->title }}</td>
                                            <td>{{ $all->content }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit-chapter{{$all->chapter_id}}" class="btn btn-warning shadow btn-xs sharp me-1" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#detail-chapter{{$all->chapter_id}}"
                                                    title="Xem"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#deleteModal{{$all->chapter_id}}" title="Xóa"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Khóa học</th>
                                        <th>Tên chương</th>
                                        <th>Nội dung</th>
                                        <th>Hành động</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($all_chapter as $all)
    <div class="modal fade" id="detail-chapter{{$all->chapter_id}}" tabindex="-1" aria-labelledby="viewLectureLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLectureLabel">Chi tiết chương</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" value="{{ $all->title }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="content" rows="4" readonly>{{ $all->content }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($all_chapter as $all)
    <div class="modal fade" id="edit-chapter{{$all->chapter_id}}" tabindex="-1" aria-labelledby="editChapterLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('admin.update-chapter') }}" method="post">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $all->chapter_id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editChapterLabel">Sửa chương</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="title" value="{{ $all->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" name="content" rows="4" required>{{ $all->content }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach


    @foreach($all_chapter as $all)
    <div class="modal fade" id="deleteModal{{$all->chapter_id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content text-center">
                <form action="{{route('admin.delete-chapter')}}" method="Post">
                    @csrf
                    <input type="hidden" name="lecture_id" value="{{$all->chapter_id}}">
                    <div class="modal-body text-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto" 
                             style="width: 100px; height: 100px; border: 3px solid #ffc107; background-color: white;">
                            <i class="fas fa-exclamation fa-3x" style="color: #ffc107;"></i>
                        </div>
                        <h3 class="mt-3"><strong>Bạn có chắc chắn muốn xóa không?</strong></h3>
                        <h6>Bạn sẽ không thể khôi phục được bản ghi này!!</h6>
                    </div>

                    <div class="mb-3 justify-content-center">
                        <button type="submit" class="btn btn-danger">Chắc chắn</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
   
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
