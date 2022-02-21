@if(Session::has('success'))
  <div class="alert alert-success fix-message">
      <p class="msg"> {{ Session::get('success') }}</p>
  </div>
@endif

@if(Session::has('error'))
  <div class="alert alert-danger fix-message">
      <p class="msg"> {{ Session::get('error') }}</p>
  </div>
@endif

@if(Session::has('status'))
  <div class="alert alert-primary fix-message">
      <p class="msg"> {{ Session::get('status') }}</p>
  </div>
@endif

@push('scripts')
<script>
	jQuery(document).ready(function($){
		$('.alert-success').fadeIn().delay(5000).fadeOut();
		$('.alert-danger').fadeIn().delay(5000).fadeOut();
		$('.alert-primary').fadeIn().delay(5000).fadeOut();
	});
</script>
@endpush

