@extends('admin')
@section('page-title', 'Bài tập')
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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Bài tập</a></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">  
                            <h4 class="card-title">Danh sách bài tập</h4>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary mb-2">
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
                                        <th>Tên bài giảng</th>
                                        <th>Tên bài tập</th>
                                        <th>Tài liệu</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_exercise as $all)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $all->course_name }}</td>
                                            <td>{{ $all->l_title }}</td>
                                            <td>{{ $all->title }}</td>
                                            <td>{{ $all->file_path }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Sửa" data-bs-toggle="modal" data-bs-target="#editModal{{$all->exercises_id}}"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#viewModal{{$all->exercises_id}}"
                                                    title="Xem"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#deleteModal{{$all->exercises_id}}" title="Xóa"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Khóa học</th>
                                        <th>Tên bài giảng</th>
                                        <th>Tên bài tập</th>
                                        <th>Tài liệu</th>
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

    <div class="modal fade" id="addModal" aria-labelledby="addLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Thêm bài tập</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.save-exercise')}}" method="POST" enctype="multipart/form-data">

                        @csrf  

                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="lecture_id" class="form-label">Bài giảng</label>
                            <div class="input-group mb-3">
                                <label for="category_name" class="input-group-text mb-0">Bài giảng</label>
                                <select class="form-select" id="lecture_id" name="lecture_id" required>
                                    @foreach($lectures as $lecture) 
                                        <option value="{{ $lecture->lecture_id }}">{{ $lecture->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File bài tập</label>
                            <div class="input-group mb-3">
                                <div class="form-file ">
                                    <input type="file" name="file_path" class="form-file-input form-control">
                                </div>
                                <span class="input-group-text">Tải lên</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Hạn nộp</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Hoạt động</label>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Quay lại
                    </button>     
                    <button type="submit" class="btn btn-danger mb-2">Lưu</button>
                </div>
                    </form>
            </div>
        </div>
    </div>


    @foreach($all_exercise as $all)
    <div class="modal fade" id="editModal{{$all->exercises_id}}" aria-labelledby="#editLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Sửa bài tập</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.update-exercise')}}" method="POST" enctype="multipart/form-data">

                        @csrf    
                        <input type="hidden" name="exercise_id" value="{{$all->exercises_id}}">        
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $all->title }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $all->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="lecture_id" class="form-label">Bài giảng</label>
                            <div class="input-group mb-3">
                                <label for="category_name" class="input-group-text mb-0">Bài giảng</label>
                                <select class="form-select" id="lecture_id" name="lecture_id" required>
                                    @foreach($lectures as $lecture) 
                                        <option value="{{ $lecture->lecture_id }}" 
                                            {{ $all->lecture_id == $lecture->lecture_id ? 'selected' : '' }}>
                                            {{ $lecture->title }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
 
                        <div class="mb-3">
                            <label for="file" class="form-label">File bài tập</label>
                            <div class="input-group mb-3">
                                <div class="form-file ">
                                    <input type="file" name="file_path" class="form-file-input form-control">
                                </div>
                                <span class="input-group-text">Tải lên</span>
                            </div>
                            @if($all->file_path)
                                <p>File hiện tại: <a href="{{ asset('public/backend/images/exercise/' . $all->file_path) }}" target="_blank">Xem file</a></p>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Hạn nộp</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $all->due_date }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ $all->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Hoạt động</label>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Quay lại
                    </button>     
                    <button type="submit" class="btn btn-danger mb-2">Lưu</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($all_exercise as $all)
    <div class="modal fade" id="viewModal{{$all->exercises_id}}" aria-labelledby="#viewLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLabel">Xem bài tập</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <p class="form-control" id="title">{{ $all->title }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <p class="form-control" id="description">{{ $all->description }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="lecture_id" class="form-label">Bài giảng</label>
                        <p class="form-control" id="lecture_id">
                            @foreach($lectures as $lecture)
                                @if($all->lecture_id == $lecture->lecture_id)
                                    {{ $lecture->title }}
                                @endif
                            @endforeach
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File bài tập</label>
                        @if($all->file_path)
                            <p><a href="{{ asset('public/backend/images/exercise/' . $all->file_path) }}" target="_blank">Xem file</a></p>
                        @else
                            <p>Không có file đính kèm</p>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Hạn nộp</label>
                        <p class="form-control" id="due_date">{{ $all->due_date }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <p class="form-control" id="status">{{ $all->status ? 'Hoạt động' : 'Không hoạt động' }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach


    @foreach($all_exercise as $all)
    <div class="modal fade" id="deleteModal{{$all->exercises_id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content text-center">
                <form action="{{route('admin.delete-exercise')}}" method="Post">
                    @csrf
                    <input type="hidden" name="exercise_id" value="{{$all->exercises_id}}">
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
