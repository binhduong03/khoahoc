@extends('admin')       
@section('page-title','Người dùng')  
@section('contents')   

<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Sửa</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Giáo viên</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="card">
        <div class="card-body">
            <form action="{{URL::to('Admin/update-student/'.$edit_student->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" name="fullname" class="form-control" value="{{ $edit_student->fullname }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="username" class="form-label">Tên người dùng</label>
                        <input type="text" name="username" class="form-control" value="{{ $edit_student->username }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ $edit_student->email }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ $edit_student->phone }}" maxlength="11" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select class="form-control" name="gender" required>
                            <option value="nam" {{ $edit_student->gender == 'nam' ? 'selected' : '' }}>Nam</option>
                            <option value="nữ" {{ $edit_student->gender == 'nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="date_of_birt" class="form-label">Ngày sinh</label>
                        <input type="date" name="date_of_birt" class="form-control" value="{{ $edit_student->date_of_birt }}" required>
                    </div>
                    <div class="col-sm-4">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="{{ $edit_student->address }}" required>
                    </div>
                </div>

                <div class="row mb-3">
					<div class="col-sm-4">
						<label for="end_date" class="form-label">Ảnh</label>
						<div class="input-group mb-3">
	                        <div class="form-file ">
	                            <input type="file" name="avatar" class="form-file-input form-control">
	                        </div>
							<span class="input-group-text">Upload</span>
	                    </div>
	                     <img class="img-thumbnail anhdep images" tabindex="0" width="100px" src="{{asset('public/backend/images/user/'. $edit_student->avatar) }}" alt="">
					</div>

					<div class="col-sm-4">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)">
                    </div>

                    <div class="col-sm-4">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="student" {{ $edit_student->role == 'student' ? 'selected' : '' }}>Giáo viên</option>
                            <option value="student" {{ $edit_student->role == 'student' ? 'selected' : '' }}>Học viên</option>
                            <option value="admin" {{ $edit_student->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-check custom-checkbox mb-3 checkbox-success">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3" {{ $edit_student->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="customCheckBox3">Hoạt động</label>
                        </div>
                    </div>
                </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ URL::to('Admin/all-student') }}" class="btn btn-primary mb-2">Quay lại</a>
                        <button type="submit" class="btn btn-primary mb-2">Sửa</button>
                    </div>    
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection
