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
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                @foreach($fetch_product_details as $product_details)
              <h5 class="card-title">Update {{ $product_details->name }}'s details</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('product.update') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $product_details->name }}">
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <input type="text" class="form-control" id="sku_id" name="sku_id" value="{{ $product_details->sku_id }}" hidden>
                 <div class="col-md-12">
                  <label for="name" class="form-label">Stock</label>
                  <input type="text" class="form-control" id="add_stock" name="add_stock" value="{{ $product_details->quantiry }}">
                  @error('add_stock')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                 @endforeach
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
