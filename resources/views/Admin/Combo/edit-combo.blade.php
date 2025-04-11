@extends('admin')
@section('page-title', 'Sửa Combo')
@section('contents')

<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Quản lý Combo</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Sửa Combo</a></li>
        </ol>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Sửa Combo: {{ $combos->name }}</h5>
        </div>

        <div class="card-body">
            <form action="{{URL::to('Admin/update-combo/'. $combos->combo_id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="combo-name" class="form-label">Tên Combo</label>
                    <input type="text" class="form-control" id="combo-name" name="name" value="{{ old('name', $combos->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="combo-description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="combo-description" name="description" rows="4" required>{{ old('description', $combos->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="combo-price" class="form-label">Giá</label>
                    <input type="number" class="form-control" id="combo-price" name="price" value="{{ old('price', $combos->price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="combo-image" class="form-label">Ảnh</label>
                    <div class="input-group mb-3">
                        <div class="form-file ">
                            <input type="file" name="image" class="form-file-input form-control">
                        </div>
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="combo-status" class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="combo-status" name="status" value="1" {{ $combos->status ? 'checked' : '' }}>
                        <label class="form-check-label" for="combo-status">Hoạt động</label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#courseList" aria-expanded="false" aria-controls="courseList">
                                Xem danh sách khóa học
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="courseList">
                        <div class="row">
                            @foreach($combos->comboCourses as $comboCourse)
                                @if($comboCourse->course)
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex align-items-center">
                                            <!-- Hiển thị tên khóa học và số thứ tự -->
                                            <h5 class="mb-0 me-3" style="flex: 1;">{{ $comboCourse->course->name }}</h5>
                                            <div style="max-width: 70px;">
                                                <input type="number" 
                                                       class="form-control form-control-sm" 
                                                       value="{{ $comboCourse->sequence }}" 
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4 mb-3">
                                        <p class="text-muted">Khóa học không tồn tại</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <h5>Thêm Khóa học vào Combo</h5>
                    <div class="row">
                        @foreach($courses as $course)
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <!-- Checkbox chọn khóa học -->
                                    <div class="form-check me-3">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="course_{{ $course->course_id }}" 
                                               name="course_ids[]" 
                                               value="{{ $course->course_id }}">
                                        <label class="form-check-label" for="course_{{ $course->course_id }}">{{ $course->name }}</label>
                                    </div>

                                    
                                    <div style="max-width: 70px;">
                                        <input type="number" 
                                               class="form-control form-control-sm" 
                                               id="order_{{ $course->course_id }}" 
                                               name="orders[{{ $course->course_id }}]" 
                                               min="1" 
                                               value="">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection
