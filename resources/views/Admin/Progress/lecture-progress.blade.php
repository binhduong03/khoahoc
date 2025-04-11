@extends('admin')   
@section('page-title','Tiến độ học')    
@section('contents')       

    <div class="container-fluid">
        
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Bảng</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Tiến độ học</a></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Thông tin người học</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Họ tên:</td>
                                    <td>{{$user->fullname}}</td>
                                </tr>

                                <tr>
                                    <td>Email:</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Thông tin khóa học</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Khóa học:</td>
                                <td>{{$course->name}}</td>
                            </tr>
                            <tr>
                                <td>Mô tả:</td>
                                <td>{{$course->description}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            
                            <h4 class="card-title">Tiến độ học</h4>
                            <a href="{{URL::to('Admin/course-progress/student/'. $course->course_id)}}" class="btn btn-primary mb-2">Quay lại</a>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display " style="width:100%">
                                <thead class="table-info">
                                    <tr>
                                        <th>#</th>
                                        <th>Tên bài giảng</th>
                                        <th>Thanh tiến độ</th>
                                        <th>Tiến độ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lectures as $all )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$all->title}}</td>
                                            <td>
                                                <div class="progress" style="background: rgba(76, 175, 80, .1)">
                                                    <div class="progress-bar bg-success" style="width: {{ $all->user_progress }}%;" role="progressbar"><span class="sr-only">{{ $all->user_progress }}% Complete</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$all->user_progress}} %</td>
                                            
                                            
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên bài giảng</th>
                                        <th>Thanh tiến độ</th>
                                        <th>Tiến độ</th>
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



    