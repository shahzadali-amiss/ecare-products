@include('inc.seller-header')
@include('inc.seller-breadcrumb')
<div class="container mb-5 pb-3">
  <div class="bg-light shadow-lg rounded-3 overflow-hidden">
    <div class="row"> 
      @include('inc.seller-sidebar')
      @yield('content')
    </div>
  </div>
  </main>
@include('inc.seller-footer')