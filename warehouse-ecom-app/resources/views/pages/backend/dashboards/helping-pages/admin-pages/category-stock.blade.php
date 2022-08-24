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
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Product Table</h5>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <div class="col ">
                                <input type="search" id="product_query" name="product_query" value="{{ request()->query('product_query') }}" class="form-control" style="border-color: #012970;" placeholder="Search Category" autocomplete="off"/>
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
                     <th scope="col"></th>
                     <th scope="col">SKU</th>
                     <th scope="col">Warehouse</th>
                    <th scope="col">Product name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Specification</th>
                    <th scope="col">Buying Price</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Total Stock of the product</th>
                    <th scope="col">Stock Status</th>
                    <th scope="col">Offer Status</th>
                    <th scope="col">Status</th>
                    <th scope="col">Author</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Take action</th>
                  </tr>
                </thead>
                @foreach ($fetch_product as $product)
                <tbody>
                  <tr>
                    <td><img src="{{ asset($product->img) }}" alt="{{ $product->name }}" style="width: 100px;height:100px"></td>
                    <td>{{ $product->sku_id }}</td>
                    <td>{{ $product->warehouse_name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->specification }}</td>
                    <td>{{ $product->buying_price }}</td>
                    <td>{{ $product->selling_price }}</td>
                     <td>{{ $product->quantiry }}</td>
                     <td>{{ $product->stock_status }}</td>
                     <td>{{ $product->is_offer }}</td>
                   <td>
                 @if($product->status=== 'Active')
                            <span class="btn btn-success btn-sm rounded-pill">{{ $product->status }}</span>
                         @else
                            <span class="btn btn-warning btn-sm rounded-pill">{{ $product->status }}</span>
                        @endif
                </td>
                <td>{{ $product->author }}</td>
                    <td>{{ Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</td>
                    <td>
                     <div class="btn-group" role="group" aria-label="Basic example">
                       @if($product->status=== 'Active')
                            <a href="{{ route('product.ststusUpdate',['sku' => $product->sku_id,'current_status' => $product->status]) }}" type="button" class="btn btn-warning btn-sm ">Make Inactive</a>
                         @else
                            <a href="{{ route('product.ststusUpdate',['sku' => $product->sku_id,'current_status' => $product->status]) }}" type="button" class="btn btn-info btn-success  btn-sm ">Make Active</a>
                        @endif
                        <a href="{{ route('product.edit',['sku' => $product->sku_id]) }}" type="button" class="btn btn-secondary btn-success  btn-sm ">Edit {{ $product->sku_id }} Stock</a>
                     </div>
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
                    </div>

                    {{ $fetch_product->withQueryString()->links() }}
            </div>
        </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register Product</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.productAdmin') }}" enctype="multipart/form-data">
                @csrf
                 <div class="col-md-12">
                    <label for="name" class="form-label">Product name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name">
                    @error('product_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                 </div>

                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Category</label>
                        <select id="category" name="category" class="form-select">
                            <option value="" selected>Choose...</option>
                            @forelse ($category_list_select as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @empty
                            <option value="">No Category Found</option>
                            @endforelse
                        </select>
                         @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Warehouse</label>
                        <select id="warehouse" name="warehouse" class="form-select">
                            <option value="" selected>Choose...</option>
                            @forelse ($fetch_ware_house as $ware_house)
                            <option value="{{ $ware_house->warehouse_id }}">{{ $ware_house->name }}</option>
                            @empty
                            <option value="">No Category Found</option>
                            @endforelse
                        </select>
                         @error('warehouse')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Specification</label>
                             <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" rows="3" id="specification" name="specification"></textarea>
                        @error('specification')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="buying_price" class="form-label">Buying Price</label>
                        <input type="number" class="form-control" id="buying_price" name="buying_price">
                         @error('buying_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Selling Price</label>
                        <input type="number" class="form-control" id="selling_price" name="selling_price">
                         @error('selling_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                     <div class="col-12">
                        <label for="inputAddress2" class="form-label">Total Stock of the product</label>
                        <input type="number" class="form-control" id="total_stock" name="total_stock">
                         @error('total_stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="main_image" class="form-label">Upload an image of your Product as main image:</label>
                         <input type="file" class="form-control" id="main_image" name="main_image">
                         @error('main_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="main_image" class="form-label">Add Product Type Variation</label>
                        <input type="text" class="form-control" id="product_type_variation" name="product_type_variation[]">
                         @error('product_type_variation.0')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="main_image" class="form-label">Add Total quantiy of Product Type Variation</label>
                        <input type="number" class="form-control" id="product_type_variation_quantity" name="product_type_variation_quantity[]">
                         @error('product_type_variation_quantity.0')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table  table-hover" id="dynamic_field" >
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 d-md-block pb-5">
                            <button type="button" name="add" id="add" class="btn btn-primary btn-sm ">+ Add another Product Type Variation</button>
                        </div>
                    </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success rounded-pill">Submit</button>
                  <button type="reset" class="btn btn-secondary rounded-pill">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->
            </div>
          </div>

        </div>
          <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Category Table</h5>
                <form action="{{ route('dashboard') }}" method="GET">
                            <div class="col ">
                                <input type="search" id="car_query" name="name_query" value="{{ request()->query('name_query') }}" class="form-control" style="border-color: #012970;" placeholder="Search Category" autocomplete="off"/>
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
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Take action</th>
                  </tr>
                </thead>
                @foreach ($category_list as $category)
                <tbody>
                  <tr>
                    <td>{{ $category->name }}</td>
                   <td>
                 @if($category->status=== 'Active')
                            <span class="btn btn-success btn-sm rounded-pill">{{ $category->status }}</span>
                         @else
                            <span class="btn btn-warning btn-sm rounded-pill">{{ $category->status }}</span>
                        @endif
                </td>
                    <td>{{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}</td>
                    <td>
                      @if($category->status=== 'Active')
                            <a href="{{ route('category.ststusUpdate',['name' => $category->name,'current_status' => $category->status]) }}" type="button" class="btn btn-warning btn-sm ">Make Inactive</a>
                         @else
                            <a href="{{ route('category.ststusUpdate',['name' => $category->name,'current_status' => $category->status]) }}" type="button" class="btn btn-info btn-success  btn-sm ">Make Active</a>
                        @endif
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
                    </div>

                    {{ $category_list->withQueryString()->links() }}
            </div>
          </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register Category</h5>
              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.categoryAdmin') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Category name</label>
                  <input type="text" class="form-control" id="category_name" name="category_name">
                  @error('category_name')
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

<script>
    //add more
$(document).ready(function(){
    var url = "{{ url('add-remove-input-fields') }}";
    var i=1;
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"  class="dynamic-added"><td><input type="text" class="form-control" id="product_type_variation" name="product_type_variation[]"></td><td><input type="number" class="form-control" id="product_type_variation_quantity" name="product_type_variation_quantity[]"></td><td><button type="button" name="remove"  id="'+i+'" class="btn_remove btn btn-danger rounded-pill">X</button></td></tr>');
        $('#buttonHelper_1').css("display", "none");
        });
    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });
});
</script>
@endsection
