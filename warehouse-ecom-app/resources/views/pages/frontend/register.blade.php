@extends('layouts.frontend.frontend-master')
@section('content')
 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Register Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Register</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register</h5>
              <p class="text-center text-muted">Don't you have an account? Register here</p>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('store.register') }}">
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
      </div>
    </section>

  </main><!-- End #main -->


@endsection
