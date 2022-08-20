<nav class="sidebar sidebar-offcanvas pt-5" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="icon-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#user">
        <i class="icon-user menu-icon"></i>
        <span class="menu-title">Users</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="user">
        <ul class="nav flex-column sub-menu">
          <!-- <li class="nav-item"> <a class="nav-link" href="{{route('admin-add-user','user')}}"> Add New User </a></li> -->
          <!-- <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-users', 'user')}}"> All Users </a></li> -->
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-users',['customer'])}}"> Customers </a></li>
          <!-- <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-users', ['supplier'])}}"> Suppliers </a></li> -->
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#product">
        <i class="icon-handbag menu-icon"></i>
        <span class="menu-title">Products</span>
        <i class="menu-arrow"></i>  
      </a>
      <div class="collapse" id="product">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('showProductCategories')}}"> Add New Product </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-all-products')}}"> All Products </a></li>
        </ul>
      </div>
    </li>
   
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#category">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Categories</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="category">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('add_category')}}"> Add New Category </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-all-categories')}}"> All Categories </a></li>
        </ul>
      </div>
    </li>

    <!-- <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#attr">
        <i class="icon-user menu-icon"></i>
        <span class="menu-title">Attributes</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="attr">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('add_attribute')}}"> Add New Atribute </a></li>       
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-attributes')}}"> All Attributes </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-users',['costumers'])}}"> Customers </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-users', ['supplires'])}}"> Suppliers </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#attr-val">
        <i class="icon-user menu-icon"></i>
        <span class="menu-title">Attribute Values</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="attr-val">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('add_attribute_values')}}"> Add New Values </a></li>          
          <li class="nav-item"> <a class="nav-link" href="{{route('admin-show-attribute-values')}}"> All Attribute Values</a></li>
        </ul>
      </div>
    </li> -->    
    <!-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-picture menu-icon"></i>
        <span class="menu-title">Images</span>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin-orders')}}">
        <i class="icon-star menu-icon"></i>
        <span class="menu-title">Orders</span>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{route('admin-invoices')}}">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Invoices</span>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin-payments')}}">
        <i class="icon-credit-card menu-icon"></i>
        <span class="menu-title">Payments</span>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-present menu-icon"></i>
        <span class="menu-title">Promocodes</span>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#banners">
        <i class="icon-picture menu-icon"></i>
        <span class="menu-title">Home Banners</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="banners">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('add_ad_banner') }}"> Add New Banner </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('list_banners') }}"> List of Banners </a></li>
        </ul>
      </div>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-flag menu-icon"></i>
        <span class="menu-title">Profile</span>
      </a>
    </li> -->
    <!-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-settings menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li> -->
  </ul>
</nav>