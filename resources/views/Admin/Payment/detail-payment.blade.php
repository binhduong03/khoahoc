@extends('admin')   
@section('page-title','Đăng ký học')    
@section('contents')   

<div class="container-fluid">
    <h2 class="mb-4 fw-bold">Thông tin đăng ký học (#123456)</h2>
    
    <div class="row">
        <!-- Order Information Table -->
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header fw-bold border-0">
                    <h5 class="fw-bold">Thông tin người đăng ký</h5>
                </div>
                <div class="card-body p-3">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Tên học viên:</td>
                                <td>{{$payment->fullname}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td>{{$payment->phone}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Thanh toán:</td>
                                <td>{{$payment->payment_method}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body fw-bold border-0">
                    <h5 class="fw-bold">Khóa học</h5>
                </div>
                <div class="card-body p-3">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="fw-bold">Khóa học</th>
                                <th scope="col" class="fw-bold">Đơn giá</th>
                                <th scope="col" class="fw-bold">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total = 0;
                            ?>
                            @foreach($payment_details as $all)
                            <?php
                                $total += $all->price;
                            ?>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="d-inline-block me-2" style="width: 50px; height: 50px; overflow: hidden;">
                                        <img class="img-fluid rounded-circle" src="{{ asset('public/backend/images/courses/'. $all->image) }}" alt="Sản phẩm 1" loading="lazy" style="width: 100%; height: auto;" />
                                    </div>
                                    {{$all->name}}

                                </td>
                                
                                <td class="align-middle">{{number_format($all->price). ' '. 'VNĐ'}}</td>
                                <td class="align-middle">{{number_format($all->price). ' '. 'VNĐ'}}</td>
                            </tr>
                            
                            @endforeach
                            <tr>
                                <td></td>
                                
                                <td class="fw-bold">Tạm tính:</td>
                                <td>{{number_format($total).' '.'VNĐ'}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                
                                <td class="fw-bold">Giảm giá:</td>
                                <td>{{number_format($payment->discount).' '.'VNĐ'}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                
                                <td class="fw-bold">Tổng tiền:</td>
                                <td>{{number_format($payment->amount).' '.'VNĐ'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
