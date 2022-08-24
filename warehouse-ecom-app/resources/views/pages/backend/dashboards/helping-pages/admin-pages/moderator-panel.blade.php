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
              <h5 class="card-title">User Table</h5>
               <div class="row pb-2">
                        <form action="{{ route('moderator.panel') }}" method="GET">
                            <div class="col ">
                                <input type="search" id="car_query" name="name_query" value="{{ request()->query('name_query') }}" class="form-control" style="border-color: #012970;" placeholder="Search moderator" autocomplete="off"/>
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
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered at</th>
                    <th scope="col">Take action</th>
                  </tr>
                </thead>
                @foreach ($fetch_moderator as $moderator)
                <tbody>
                  <tr>
                    <td>{{ $moderator->name }}</td>
                    <td>{{ $moderator->role }}</td>
                   <td>
                 @if($moderator->status=== 'Active')
                            <span class="btn btn-success btn-sm rounded-pill">{{ $moderator->status }}</span>
                         @else
                            <span class="btn btn-warning btn-sm rounded-pill">{{ $moderator->status }}</span>
                        @endif
                </td>
                    <td>{{ Carbon\Carbon::parse($moderator->created_at)->diffForHumans() }}</td>
                    <td>
                        @if($moderator->status=== 'Active')
                            <a href="{{ route('moderator.ststusUpdate',['email' => $moderator->email,'current_status' => $moderator->status]) }}" type="button" class="btn btn-warning btn-sm ">Make Inactive</a>
                         @else
                            <a href="{{ route('moderator.ststusUpdate',['email' => $moderator->email, 'current_status' => $moderator->status]) }}" type="button" class="btn btn-info btn-success  btn-sm ">Make Active</a>
                        @endif
                        <a href="{{ route('moderator.editPage',['email' => $moderator->email]) }}" type="button" class="btn btn-secondary btn-sm ">Edit {{ $moderator->role }}</a>
                         <a href="{{ route('moderator.delete',['email' => $moderator->email]) }}" type="button" class="btn btn-danger btn-sm ">Delete {{ $moderator->role }}</a>
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
                    </div>
                    {{ $fetch_moderator->withQueryString()->links() }}
                </div>
            </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register Moderator</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.moderator') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Your Name</label>
                  <input type="text" class="form-control" id="name" name="name">
                  @error('name')
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
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                   @error('password')
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
