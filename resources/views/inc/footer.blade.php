<footer class="footer bg-dark pt-5">
      @include('inc.footer-top')
      @include('inc.footer-bottom')
    </footer>
    {{--@include('inc.mobile-toolbar')--}}
    <!-- Back To Top Button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2"></span><i class="btn-scroll-top-icon ci-arrow-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/simplebar/dist/simplebar.min.js')}}"></script>
    
    <script src="{{asset('vendor/tiny-slider/dist/min/tiny-slider.js')}}"></script>
    <script src="{{asset('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/3d8c19b62e.js" crossorigin="anonymous"></script>
    <script src="{{asset('vendor/drift-zoom/dist/Drift.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery.js/dist/js/lightgallery.min.js')}}"></script>
    <script src="{{asset('vendor/lg-video.js/dist/lg-video.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/3d8c19b62e.js" crossorigin="anonymous"></script>
    <!-- Main theme script-->
    <script src="{{asset('js/theme.min.js')}}"></script>
    @stack('scripts')
  </body>
</html>