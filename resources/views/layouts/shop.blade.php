@include('inc.header')
  @include('inc.user-breadcrumb')
  <div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
      @yield('content')
    </div>
  </div>
  </main>
@include('inc.footer')