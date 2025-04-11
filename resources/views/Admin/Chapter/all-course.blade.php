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
                                        <th>Giáo viên</th>
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
                                            <td>{{$all->user->fullname}}</td>
                                            <td>
                                                @if ($all->status === 1)
                                                    <span class="badge badge-success">Hoạt động<span class="ms-1 fa fa-check"></span></span>

                                                @else
                                                    <span class="badge badge-danger">Ngừng hoạt động<span class="ms-1 fa fa-ban"></span></span>
                                        
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-arrow-right"></i></a>
                                                    <a href="{{URL::to('Admin/all-chapter/'. $all->course_id)}}" class="btn btn-primary shadow btn-xs sharp me-1"
                                                    title="Xem"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fas fa-arrow-left"></i></a>
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
                                        <th>Giáo viên</th>  
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



    