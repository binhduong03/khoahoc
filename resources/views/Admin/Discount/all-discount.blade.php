@extends('admin')   
@section('page-title','Giảm giá')    
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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Giảm giá</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            
                            <h4 class="card-title">Danh sách giảm giá</h4>
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
                                        <th>Mã giảm giá</th>
                                        <th>% Giảm giá</th>
                                        <th>Áp dụng</th>
                                        <th>Tình trạng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_discount as $all)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$all->title}}</td>
                                            <td>{{$all->discount_percentage}}</td>
                                            <td>
                                                @if($all->user_type === 'all')
                                                    <span class="badge bg-info text-white">Tất cả</span>
                                                @elseif($all->user_type === 'new')
                                                    <span class="badge bg-primary text-white">Mới</span>
                                                @elseif($all->user_type === 'old')
                                                    <span class="badge bg-warning text-white">Cũ</span>
                                                @else
                                                    <span class="badge bg-secondary text-white">Không xác định</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($all->status == 1)
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
                                        <th>Mã giảm giá</th>
                                        <th>% Giảm giá</th>
                                        <th>Áp dụng</th>
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



    