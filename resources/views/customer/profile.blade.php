@extends('layouts.user')
@section('content')
<!-- Content  -->  
<section class="col-lg-8"> 
  <!-- Toolbar--> 
  <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
    <h6 class="fs-base text-light mb-0">Update you profile details below:</h6><a class="btn btn-primary btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Sign out</a>
  </div> 
  @include('inc.session-message')
  <!-- Profile form-->
  <form method="post" action="{{route('home')}}">
    @csrf
    <!-- <div class="bg-secondary rounded-3 p-4 mb-4">
      <div class="d-flex align-items-center"><img class="rounded" src="{{asset('img/shop/account/avatar.jpg')}}" width="90" alt="Susan Gardner">
        <div class="ps-3">
          <button class="btn btn-light btn-shadow btn-sm mb-2" type="button"><i class="ci-loading me-2"></i>Change avatar</button>
          <div class="p mb-0 fs-ms text-muted">Upload JPG, GIF or PNG image. 300 x 300 required.</div>
        </div>
      </div>
    </div> -->
    <div class="row gx-4 gy-3">
      <div class="col-sm-12">
        <label class="form-label" for="account-fn">Full Name</label>
        <input class="form-control" type="text" id="account-fn" value="{{ Session::get('customer.name') }}" disabled>
      </div>
      <!-- <div class="col-sm-6">
        <label class="form-label" for="account-ln">Last Name</label>
        <input class="form-control" type="text" id="account-ln" value="" readonly>
      </div> -->
      <div class="col-sm-6">
        <label class="form-label" for="account-email">Email Address</label>
        <input class="form-control" type="email" name="email" id="account-email" value="{{  Session::get('customer.email') }}{{old('email')}}">
      </div>
      <div class="col-sm-6">
        <label class="form-label" for="account-phone">Phone Number</label>
        <input class="form-control" type="text" id="account-phone" value="{{  Session::get('customer.mobile') }}" disabled>
      </div>
      <div class="col-sm-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="for-password">
          <label class="form-check-label" for="for-password">Update password also</label>
        </div>
      </div>
    </div>
    <div class="row mt-4 d-none" id="password-row">
      <div class="col-sm-6">
        <label class="form-label" for="account-pass">New Password</label>
        <div class="password-toggle">
          <input class="form-control" type="password" id="password" name="password" required>
          <label class="password-toggle-btn" aria-label="Show/hide password">
            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
          </label>
        </div>
      </div>
      <div class="col-sm-6">
        <label class="form-label" for="account-confirm-pass">Confirm Password</label>
        <div class="password-toggle">
          <input class="form-control" type="password" id="password_confirmation" required name="password_confirmation">
          <label class="password-toggle-btn" aria-label="Show/hide password">
            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <hr class="mt-4 mb-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <!-- <div class="form-check">
            <input class="form-check-input" type="checkbox" name="" id="subscribe_me" checked>
            <label class="form-check-label" for="subscribe_me">Subscribe me to AtaaHai</label>
          </div> -->
          <button class="btn btn-primary mt-3 mt-sm-0" type="submit">Update Profile</button>
        </div>
      </div>
    </div>
  </form>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
  jQuery(document).ready(function($){
    $('#for-password').on('click', function(){
        if(this.checked){
          $('#password-row').removeClass('d-none');
          $('#password').attr('disabled',false);
          $('#password_confirmation').attr('disabled',false);
        }else{
          $('#password-row').addClass('d-none');
          $('#password').attr('disabled',true);
          $('#password_confirmation').attr('disabled',true);
        }
    });
    if(this.checked){
      $('#password-row').removeClass('d-none');
      $('#password').attr('disabled',false);
      $('#password_confirmation').attr('disabled',false);
    }else{
      $('#password-row').addClass('d-none');
      $('#password').attr('disabled',true);
      $('#password_confirmation').attr('disabled',true);
    }
  });
</script>
@endpush