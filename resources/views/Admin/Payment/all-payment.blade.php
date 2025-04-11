@extends('admin')   
@section('page-title','Đăng ký học')    
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

    <div class="custom-alert-red hide">
        <span class="fas fa-times-circle"></span>
        <span class="msgr">
            @if(session('error'))
                {{ session('error') }}
            @endif
        </span>
        <div class="close-btnr">
            <span class="fas fa-times"></span>
        </div>
    </div>

    <div class="container-fluid">
        
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Bảng</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Đăng ký học</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            
                            <h4 class="card-title">Danh sách đăng ký học</h4>
                            
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display " style="width:100%">
                                <thead class="table-info">
                                    <tr>
                                        <th>#</th>
                                        <th>Họ tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_payment as $all)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$all->fullname}}</td>
                                            <td>{{$all->phone}}</td>
                                            
                                            <td>
                                                <form action="{{route('admin.update-payment-status')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="payment_id" value="{{$all->payment_id}}">
                                                    <select name="payment_status" class="form-select" onchange="this.form.submit()">
                                                        <option value="1" {{ $all->payment_status === 1 ? 'selected' : '' }}>Thanh toán</option>
                                                        <option value="0" {{ $all->payment_status === 0 ? 'selected' : '' }}>Chưa thanh toán</option>
                                                    </select>
                                                </form>
                                            </td>

                                            <td>{{number_format($all->amount)}} VNĐ</td>
                                            <td>
                                                <div class="d-flex">
                                                   <a href="#" class="btn btn-warning shadow btn-xs sharp me-1"><i
                                                class="fas fa-hand-point-right"></i></a>
                                                    <a href="{{URL::to('Admin/detail-payment/'. $all->payment_id)}}" class="btn btn-primary shadow btn-xs sharp me-1" title="Xem"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                                class="fas fa-hand-point-left"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
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

    @if (session('error'))
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
        $(window).on('load', function() {
            $('#preloader').fadeOut(500);
            var alertBox = $('.custom-alert-red');

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
            $('.close-btnr').click(function() {
                alertBox.removeClass('show');
                alertBox.addClass('hide');
            });
        });
    </script>
    @endif


@endsection



    