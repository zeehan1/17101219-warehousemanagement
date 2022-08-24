@php
$category_list = DB::table('caregories')
->where('status','=','Active')
->orderBy('id', 'ASC')
->get();
@endphp
<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
@auth
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-heading">Product Categories</li>

      <li class="nav-item">
        @forelse ($category_list as $category)
        <a class="nav-link " href="#">
          <span>{{ $category->name }}</span>
        </a>
        @empty
            <span>No Category to show</span>
        @endforelse
      </li><!-- End Blank Page Nav -->

    </ul>
  @else
@endauth
  </aside><!-- End Sidebar-->
