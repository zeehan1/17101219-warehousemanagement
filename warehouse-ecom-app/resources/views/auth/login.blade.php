@extends('layouts.frontend.frontend-master')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Login Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Login</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <p class="text-center text-muted">Login with your email and password</p>
                      <x-jet-validation-errors class="p-2 text-light bg-danger" />

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                         @if(session('successfully registered'))
                        <div class="alert alert-success" role="alert">
                        {{ session('successfully registered') }}
                        </div>
                        @endif
                     <!-- Horizontal Form -->
             <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="row mb-3 pt-2">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input class="form-control"  type="email" name="email" value="{{ old('email') }}" required >
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                      <label class="form-check-label" for="gridCheck1">
                        Remember me
                      </label>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success rounded-pill">Log in</button>
                </div>
              </form><!-- End Horizontal Form -->
              <p>Don't have account?<a href="{{ route('register') }}" class="text-success"> Register here</a></p>
                </div>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection
