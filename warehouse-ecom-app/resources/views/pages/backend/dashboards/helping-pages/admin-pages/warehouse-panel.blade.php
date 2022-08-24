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
        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Warehouse Table</h5>
               <div class="row pb-2">
                        <form action="{{ route('warehouse.panel') }}" method="GET">
                            <div class="col ">
                                <input type="search" id="car_query" name="name_query" value="{{ request()->query('name_query') }}" class="form-control" style="border-color: #012970;" placeholder="Search warehouse" autocomplete="off"/>
                            </div>

                                <div class="col pt-2">
                                <button type="submit" class="btn" style="background-color:#012970;color:white">
                                    Search
                                </button>
                                </div>
                        </form>
                        </div>
                    <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Area</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Take action</th>
                  </tr>
                </thead>
                @foreach ($fetch_ware_house as $ware_house)
                <tbody>
                  <tr>
                    <td>{{ $ware_house->name }}</td>
                    <td>{{ $ware_house->area }}</td>
                   <td>
                 @if($ware_house->status=== 'Active')
                            <span class="btn btn-success btn-sm rounded-pill">{{ $ware_house->status }}</span>
                         @else
                            <span class="btn btn-warning btn-sm rounded-pill">{{ $ware_house->status }}</span>
                        @endif
                </td>
                    <td>{{ Carbon\Carbon::parse($ware_house->created_at)->diffForHumans() }}</td>
                    <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if($ware_house->status=== 'Active')
                            <a href="{{ route('warehouse.ststusUpdate',['warehouse_id' => $ware_house->warehouse_id,'current_status' => $ware_house->status]) }}" type="button" class="btn btn-warning btn-sm ">Make Inactive</a>
                         @else
                            <a href="{{ route('warehouse.ststusUpdate',['warehouse_id' => $ware_house->warehouse_id,'current_status' => $ware_house->status]) }}" type="button" class="btn btn-info btn-success  btn-sm ">Make Active</a>
                        @endif
                         <a href="{{ route('warehouse.delete',['warehouse_id' => $ware_house->warehouse_id]) }}" type="button" class="btn btn-info btn-danger  btn-sm ">Delete {{ $ware_house->name }}</a>
                    </div>
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
                    </div>
                    {{ $fetch_ware_house->withQueryString()->links() }}
                </div>
            </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register Warehouse</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.wareHouse') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Warehouse Name</label>
                  <input type="text" class="form-control" id="warhouse_name" name="warhouse_name">
                  @error('warhouse_name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="area">Area</label>
                    <select class="form-select" id="selected_area" name="selected_area">
                    <option value="">Choose Area</option>
                    @foreach ($get_area as $area)
                        <option value="{{ $area->area }}">{{ $area->area }}</option>
                    @endforeach
                </select>
                 @error('selected_area')
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

             <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register area</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.area') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Area Name</label>
                  <input type="text" class="form-control" id="area" name="area">
                  @error('area')
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
