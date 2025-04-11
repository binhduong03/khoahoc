@extends('admin')     
@section('page-title','Người dùng')    
@section('contents')   

    <div class="custom-alert hide">
        <span class="fas fa-check-circle"></span>
        <span class="msg">
            @if(session('msgu'))
                {{ session('msgu') }}
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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Giáo viên</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            
                            <h4 class="card-title">Giáo viên</h4>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-teacher" class="btn btn-primary mb-2"><i class="fas fa-plus"></i>Thêm mới</a>
                            
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display " style="width:100%">
                                <thead class="table-info">
                                    <tr>
                                        <th>#</th>
                                        <th>Ảnh</th>
                                        <th>Họ tên</th>
                                        <th>Tên TK</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
                                        <th>Tình trạng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_teacher as $all )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> 
                                                <img class="rounded-circle img-thumbnai anhdep" tabindex="0" width="55" style="max-height: 55px;" src="{{asset('public/backend/images/user/'. $all->avatar) }}" alt="">
                                            </td>
                                            <td>{{$all->fullname}}</td>
                                            <td>{{$all->username}}</td>
                                            <td>{{$all->phone}}</td>
                                            <td>{{$all->email}}</td>
                                            
                                            <td>
                                                @if ($all->status === 1)
                                                    <span class="badge badge-success">Hoạt động<span class="ms-1 fa fa-check"></span></span>
                                                @else
                                                    <span class="badge badge-danger">Ngừng hoạt động<span class="ms-1 fa fa-ban"></span>
                                        
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{URL::to('Admin/edit-teacher/'. $all->user_id)}}" class="btn btn-warning shadow btn-xs sharp me-1" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#detail-teacher{{$all->user_id}}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-eye"></i></a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#delete-teacher{{$all->user_id}}" class="btn btn-danger shadow btn-xs sharp" title="Xóa"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Ảnh</th>
                                        <th>Họ tên</th>
                                        <th>Tên TK</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
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

   <!-- Thêm người dùng -->
    <div class="modal fade" id="add-teacher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{route('admin.save-teacher')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm giáo viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="fullname" class="form-label">Họ tên</label>
                                <input class="form-control" type="text" name="fullname" placeholder="Nhập họ tên" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="username" class="form-label">Tên người dùng</label>
                                <input class="form-control" type="text" name="username" placeholder="Nhập tên người dùng" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Nhập email" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input class="form-control" type="text" name="phone" placeholder="Nhập số điện thoại"  maxlength="11" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input class="form-control" type="text" name="address" placeholder="Nhập địa chỉ">
                            </div>
                            <div class="col-sm-4">
                                <label for="gender" class="form-label">Giới tính</label>
                                <select class="form-control" name="gender" required>
                                    <option value="nam">Chọn giới tính</option>
                                    <option value="nam">Nam</option>
                                    <option value="nữ">Nữ</option>

                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="date_of_birth" class="form-label">Ngày sinh</label>
                                <input class="form-control" type="date" name="date_of_birt" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="image" class="form-label">Ảnh</label>
                                <div class="input-group mb-3">
                                    <div class="form-file">
                                        <input type="file" name="image" class="form-file-input form-control">
                                    </div>
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input type="checkbox" name="status" value="1" class="form-check-input" id="status">
                                    <label class="form-check-label" for="status">Hoạt động</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Xem chi tiết -->
    @foreach($all_teacher as $all)
        <div class="modal fade" id="detail-teacher{{$all->user_id}}" aria-labelledby="exampleModalLabbel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xem chi tiết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Họ tên</label>
                                <input class="form-control" type="text" name="fullname" value="{{$all->fullname}}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Tên người dùng</label>
                                <input class="form-control" type="text" name="username" value="{{$all->username}}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="text" name="email" value="{{$all->email}}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control" type="text" name="phone" value="{{$all->phone}}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label">Địa chỉ</label>
                                <input class="form-control" type="text" name="address" value="{{$all->address}}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Giới tính</label>
                                <input class="form-control" type="text" name="gender" value="{{$all->gender}}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Ngày sinh</label>
                                <input class="form-control" type="text" name="date_of_birt" value="{{$all->date_of_birt}}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="image" class="form-label">Ảnh</label>
                                <div class="input-group mb-3">
                                    <img src="{{asset('public/backend/images/user/'.$all->avatar)}}" alt="Course Image" class="img-thumbnail anhdep image" width="100" height="100">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                    </div>
                </div>
            </div>    
        </div>
    @endforeach

    <!-- Xóa người dùng -->
    @foreach($all_teacher as $all)
        <div class="modal fade" id="delete-teacher{{$all->user_id}}" aria-labelldby="exampleModalLabbel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 400px;">
                <div class="modal-content text-center">
                    <form action="{{route('admin.delete-teacher')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$all->user_id}}">
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

    @if (session('msgu'))
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



    