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
              <h5 class="card-title">Register Product</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.product') }}" enctype="multipart/form-data">
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
                            @forelse ($category_list as $category)
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

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register Category</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.category') }}">
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
