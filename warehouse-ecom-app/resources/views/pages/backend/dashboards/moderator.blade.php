@extends('layouts.backend.backend-master')
@section('content')
 <main id="main" class="main">

    <div class="pagetitle">
      <h1>{{ $user_status }} Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">{{ request()->path() }}</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
               <h5 class="card-title">Register Stock Order</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('register.order') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Client Name</label>
                  <input type="text" class="form-control" id="client_name" name="client_name">
                  @error('client_name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email">
                   @error('email')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="contact" class="form-label">Contact</label>
                  <input type="number" class="form-control" id="contact" name="contact">
                   @error('contact')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" id="address" name="address">
                   @error('address')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
            <div class="col-md-6">
                  <label for="selected_product">Product</label>
                    <select class="form-select" id="selected_product" name="selected_product">
                    <option value="">Choose product</option>
                    @foreach($fetch_product as $product)
                        <option value="{{ $product->sku_id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                 @error('selected_product')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                 <div class="col-md-6">
                  <label for="address" class="form-label">Quantity</label>
                  <input type="text" class="form-control" id="product_quantity" name="product_quantity">
                   @error('address')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="payment">Payment</label>
                    <select class="form-select" id="payment" name="payment">
                    <option value="">Choose product</option>
                <option value="Cash On Delivery">Cash On Delivery</option>
                <option value="Online payment">Online payment</option>
                </select>
                 @error('payment')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success rounded-pill">Submit</button>
                  <button type="reset" class="btn btn-secondary rounded-pill">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register Pre Order</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('register.preOrder') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Client Name</label>
                  <input type="text" class="form-control" id="client_name_order" name="client_name_order">
                  @error('client_name_order')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email_order" name="email_order">
                   @error('email_order')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="contact" class="form-label">Contact</label>
                  <input type="number" class="form-control" id="contact_order" name="contact_order">
                   @error('contact')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" id="address_order" name="address_order">
                   @error('address')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
            <div class="col-md-12">
                   <label for="inputAddress" class="form-label">Product Specification</label>
                             <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" rows="3" id="product_specification_order" name="product_specification_order"></textarea>
                        @error('product_specification_order')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                <div class="col-md-12">
                  <label for="payment">Payment</label>
                    <select class="form-select" id="payment_order" name="payment_order">
                    <option value="">Choose product</option>
                <option value="Cash On Delivery">Cash On Delivery</option>
                <option value="Online payment">Online payment</option>
                </select>
                 @error('payment_order')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success rounded-pill">Submit</button>
                  <button type="reset" class="btn btn-secondary rounded-pill">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->


@endsection
