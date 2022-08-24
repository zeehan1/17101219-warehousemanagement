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
                @foreach($fetch_user as $user)
              <h5 class="card-title">Update {{ $user->name }}'s details</h5>

              <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('moderator.update') }}">
                @csrf
                <div class="col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" hidden>
                @foreach($fetch_role as $role)
                 <div class="col-md-12">
                <label for="email" class="form-label">Status</label>
                @if($role->role === 'Moderator')
                     <select id="inputState" class="form-select" name="role" id="role">
                        <option value="Admin" >Admin</option>
                        <option value="Moderator"selected>Moderator</option>
                     </select>

                </div>
                @elseif($role->role === 'Admin')
                  <select id="inputState" class="form-select" name="role" id="role">
                        <option value="Admin" selected>Admin</option>
                        <option value="Moderator">Moderator</option>
                     </select>

                </div>
                @endif
                </div>
                @endforeach
                <div class="text-center">
                  <button type="submit" class="btn btn-success rounded-pill">Submit</button>
                  <button type="reset" class="btn btn-secondary rounded-pill">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->
              @endforeach
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->


@endsection
