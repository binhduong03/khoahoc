@extends('welcome')
@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <h3 class="font-weight-bold">Thông tin học viên</h3>
            <div class="card p-4 rounded bg-light mb-4">
                <div class="mb-2">
                    <strong>Họ tên:</strong> {{session('fullName')}}
                </div>
                <div class="mb-2">
                    <strong>Số điện thoại:</strong> {{session('SDT')}}
                </div>
                <div class="mb-2">
                    <strong>Email:</strong> {{session('Email')}}
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <h3 class="font-weight-bold">Phương thức thanh toán</h3>
            <div class="card p-4 rounded bg-light mb-4">
                <h4 class="font-weight-bold">Chuyển khoản ngân hàng</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Tên ngân hàng:</th>
                            <td>MBBANK</td>
                        </tr>
                        <tr>
                            <th scope="row">Chủ tài khoản:</th>
                            <td>LE PHAN BINH DUONG</td>
                        </tr>
                        <tr>
                            <th scope="row">Số tài khoản:</th>
                            <td>0888946857</td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="font-weight-bold">Thanh toán qua ví MoMo</h4>
                <div class="mb-4">
                    <img src="https://via.placeholder.com/200" alt="QR Code" class="img-fluid rounded mb-3">
                    <p>Nội dung thanh toán: <strong>0586312632_ORD843015267</strong></p>
                </div>
                <button class="btn btn-primary w-100">Hoàn tất thanh toán</button>
            </div>
        </div>

        <div class="col-lg-4">
            <h3 class="font-weight-bold">Danh sách khóa học</h3>
            <div class="card p-4 rounded bg-light" >
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Lập Trình Python Từ Cơ Bản Tới Nâng Cao Qua 120 Video Và 300 Bài Tập Thực Hành (Update 2024)</span>
                    <span class="font-weight-bold">999,000 VND</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Đơn giá</span>
                    <span>999,000 VND</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tổng tiền</span>
                    <span>999,000 VND</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
