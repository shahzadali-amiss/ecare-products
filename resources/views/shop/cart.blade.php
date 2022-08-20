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
                                <div class="organey-woocommerce-title">Cart</div>
                                <nav class="woocommerce-breadcrumb"><a
                                href="https://demo.leebrosus.com/organey">Home</a><i aria-hidden="true"
                                class="organey-icon-angle-right"></i>Cart</nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

    <main class="site-main post-7 page type-page status-publish hentry" role="main">
        <div class="container clearfix">
            <div id="primary" class="content-area">
                <header class="page-header">
                </header>
                <div class="page-content">
                    <div class="entry-content">

                        @if($items->isEmpty())
                            <div class="woocommerce">
                                <img src="{{ asset('images/emptycart.png') }}" style="margin: 0 auto 50px auto;">
                                <p class="return-to-shop" style="text-align:center;">
                                    <a class="button wc-backward" href="{{ route('all-products') }}">Return to shop</a>
                                </p>
                            </div>
                        @else

                            <div class="woocommerce">
                                <div class="woocommerce-notices-wrapper"></div>
                                <form class="woocommerce-cart-form" method="post" action="{{ route('update_cart') }}">
                                @csrf

                                    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">&nbsp;</th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Subtotal</th>
                                                <th class="product-remove">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php $total = 0 @endphp

                                            @foreach($items as $item)
                                                @php 
                                                    $image = $item->product->image;
                                                    $item_id = $item->id;
                                                @endphp

                                                <tr class="woocommerce-cart-form__cart-item cart_item">

                                                    <td class="product-thumbnail">
                                                        <a href="#"><img
                                                                width="400" height="400"
                                                                src='{{ asset("product_images/$image") }}'
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt=""
                                                                srcset='{{ asset("product_images/$image") }}'
                                                                sizes="(max-width: 400px) 100vw, 400px" /></a>
                                                    </td>

                                                    <td class="product-name" data-title="Product">
                                                        <a href="https://demo.leebrosus.com/organey/product/wrapped-cabbage/">
                                                            {{ ucwords($item->product->name) }}
                                                        </a>
                                                    </td>

                                                    <td class="product-price" data-title="Price">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>
                                                                <span class="woocommerce-Price-currencySymbol">
                                                                &#8377;</span> {{ $item->price }}
                                                            </bdi>
                                                        </span>
                                                    </td>

                                                    <td class="product-quantity" data-title="Quantity">
                                                        <span class="text-quantity">Quantity</span>
                                                        <div class="quantity">
                                                            <input type="number"
                                                                class="input-text qty text" step="1" min="0" max=""
                                                                name="cart[{{$item_id}}][quantity]" value="{{ $item->quantity }}"
                                                                title="Qty" size="4" placeholder="" inputmode="numeric" />
                                                        </div>
                                                    </td>

                                                    <td class="product-subtotal" data-title="Subtotal">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>
                                                                <span class="woocommerce-Price-currencySymbol">&#8377;</span>
                                                                {{ $item_total = $item->price * $item->quantity }}
                                                                @php $total += $item_total @endphp
                                                            </bdi>
                                                        </span>
                                                    </td>
                                                    <td class="product-remove">
                                                        <a href="javascript:void(0)" class="remove remove_from_cart this_is_cart_page" aria-label="Remove this item" data-cart_id="{{ $item->id }}"><i class="organey-icon-delete"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                            <tr>
                                                <td colspan="6" class="actions">

                                                    <div class="coupon">
                                                        <label for="coupon_code">Coupon:</label> <input type="text"
                                                            name="coupon_code" class="input-text" id="coupon_code" value=""
                                                            placeholder="Coupon code" />
                                                        <button type="submit" class="button" name="apply_coupon"
                                                            value="Apply coupon">Apply coupon</button>
                                                    </div>

                                                    <button type="submit" class="button" name="update_cart"
                                                        value="Update cart">Update cart</button>


                                                    <input type="hidden" id="woocommerce-cart-nonce"
                                                        name="woocommerce-cart-nonce" value="63cd5ee101" /><input
                                                        type="hidden" name="_wp_http_referer" value="/organey/cart/" />
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </form>

                                <div class="cart-collaterals">
                                    <div class="cart_totals ">


                                        <h2>Cart totals</h2>

                                        <table cellspacing="0" class="shop_table shop_table_responsive">

                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td data-title="Subtotal">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol">&#8377;</span>{{$total}}
                                                        </bdi>
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td data-title="Total">
                                                    <strong>
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>
                                                                <span class="woocommerce-Price-currencySymbol">&#8377;</span>{{ $total }}
                                                            </bdi>
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>


                                        </table>

                                        <div class="wc-proceed-to-checkout">

                                            <a href="{{ route('checkout') }}" class="checkout-button button alt wc-forward">Proceed to checkout</a>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        @endif

                    </div>

                </div>


            </div>
        </div>
    </main>
@endsection

@push('scripts')
  <!-- <script type="text/javascript">
    function calculateSubtotal(){
      var anchors = document.getElementsByClassName('calc-amount');
      var subtotal=0;
      for(var i = 0; i < anchors.length; i++) {
          var anchor = anchors[i];
          // Get product price
          var price=anchor.querySelector('span.product-price').innerHTML;
          // Get quantity
          var quantity=anchor.querySelector('input').value;
          // Adding product price to subtotal
          subtotal+=price*quantity;
      }
      // set the subtotal to element
      document.getElementById('sub-total').innerHTML=subtotal;   
    }
  </script> -->
@endpush