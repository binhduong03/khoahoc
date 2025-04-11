@extends('admin')
@section('contents')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="row">
				<div class="col-xl-3 col-sm-6">
					<div class="widget-stat card bg-primary">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="la la-users"></i>
								</span>
								<div class="media-body text-white">
									<p class="mb-1">Tổng học viên</p>
									<h4 class="text-white">{{$totalStudents}}</h4>
									<div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar progress-animated bg-light" style="width: {{$totalStudents}}%"></div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
                </div>
				<div class="col-xl-3 col-sm-6">
					<div class="widget-stat card bg-secondary">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="la la-graduation-cap"></i>
								</span>
								<div class="media-body text-white">
									<p class="mb-1">Tổng khóa học</p>
									<h4 class="text-white">{{$totalCourse}}</h4>
									<div class="progress mb-2 bg-primary">
                                        <div class="progress-bar progress-animated bg-light" style="width: {{$totalCourse}}%"></div>
                                    </div>
									
								</div>
							</div>
						</div>
					</div>
                </div>
				<div class="col-xl-3 col-sm-6">
					<div class="widget-stat card bg-primary">
						<div class="card-body  p-4">
							<div class="media">
								<span class="me-3">
									<i class="la la-users"></i>
								</span>
								<div class="media-body text-white">
									<p class="mb-1">Tổng giáo viên</p>
									<h4 class="text-white">{{$totalTeachers}}</h4>
									<div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar progress-animated bg-light" style="width: {{$totalTeachers}}%"></div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
                </div>
				<div class="col-xl-3 col-sm-6">
					<div class="widget-stat card bg-danger ">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="la la-dollar"></i>
								</span>
								<div class="media-body text-white">
									<p class="mb-1">Thu nhập</p>
									<h4 class="text-white">{{number_format($totalIncome)}}</h4>
									<div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar progress-animated bg-light" style="width: {{$totalIncome}}%"></div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
	<div class="row">
	   	<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
	   		<div class="card">
			    <div class="card-header">
			        <h4 class="card-title">Thống Kê Khóa Học</h4>
			    </div>
			    <div class="card-body">
			        <div class="table-responsive courseStatisticsTable">
			            <table class="table verticle-middle table-responsive-md">
			                <thead>
			                    <tr>
			                        <th scope="col">STT</th>
			                        <th scope="col">Tên Khóa Học</th>
			                        <th scope="col">Giá</th>
			                        <th scope="col">Số Học Viên Đăng Ký</th>
			                        <th scope="col">Tổng tiền</th>
			                    </tr>
			                </thead>
			                <tbody>
			                    @foreach($courseStatistics as $course)
			                        <tr>
			                            <td>{{ $loop->iteration }}</td>
			                            <td>{{ $course->name }}</td>
			                            <td>{{number_format($course->price)}} VNĐ</td>
			                            <td>{{ $course->total_registrations }}</td>
			                            <td>{{ number_format($course->total_amount, 0, ',', '.') }} VNĐ</td>
			                        </tr>
			                    @endforeach
			                </tbody>
			            </table>
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>


@endsection