@extends('admin')   
@section('page-title','Khóa học')    
@section('contents')    
    
    <div class="custom-alert hide">
        <span class="fas fa-check-circle"></span>
        <span class="msg">
            @if(session('msgc'))
                {{ session('msgc') }}
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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Khóa học</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            
                            <h4 class="card-title">Danh sách khóa học</h4>
                            <a data-bs-toggle="modal" data-bs-target="#add-course" class="btn btn-primary mb-2">
                                <i class="fas fa-plus"></i> Thêm mới
                            </a>

                            
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display " style="width:100%">
                                <thead class="table-info">
                                    <tr>
                                        <th>#</th>
                                        <th>Ảnh</th>
                                        <th>Tên khóa</th>
                                        <th>Mô tả</th>
                                        <th>Giáo viên</th>
                                        <th>Giá</th>
                                        <th>Tình trạng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_courses as $all)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> 
                                                <img class="rounded-circle anhdep" tabindex="0" width="45" style="height: 45px; max-height: 45px" src="{{asset('public/backend/images/courses/'. $all->image) }}" alt="">
                                            </td>
                                            <td>{{$all->name}}</td>
                                            <td class="text-truncate" style="max-width: 50px">{{$all->description}}</td>
                                            <td>{{$all->user->fullname}}</td>
                                            <td>{{number_format($all->price).' VNĐ'}}</td>
                                            <td>
                                                @if ($all->status === 1)
                                                    <span class="badge badge-success">Hoạt động<span class="ms-1 fa fa-check"></span></span>

                                                @else
                                                    <span class="badge badge-danger">Ngừng hoạt động<span class="ms-1 fa fa-ban"></span></span>
                                        
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{URL::to('Admin/edit-course/'. $all->course_id)}}" class="btn btn-warning shadow btn-xs sharp me-1" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#detail-course{{$all->course_id}}"
                                                    title="Xem"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#deleteModal{{$all->course_id}}" title="Xóa"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Ảnh</th>
                                        <th>Tên khóa</th>
                                        <th>Mô tả</th>
                                        <th>Giáo viên</th>
                                        <th>Giá</th>
                                        <th>Tình trạng</th>
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

    <div class="modal fade" id="add-course" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm khóa học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.save-course')}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" >Khóa học</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="category_name" class="form-label">Chọn giáo viên</label>
                                <div class="input-group mb-3">
                                    <label for="category_name" class="input-group-text mb-0">Giáo viên</label>
                                    <select class="default-select  form-control wide" id="user_id" name="user_id" required>
                                        <option value="">Chọn giáo viên</option>
                                        @foreach($teachers as $gv)
                                            <option value="{{$gv->user_id}}">
                                                {{$gv->fullname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" >Giá</label>
                                <input type="number" name="price" class="form-control" min="0"  required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" >Thời gian học</label>
                                <input type="number" name="duration" class="form-control" min="0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label class="form-label" >Mô tả</label>
                                <textarea rows="5" name="description" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="image" class="form-label">Ảnh</label>
                                <div class="input-group mb-3">
                                    <div class="form-file">
                                        <input type="file" name="image" class="form-file-input form-control" required>
                                    </div>
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="form-check custom-checkbox mb-3 checkbox-success">
                                    <input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3">
                                    <label class="form-check-label" for="customCheckBox3">Hoạt động</label>
                                </div>
                            </div>
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

    <!-- Xem chi tiết khóa học  -->

    @foreach($all_courses as $all)
    <div class="modal fade" id="detail-course{{$all->course_id}}" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Xem chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Khóa học</label>
                            <input type="text" name="name" class="form-control" value="{{$all->name}}" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label for="category_name" class="form-label">Giáo viên</label>
                            <div class="input-group mb-3">
                                <label for="category_name" class="input-group-text mb-0">Giáo viên</label>
                                <input type="text" class="form-control" value="{{$all->user->fullname}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Giá</label>
                            <input type="number" name="price" class="form-control" value="{{$all->price}}" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Thời gian học</label>
                            <input type="number" name="duration" class="form-control" value="{{$all->duration}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label">Mô tả</label>
                            <textarea rows="5" name="description" class="form-control" readonly>{{$all->description}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="image" class="form-label">Ảnh</label>
                            <div class="input-group mb-3">
                                <img src="{{asset('public/backend/images/courses/'.$all->image)}}" alt="Course Image" class="img-thumbnail" width="100" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check custom-checkbox mb-3 checkbox-success">
                                <input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3" @if($all->status == 1) checked @endif disabled>
                                <label class="form-check-label" for="customCheckBox3">Hoạt động</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <!-- Xóa khóa học  -->
    @foreach($all_courses as $all)
    <div class="modal fade" id="deleteModal{{$all->course_id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content text-center">
                <form action="{{route('admin.delete-course')}}" method="Post">
                    @csrf
                    <input type="hidden" name="course_id" value="{{$all->course_id}}">
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


    

    
    @if (session('msgc'))
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



    