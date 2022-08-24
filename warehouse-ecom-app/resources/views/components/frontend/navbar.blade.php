 <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('/') }}" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">{{ config('appEnv.app.name') }}</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search Products" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->
<nav class="header-nav ms-auto">
    <div style="padding-right:10px">

         <ul>
            <li>
                 @if (Route::has('login'))
                  @auth
                  <a href="{{ route('dashboard') }}"><button type="button" class="btn btn-success rounded-pill">Dashboard</button></a>
                   @else
                    <a href="{{ route('login') }}"><button type="button" class="btn btn-success rounded-pill">login</button></a>
                    {{-- <a href="{{ route('register') }}"><button type="button" class="btn btn-primary rounded-pill">Register</button></a> --}}
                    @endauth
                 @endif
            </li>
        </ul>
    </div>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
