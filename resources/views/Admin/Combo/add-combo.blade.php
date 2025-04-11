@extends('admin')     
@section('page-title','Combo khóa học')  
@section('contents')   

<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Combo</a></li>
        </ol>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5>Thêm mới Combo Khóa Học</h5>
        </div>
        
        <div class="card-body">
            <form action="{{route('admin.save-combo')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="combo-name" class="form-label">Tên combo</label>
                    <input type="text" class="form-control" id="combo-name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="combo-description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="combo-description" name="description" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="combo-price" class="form-label">Giá</label>
                    <input type="number" class="form-control" id="combo-price" name="price" readonly>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <label for="image" class="form-label">Ảnh</label>
                        <div class="input-group mb-3">
                            <div class="form-file">
                                <input type="file" name="image" class="form-file-input form-control" required>
                            </div>
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-check custom-checkbox mb-3 checkbox-success">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="customCheckBox3">
                            <label class="form-check-label" for="customCheckBox3">Hoạt động</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3"> 
				    
				    <button class="btn btn-outline-primary w-10" type="button" data-bs-toggle="collapse" data-bs-target="#courseDropdown" aria-expanded="false" aria-controls="courseDropdown">
					   Chọn khóa học  <i class="fas fa-chevron-down me-2"></i>
					</button>

				    <div class="collapse" id="courseDropdown">
				        <div class="row mt-2">
				            @foreach($courses as $course)
				                <div class="col-md-4 mb-3">
				                    <div class="d-flex align-items-center">
				                        <h5 class="mb-0 me-3" style="flex: 1;">{{ $course->name }}</h5>
				                        
				                        <div class="form-check me-3">
				                            <input class="form-check-input" type="checkbox" value="{{ $course->course_id }}" name="course_ids[]" id="course_{{ $course->course_id }}">
				                        </div>

				                        <div style="max-width: 70px;">
				                            <input type="number" class="form-control form-control-sm" id="order_{{ $course->course_id }}" name="orders[{{ $course->course_id }}]" min="1" value="1">
				                        </div>
				                    </div>
				                </div>
				            @endforeach
				        </div>
				    </div>
				</div>
                <button type="submit" class="btn btn-primary">Lưu combo</button>
            </form>
        </div>
    </div>
</div>

@endsection
