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
              <h5 class="card-title">Order Table</h5>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <div class="col ">
                                <input type="search" id="product_query_stock" name="product_query_stock" value="{{ request()->query('product_query_stock') }}" class="form-control" style="border-color: #012970;" placeholder="Search Product" autocomplete="off"/>
                            </div>

                                <div class="col pt-2">
                                <button type="submit" class="btn" style="background-color:#012970;color:white">
                                    Search
                                </button>
                                </div>
                        </form>
                    <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                <thead>
                  <tr>
                     <th scope="col">Order ID</th>
                     <th scope="col">Name</th>
                     <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Adress</th>
                    <th scope="col">Product Details</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Payment status</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Take action</th>
                  </tr>
                </thead>
                @foreach ($sock_order_list as $stock_product)
                <tbody>
                  <tr>
                    <td>{{ $stock_product->order_id }}</td>
                    <td>{{ $stock_product->client_name }}</td>
                    <td>{{ $stock_product->contact }}</td>
                    <td>{{ $stock_product->email }}</td>
                    <td>{{ $stock_product->address }}</td>
                    <td>{{ $stock_product->product_name }}</td>
                    <td>{{ $stock_product->quantity }}</td>
                     <td>{{ $stock_product->payment }}</td>
                     <td>
                 @if($stock_product->status=== 'Pending')
                            <span class="btn btn-warning btn-sm rounded-pill">{{ $stock_product->status }}</span>
                         @else
                            <span class="btn btn-success btn-sm rounded-pill">{{ $stock_product->status }}</span>
                        @endif
                </td>
                    <td>{{ Carbon\Carbon::parse($stock_product->created_at)->diffForHumans() }}</td>
                    <td>
                       @if($stock_product->status=== 'Pending')
                            <a href="{{ route('product.stockUpdateComplete',['order_id' => $stock_product->order_id,'current_status' => $stock_product->status]) }}" type="button" class="btn btn-success btn-sm ">Make Complete</a>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
                    </div>

                    {{ $sock_order_list->withQueryString()->links() }}
            </div>
        </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Pre order Table</h5>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <div class="col ">
                                <input type="search" id="product_query_preorder" name="product_query_preorder" value="{{ request()->query('product_query_preorder') }}" class="form-control" style="border-color: #012970;" placeholder="Search Product" autocomplete="off"/>
                            </div>

                                <div class="col pt-2">
                                <button type="submit" class="btn" style="background-color:#012970;color:white">
                                    Search
                                </button>
                                </div>
                        </form>
                    <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                <thead>
                  <tr>
                      <th scope="col">Order ID</th>
                     <th scope="col">Name</th>
                     <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Adress</th>
                    <th scope="col">Details</th>
                   <th scope="col">Payment status</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Take action</th>
                  </tr>
                </thead>
                @foreach ($pre_order_list as $pre_order_)
                <tbody>
                  <tr>
                   <td>{{ $pre_order_->order_id }}</td>
                    <td>{{ $pre_order_->client_name }}</td>
                    <td>{{ $pre_order_->contact }}</td>
                    <td>{{ $pre_order_->email }}</td>
                    <td>{{ $pre_order_->address }}</td>
                    <td>{{ $pre_order_->details }}</td>
                    <td>{{ $pre_order_->payment }}</td>
                   <td>
                 @if($pre_order_->status=== 'Pending')
                            <span class="btn btn-warning btn-sm rounded-pill">{{ $pre_order_->status }}</span>
                         @else
                            <span class="btn btn-success btn-sm rounded-pill">{{ $pre_order_->status }}</span>
                        @endif
                </td>
                    <td>{{ Carbon\Carbon::parse($pre_order_->created_at)->diffForHumans() }}</td>
                    <td>
                        @if($pre_order_->status=== 'Pending')
                            <a href="{{ route('product.preOrderUpdateComplete',['order_id' => $pre_order_->order_id,'current_status' => $pre_order_->status]) }}" type="button" class="btn btn-success btn-sm ">Make Complete</a>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
                    </div>

                    {{ $pre_order_list->withQueryString()->links() }}
            </div>
        </div>
          </div>

        </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

@endsection
