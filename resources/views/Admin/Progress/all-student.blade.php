@extends('admin')   
@section('page-title','Người dùng')    
@section('contents')       

    <div class="container-fluid">
        
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Bảng</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Người dùng</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            
                            <h4 class="card-title">Học viên</h4>
                            <a href="{{URL::to('Admin/all-course-progress')}}" class="btn btn-primary mb-2">Quay lại</a>
                            
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
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th>Tình trạng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_student as $all )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> 
                                                <img class="rounded-circle anhdep image" tabindex="0" width="45" src="{{asset('public/Backend/images/user/'. $all->avatar) }}" alt="">
                                            </td>
                                            <td>{{$all->fullname}}</td>
                                            <td>{{$all->email}}</td>
                                            <td>{{$all->role}}</td>
                                            <td>
                                                @if ($all->status === 1)
                                                    <span class="badge badge-success">Hoạt động<span class="ms-1 fa fa-check"></span></span>

                                                @else
                                                    <span class="badge badge-danger">Ngừng hoạt động<span class="ms-1 fa fa-ban"></span></span>
                                        
                                                @endif
                                            </td>
                                            <td>
                                                
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-arrow-right"></i></a>
                                                    <button type="button" class="btn btn-success light sharp" data-bs-toggle="dropdown">
                                                        <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{URL::to('Admin/lecture-progress/'. $course->course_id. '/'. $all->user_id)}}">Bài giảng</a>
                                                        <a class="dropdown-item" href="{{URL::to('Admin/exercise-progress/'. $course->course_id. '/'. $all->user_id)}}">Bài tập</a>
                                                    </div>
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
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
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
        
@endsection



    