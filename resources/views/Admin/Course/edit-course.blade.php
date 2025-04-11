
@extends('admin')     
@section('page-title','Khóa học')  
@section('contents')   

<div class="container-fluid">
	<div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Sửa</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Khóa học</a></li>
            </ol>
        </div>
        <!-- row -->
	<div class="card">
		<div class="card-body">
		
			<form action="{{URL::to('Admin/update-course/'.$edit_courses->course_id)}}" method="Post" enctype="multipart/form-data">
				@csrf
			<div class="row mb-3">
				<div class="col-sm-6">
					<label for="name" class="form-label">Khóa học</label>
					<input type="text" name="name" class="form-control" value="{{$edit_courses->name}}"required>
				</div>
				<div class="col-sm-6">
					<label for="price" class="form-label">Giá</label>
					<input type="text" name="price" class="form-control" value="{{number_format($edit_courses->price).' VNĐ'}}">
				</div>
				

			</div>

			<div class="row mb-3">
				<div class="col-sm-12">
					<label for="category_name" class="form-label">Chọn giáo viên</label>
					<div class="input-group mb-3">
						<label for="category_name" class="input-group-text mb-0">Giáo viên</label>
			            <select class="default-select  form-control wide" id="user_id" name="user_id" required>
			               	@foreach($teachers as $gv)
			                    <option value="{{$gv->user_id}}" 
			                    	{{ $gv->user_id == $edit_courses->user_id ? 'selected' : '' }}>
			                    	{{$gv->fullname}}
			                    </option>
			                @endforeach
			            </select>
		            </div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-sm-12">
					<label for="description" class="form-label">Mô tả</label>
					<textarea rows="5" name="description" class="form-control">{{$edit_courses->description}}</textarea>
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-sm-4">
					<label for="end_date" class="form-label">Ảnh</label>
					<div class="input-group mb-3">
                        <div class="form-file ">
                            <input type="file" name="image" class="form-file-input form-control">
                        </div>
						<span class="input-group-text">Tải lên</span>
                    </div>
                     <img class="img-thumbnail anhdep images" tabindex="0" width="100px" src="{{asset('public/backend/images/courses/'. $edit_courses->image) }}" alt="">
				</div>
			</div>

			
			<div class="row mb-3">
				<div class="col-sm-12">
					<div class="form-check custom-checkbox mb-3 checkbox-success">
						<input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3" {{  $edit_courses->status ? 'checked' : '' }}>
            			<label class="form-check-label" for="customCheckBox3">Hoạt động</label>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-sm-12">
					<div class="d-flex justify-content-between">
						<a href="{{URL::to('Admin/all-course')}}" class="btn btn-secondary">Thoát</a>		
						<button type="submit" class="btn btn-danger mb-2">Lưu</button>	
					</div>
				</div>
			</div>
		</div>
		</form>
		
	</div>
</div>


@endsection