@extends('welcome')
@section('content')
   <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Thanh toán</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Trang</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Giỏ hàng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Form Thông tin học viên -->
            <div class="col-md-6">
                <h5>Thông tin học viên</h5>
                <div class="p-4 bg-light">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name" value="{{session('fullName')}}" readonly>
                        </div>
                    
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{session('Email')}}" readonly>
                        </div>
                    </form>
                </div>
            </div>


            <div class="col-md-6">
                <div class="p-0">
                    <h5>Danh sách khóa học</h5>
                    
                    @foreach($cartItems as $item)
                    <!-- Vùng thông tin khóa học -->
                    <div class="d-flex mb-3 p-3 bg-light rounded justify-content-between align-items-center">
                        @if($item->name)
                        <div class="d-flex align-items-center">
                            <img src="{{asset('public/backend/images/courses/'. $item->image)}}" alt="course-image" style="max-width: 60px;" class="me-3 img-thumbnail">
                            <div>
                                <p class="mb-0">{{$item->name}}</p>
                                <p class="text-muted mb-0">{{number_format($item->price)}} VND</p>
                            </div>
                        </div>
                        <form action="{{URL::to('delete-cart/'. $item->cart_id) }}" method="post"> 
                            @csrf 
                            <button type="submit" class="btn btn-danger btn-sm ms-2" title="Xóa khỏi giỏ hàng">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                        @endif
                        @if($item->combo_name)
                        <div class="d-flex align-items-center">
                            <img src="{{asset('public/backend/images/combo/'.$item->combo_image)}}" alt="course-image" style="max-width: 60px;" class="me-3 img-thumbnail">
                            <div>
                                <p class="mb-0">{{$item->combo_name}}</p>
                                <p class="text-muted mb-0">{{number_format($item->combo_price)}} VND</p>
                            </div>
                        </div>
                        <form action="{{URL::to('delete-cart/'. $item->cart_id) }}" method="post"> 
                            @csrf 
                            <button type="submit" class="btn btn-danger btn-sm ms-2" title="Xóa khỏi giỏ hàng">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                        @endif
                        
                    </div>
                    @endforeach
                    <div class="p-3 mb-3 bg-light rounded">
                        <!-- Nút để hiển thị dropdown -->
                        <button class="btn btn-primary w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#couponForm" aria-expanded="false" aria-controls="couponForm">
                            Nhập phiếu giảm giá
                        </button>

                        <!-- Phần nhập phiếu giảm giá -->
                        <div class="collapse" id="couponForm">
                            <form action="{{route('save-discount')}}" method="post">
                                @csrf
                                <input type="text" class="form-control mb-2" name="title" placeholder="Nhập phiếu giảm giá">
                                <button type="submit" class="btn btn-primary w-100 mb-2" id="applyCoupon">Áp dụng</button>
                            </form>
                            
                            <div class="text-center">
                                <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#discountModal" id="getCoupon">
                                    <i class="fas fa-tag"></i> Lấy phiếu giảm giá
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Vùng hiển thị đơn giá và tổng tiền -->
                    <form action="{{route('luu-thanh-toan')}}" method="post">
                    @csrf
                    <div class="p-3 bg-light rounded">
                        <div class="d-flex justify-content-between">
                            <span>Đơn giá</span>
                            <span>{{number_format($sub_total)}} VND</span>
                            <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                        </div>
                        @if(session('totalDiscount', 0) > 0)
                        <div class="d-flex justify-content-between">
                            <span>Giảm giá</span>
                            <span>{{ number_format(session('totalDiscount')) }} VND</span>
                            <input type="hidden" name="total_discount" value="{{ session('totalDiscount') }}">
                        </div>
                        @endif
                        <hr class="my-2" style="border-top: 1px dashed #007bff;"> 
                        @if(session('finalPrice', 0) > 0)
                            <div class="d-flex justify-content-between">
                                <span>Tổng tiền</span>
                                <span>{{ number_format(session('finalPrice')) }} VND</span>
                                <input type="hidden" name="final_price" value="{{ session('finalPrice') }}">
                            </div>
                        @else
                            <div class="d-flex justify-content-between">
                                <span>Tổng tiền</span>
                                <span>{{ number_format($sub_total) }} VND</span>
                                <input type="hidden" name="final_price" value="{{ $sub_total }}">
                            </div>
                        @endif
                    </div>

                    <div class="mt-3"> 
                        <button type="submit" class="btn btn-primary w-100" id="checkout">Thanh toán</button> 
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountModalLabel">Danh sách phiếu giảm giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    @foreach ($all_discount as $discount)
                        @if ($discount->user_type == 'all' || $discount->user_type == $discount_status)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-ticket-alt me-2" style="color: #007bff;"></i>
                                    <span>{{ $discount->title }}</span>
                                </div>
                                <span class="badge bg-success rounded-pill">{{ $discount->discount_percentage }}%</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>



@endsection
