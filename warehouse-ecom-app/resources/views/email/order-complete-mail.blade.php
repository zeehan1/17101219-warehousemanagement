<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ECOM Warehouse Mail (Order Completed)</title>
</head>
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 100%;
}

.container {
  padding: 2px 16px;
}
</style>
<body>
    <div class="card">
<h2>ECOM Warehouse Mail</h2>
  <div class="container">
    <h2><b>Hello {{ $client_name }}Your order successfully placed</span></b></h2>
    <h4><b>Order ID: <span style="color:blue">{{ $order_id }}</span></b></h4>
    <p>Order Details: <span style="color: blue">{{ $details }}</span></p>
    <p>Payment: <span style="color: blue">{{ $payment }}</span></p>
    <p>Order Type: <span style="color: blue">{{ $order_type }}</span></p>
    <p>Status: <span style="color: blue">{{ $status }}</span></p>
    <hr>
    <h5>Thank you</h5>
  </div>
</div>
</body>
</html>
