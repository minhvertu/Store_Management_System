<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <!-- Import Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom CSS để cải thiện giao diện của hóa đơn */
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            margin-top: 50px;
            max-width: 1200px; /* Tăng kích thước của container */
        }
        .invoice-container {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Tạo bóng mờ */
        }
        .invoice-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 28px; /* Tăng kích thước tiêu đề */
            font-weight: bold;
        }
        .invoice-details {
            font-size: 16px;
            color: #6c757d;
        }
        .invoice-table th, .invoice-table td {
            padding: 15px; /* Tăng padding để bảng trông rộng hơn */
            border: 1px solid #dee2e6;
        }
        .invoice-table th {
            background-color: #84B0CA;
            color: white;
        }
        .image-container {
            width: 100px; /* Tăng kích thước của hình ảnh */
            height: 100px;
            /* overflow: hidden; */
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .total-amount {
            font-size: 22px; /* Tăng kích thước tổng số tiền */
            font-weight: bold;
            color: #28a745; /* Màu xanh lá */
        }
    </style>
</head>
<body>
    <div class="container mb-5 mt-3">
        <div class="invoice-container"  style="text-align: center;">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ $message->embed('storage/images/vertu_logo2.jpg') }}" alt="Logo" style="width: 100px; height: auto;">
                        <p class="invoice-details">Invoice ID: {{ $order->order_code }}</p>
                        <p class="invoice-details">Date: {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="invoice-details">
                            {{-- <strong>Client Info</strong><br> --}}
                            @if($order->client)
                                <strong>Name:</strong> {{ $order->client->name }}<br>
                                <strong>Address:</strong> {{ $order->client->address }}<br>
                                <strong>Email:</strong> {{ $order->client->email }}<br>
                                <strong>Phone:</strong> {{ $order->client->phone_number }}
                            @else
                                <strong>Name:</strong> {{ $order->client_name }}<br>
                                <strong>Address:</strong> {{ $order->address }}<br>
                                <strong>Phone:</strong> {{ $order->phone_number }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="table-responsive" >
                <table class="table table-striped table-borderless invoice-table"   style="margin: 0 auto; text-align: center;">
                    <thead style="background-color:#84B0CA;" class="text-white">
                        <tr>
                            <th>Product Image</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Detail</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->order_product as $order_product)
                            <tr>
                                <td>
                                    <div class="image-container">
                                        {{-- <img src="/storage/{{ $order_product->product->image }}" alt="Product Image"> --}}
                                        <img src="{{ $message->embed('storage/' . $order_product->product->image) }}" alt="Product Image">
                                    </div>
                                </td>
                                <td>{{ $order_product->product->name }}</td>
                                <td >{{ $order_product->amount }}</td>
                                <td>{{ $order->detail }}</td>
                                <td>${{ number_format($order_product->product->sell_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total Amount and Notes -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <p>Thêm ghi chú và thông tin thanh toán ở đây.</p>
                </div>
                <div class="col-md-4">
                    <ul class="list-unstyled">
                        <li class="text-muted"><strong>SubTotal:</strong> ${{ number_format($order->subtotal, 2) }}</li>
                        <li class="text-muted"><strong>Tax (0%):</strong> ${{ number_format($order->tax, 2) }}</li>
                    </ul>
                    <p class="total-amount">
                        <strong>Total Amount:</strong> ${{ number_format($order->price, 2) }}
                    </p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <p><strong>Cảm ơn quý khách đã lựa chọn mua hàng tại cửa hàng của chúng tôi.</strong> Chúng tôi hy vọng sẽ tiếp tục được phục vụ quý khách trong những lần mua hàng tiếp theo.</p>
                    <p>Nếu quý khách cần hỗ trợ thêm, vui lòng liên hệ với chúng tôi qua số điện thoại hoặc email.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
