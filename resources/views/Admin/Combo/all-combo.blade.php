@extends('admin')   
@section('page-title', 'Combo khóa học')    
@section('contents')   

    <div class="custom-alert hide">
        <span class="fas fa-check-circle"></span>
        <span class="msg">
            @if(session('msgcb'))
                {{ session('msgcb') }}
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
            <li class="breadcrumb-item"><a href="javascript:void(0)">Combo khóa học</a></li>
        </ol>
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between w-100">
                        <h4 class="card-title">Danh sách combo</h4>
                        <a href="{{route('admin.add-combo')}}" class="btn btn-primary mb-2">
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
                                    <th>Ảnh</th>
                                    <th>Tên combo</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Tình trạng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($combos as $all)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <img class="rounded-circle anhdep" tabindex="0" width="45" style="height: 45px; max-height: 45px" src="{{asset('public/backend/images/combo/'. $all->image) }}" alt="Ảnh khóa học">
                                    </td>
                                    <td>{{$all->name}}</td>
                                    <td class="text-truncate" style="max-width: 50px">{{$all->description}}</td>
                                    
                                    <td>{{number_format($all->price). 'VNĐ'}}</td>
                                    <td>
                                        @if ($all->status === 1)
                                            <span class="badge badge-success">Hoạt động<span class="ms-1 fa fa-check"></span></span>

                                        @else
                                            <span class="badge badge-danger">Ngừng hoạt động<span class="ms-1 fa fa-ban"></span></span>
                                
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{URL::to('Admin/edit-combo/'. $all->combo_id)}}" class="btn btn-warning shadow btn-xs sharp me-1" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#detail-combo{{$all->combo_id}}" title="Xem"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#deleteModal{{$all->combo_id}}" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh</th>
                                    <th>Tên combo</th>
                                    <th>Mô tả</th>
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

@foreach($combos as $all)
<div class="modal fade" id="detail-combo{{$all->combo_id}}" aria-labelledby="#exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xem chi tiết</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">Tên combo</label>
                        <input type="text" class="form-control" value="{{$all->name}}" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Tên combo</label>
                        <input type="text" class="form-control" value="{{number_format($all->price). ' VNĐ'}}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label class="form-label" >Mô tả</label>
                        <textarea rows="5" class="form-control" readonly>{{$all->description}}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label class="form-label">Danh sách khóa học</label>
                        <div class="input-group">
                            <label for="category_name" class="input-group-text mb-0">Khóa học</label>
                            @if($all->comboCourses && $all->comboCourses->count() > 0)
                                <select class="form-select" aria-label="Danh sách khóa học">
                                    <option>Danh sách khóa học</option>
                                    @foreach($all->comboCourses as $comboCourse)
                                        @if($comboCourse->course)
                                            <option value="{{$comboCourse->course->course_id}}">
                                                {{$comboCourse->course->name}} 
                                                - {{number_format($comboCourse->course->price) . ' VNĐ'}}
                                                - Giáo viên: {{$comboCourse->course->user->fullname ?? 'Chưa có giáo viên'}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <p>Không có khóa học nào trong combo này.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        Quay lại
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Xóa combo -->
@foreach($combos as $all)
    <div class="modal fade" id="deleteModal{{$all->combo_id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content text-center">
                <form action="{{route('admin.delete-combo')}}" method="Post">
                    @csrf
                    <input type="hidden" name="combo_id" value="{{$all->combo_id}}">
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



@if (session('msgcb'))
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
