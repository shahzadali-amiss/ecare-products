@extends('layouts.app')
@section('content')

<section class="elementor-section elementor-section-boxed">
  <div class="elementor-container elementor-column-gap-no">
    
    <div class="tabset">
      <!-- Tab 1 -->
      <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
      <label for="tab1">My Profile</label>
      <!-- Tab 2 -->
      <input type="radio" name="tabset" id="tab2" aria-controls="my_orders">
      <label for="tab2">My Orders</label>
      
      <div class="tab-panels">
        <section id="marzen" class="tab-panel">
          <h2>Welcome <b>{{ auth::user()->name }}</h2>
            
            <div class="form-group">
              <label>Email</label>
              <input type="text" value="{{ auth::user()->email }}" disabled>
            </div>

            <div class="form-group">
              <label>Mobile</label>
              <input type="text" value="{{ auth::user()->mobile }}" readonly>
            </div>

      </section>
        <section id="my_orders" class="tab-panel">
          <h2>My Orders</h2>
          <p><strong>Overall Impression:</strong>  An elegant, malty German amber lager with a balanced, complementary beechwood smoke character. Toasty-rich malt in aroma and flavor, restrained bitterness, low to high smoke flavor, clean fermentation profile, and an attenuated finish are characteristic.</p>
          <p><strong>History:</strong> A historical specialty of the city of Bamberg, in the Franconian region of Bavaria in Germany. Beechwood-smoked malt is used to make a Märzen-style amber lager. The smoke character of the malt varies by maltster; some breweries produce their own smoked malt (rauchmalz).</p>
        </section>
      </div>
      
    </div>

  </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/user_profile.css') }}">
@endpush

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