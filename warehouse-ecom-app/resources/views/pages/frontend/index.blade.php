@extends('layouts.frontend.frontend-master')
@section('content')
 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Welcome To {{ config('appEnv.app.name') }}</h1>
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
        <div class="card">
            <h4 class="p-2 text-center">All Products</h4>
        </div>
      </div>

      <div class="row">
        @forelse ($fetch_product as $product)
        <div class="col-lg-3">

          <div class="card">
            <img src="{{ asset($product->img) }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 300px">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Category: {{ $product->category }}</li>
                <li class="list-group-item">Price: {{ $product->selling_price }}</li>
                @if($product->stock_status === 'In stock')
                <li class="list-group-item">Stock : <span class="badge bg-success">{{ $product->stock_status }}</span></li>
                @else
                 <li class="list-group-item">Stock : <span class="badge bg-warning">{{ $product->stock_status }}</span></li>
                 @endif
            </ul>
            <div class="card-body">
                 <a href="#" class="btn btn-primary rounded-pill">Pre Order</a>
            </div>
            </div>

        </div>
        @empty
        <div class="col-12">
            <div class="card ">
               <h6 class="p-2 text-center text-danger">No product to show {{ request()->query('name_query') }}</h6>
            </div>
        </div>
        @endforelse

      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="d-flex justify-content-center text-center pt-2">{{ $fetch_product->withQueryString()->links() }}</div>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->


@endsection
