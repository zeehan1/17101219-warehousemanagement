<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-heading">Product Categories</li>

       <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <hr>
      @if( $user_status === 'Admin')
      <!-----Moderator-------->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('moderator.panel') }}">
          <i class="bi bi-person"></i>
          <span>Moderator / User panel</span>
        </a>
      </li>
      <!-----End Moderator-------->
      <!-----Warehouse-------->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('warehouse.panel') }}">
          <i class="bi bi-house"></i>
          <span>Warehouse / Area panel</span>
        </a>
      </li>
      <!-----End Warehouse-------->
        <!-----Store Product-------->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('category.stockPanel') }}">
          <i class="bi bi-diagram-3"></i>
          <span>Category & Stock product panel</span>
        </a>
      </li>
      <!-----End Warehouse-------->
      @elseif($user_status === 'Moderator')
      <!-----Moderator-------->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('category.productPanel') }}">
          <i class="bi bi-person"></i>
          <span>Category & product panel</span>
        </a>
      </li>
      <!-----End Moderator-------->
      @endif
    </ul>

  </aside><!-- End Sidebar-->
