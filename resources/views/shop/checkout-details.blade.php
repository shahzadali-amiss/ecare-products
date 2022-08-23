@extends('layouts.app')
@section('content')
<div class="breadcrumb-wrap">
        <div data-elementor-type="wp-post" data-elementor-id="7851" class="elementor elementor-7851">
            <section
                class="elementor-section elementor-top-section elementor-element elementor-element-5bf4b83 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                data-id="5bf4b83" data-element_type="section"
                data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a821f7b"
                        data-id="a821f7b" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-bff62c9 hidden-organey-title-single-yes elementor-widget elementor-widget-woocommerce-breadcrumb"
                                data-id="bff62c9" data-element_type="widget"
                                data-widget_type="woocommerce-breadcrumb.default">
                                <div class="elementor-widget-container">
                                    <div class="organey-woocommerce-title">Checkout</div>
                                    <nav class="woocommerce-breadcrumb"><a
                                        href="{{ route('welcome') }}">Home</a><i aria-hidden="true"
                                        class="organey-icon-angle-right"></i>Checkout</nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <main class="site-main post-8 page type-page status-publish hentry" role="main">
        <div class="container clearfix">
            <div id="primary" class="content-area">
                <header class="page-header">
                </header>
                <div class="page-content">
                    <div class="entry-content">
                        <div class="woocommerce">
                            <div class="woocommerce-notices-wrapper"></div>
                            @include('inc.session-message')
                            <form name="checkout" method="post" action="{{ route('checkout') }}">
                            @csrf
                                <div class="col2-set" id="customer_details">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Shipping Details</h3>
                                            
                                            @include('inc.shipping_address')

                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="woocommerce-shipping-fields">
                                        </div>
                                        <div class="woocommerce-additional-fields">
                                            <h3>Additional information</h3>
                                            <div class="woocommerce-additional-fields__field-wrapper">
                                                <p class="form-row notes" id="order_comments_field" data-priority="">
                                                    <label for="order_comments" class="">Order notes&nbsp;
                                                        <span class="optional">(optional)</span>
                                                    </label>
                                                    <span class="woocommerce-input-wrapper">
                                                        <textarea
                                                        name="order_comments" class="input-text "
                                                        id=""
                                                        placeholder="Notes about your order, e.g. special notes for delivery."
                                                        rows="2" cols="5">    
                                                        </textarea>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 id="order_review_heading">Your order</h3>
                                {{-- @if($items->isEmpty())
                                    <div class="woocommerce">
                                        <img src="{{ asset('images/emptycart.png') }}" style="margin: 0 auto 50px auto;">
                                        <p class="return-to-shop" style="text-align:center;">
                                            <a class="button wc-backward" href="{{ route('all-products') }}">Return to shop</a>
                                        </p>
                                    </div>
                                @else --}}
                                <div id="order_review" class="woocommerce-checkout-review-order">
                                    <table class="shop_table woocommerce-checkout-review-order-table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Subtotal</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>

                                            @php $total = 0 @endphp
                                            @foreach($items as $item)
                                                @php 
                                                    $image = $item->product->image;
                                                    $item_id = $item->id;
                                                @endphp
                                            <tr class="cart_item woocommerce-cart-form__cart-item">
                                                <td class="product-thumbnail">
                                                    <a href="#"><img width="50" height="50" src='{{ asset("product_images/$image") }}' class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt=""
                                                        srcset='{{ asset("product_images/$image") }}'
                                                        sizes="(max-width: 50px) 100vw, 50px" /></a>
                                                    {{ ucwords($item->product->name) }}<strong
                                                        class="product-quantity">&times;&nbsp;{{ $item->quantity }}</strong> </td>
                                                <td class="product-total">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                        <span class="woocommerce-Price-currencySymbol">₹
                                                        </span>{{ $item_total = $item->price * $item->quantity }}</bdi>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            @php $total += $item_total @endphp

                                            @endforeach
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span>
                                                    {{ $total }}
                                                 </bdi></span>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td><strong><span class="woocommerce-Price-amount amount"><bdi>
                                                <span class="woocommerce-Price-currencySymbol">₹
                                                </span>
                                                {{ $total }}</bdi>
                                                </span></strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        
                                    </table>
                                    <div id="payment" class="woocommerce-checkout-payment">
                                        <ul class="wc_payment_methods payment_methods methods">
                                            <li class="woocommerce-notice woocommerce-notice--info woocommerce-info">
                                                Sorry, it seems that there are no available payment methods for your
                                                state. Please contact us if you require assistance or wish to make
                                                alternate arrangements.</li>
                                        </ul>
                                        <div class="form-row place-order">
                                            <div class="woocommerce-terms-and-conditions-wrapper">
                                                <div class="woocommerce-privacy-policy-text">
                                                    <p>Your personal data will be used to process your order, support
                                                        your experience throughout this website, and for other purposes
                                                        described in our <a href="{{ route('privacy') }}"
                                                            class="woocommerce-privacy-policy-link"
                                                            target="_blank">privacy policy</a>.</p>
                                                </div>
                                            </div>
                                            
                                            <input type="submit" value="Place Order" class="button alt">

                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
  <!-- <script type="text/javascript">
  jQuery(document).ready(function($){
    $('#checkout-state').on('change', function(){
      if($(this).val() != ""){
        var url = '/api/get-cities-from-state/'+($(this).val());
        $.get(url, function(data, status){
          if(data.status==true){
            
            //console.log(data.data);
            bindParentCategory(data.data,'checkout-city');
          }    
        });
      }
    });

    function bindParentCategory(data, element){  
      var sel=document.getElementById(element);
      sel.innerText = "";
      var opt = document.createElement('option');
      opt.innerHTML = 'Select city';
      opt.value = "";
      // opt.setAttribute('data-display', 'Please Select');
      sel.appendChild(opt);

          //console.log(data.length);
      // ITERATE TO BIND OPTIONS
      for(var i = 0; i < data.length; i++) {
          var opt = document.createElement('option');
          opt.innerHTML = data[i].city;
          opt.value = data[i].id;
          sel.appendChild(opt);
      }
    }
  });
  </script> -->
@endpush