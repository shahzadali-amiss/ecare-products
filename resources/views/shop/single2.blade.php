@extends('layouts.app')
@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-6">
            <div id="js-gallery" class="gallery">

                <div class="gallery__hero">               
                  <img src='{{ asset("product_images/$product->image") }}'>
                </div>
          
                <div class="gallery__thumbs">
                    
                    <a href='{{ asset("product_images/$product->image") }}' data-gallery="thumb" class="is-active">
                      <img src='{{ asset("product_images/$product->image") }}'>
                    </a>

                    @foreach($product->images as $image)
                      <a href='{{ asset("product_images/$image->image") }}' data-gallery="thumb">
                        <img src='{{ asset("product_images/$image->image") }}'>
                      </a>
                    @endforeach

                </div>
          
            </div>
        </div>

        <div class="col-md-6">

            <div class="summary entry-summary ">
                <br>
                @php $category = $product->category->id @endphp
              <a href='{{ route("all-products", "?category=$category") }}'>{{ ucwords($product->category->name) }}</a>
              <h1 class="product_title">
                {{ ucwords($product->name) }}
              </h1>
              <div class="woocommerce-product-rating">
                <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                  <span style="width:80%">Rated <strong class="rating">4.00</strong> out of 5 based on <span class="rating">4</span> customer ratings </span>
                </div>
                <a href="#reviews" class="woocommerce-review-link" rel="nofollow">( <span class="count">5</span> customer reviews) </a>
              </div>
              <p class="price">
                <del aria-hidden="true">
                  <span class="woocommerce-Price-amount amount" style="color: orangered;">
                    <bdi>
                      <span class="woocommerce-Price-currencySymbol">&#8377;</span>{{ $product->mrp }} </bdi>
                  </span>
                </del>
                <ins>
                  <span class="woocommerce-Price-amount amount">
                    <bdi>
                      <span class="woocommerce-Price-currencySymbol">&#8377;</span>{{ $product->offer_price }} </bdi>
                  </span>
                </ins>
                <span style="color: green;">(Saving: {{ $product->discount_percentage }}%)</span>
              </p>
              
              <div class="woocommerce-product-details__short-description">
                {{ $product->description }}
              </div><br>
              
                <span class="text-quantity">Quantity</span>
                <div class="quantity buttons_added">
                    <button type="button" class="minus">-</button>
                    <input type="number" id="quantity_62dfe3debae45" class="input-text item qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric">
                    <button type="button" class="plus">+</button>
                </div>
                <br>
                <input type="hidden" class="item pid" value="{{ $product->id }}">
                <button type="button" id="add-to-cart" class="single_add_to_cart_button add-to-cart button alt">Add to cart</button>
              <!-- <button class="woosw-btn woosw-btn-93" data-id="93">Add to wishlist</button> -->
              <!-- <button class="woosc-btn woosc-btn-93 " data-id="93">Compare</button> -->
              
              <div class="organey-single-product-extra">
                <p>
                  <span style="color:#3D3E3D
            ;font-size:12px;font-weight:600; margin-bottom: 15px; display: block;">Guarantee Safe Checkout</span>
                  <img loading="lazy" style="padding-bottom: 5px;" class="alignnone size-medium wp-image-6252" src="https://demo.leebrosus.com/organey/wp-content/uploads/2021/08/credit-300x17.jpg" sizes="(max-width: 300px) 100vw, 300px" alt="" width="300" height="17">
                </p>
              </div>

              <div class="organey-social-share">
                <a class="social-facebook" href="https://www.facebook.com/sharer.php?u=https://demo.leebrosus.com/organey/product/papaya-single/&amp;display=page" target="_blank" title="Share on facebook">
                  <i class="organey-icon-facebook"></i>
                  <span>Facebook</span>
                </a>
                <a class="social-twitter" href="https://twitter.com/home?status= https://demo.leebrosus.com/organey/product/papaya-single/" target="_blank" title="Share on Twitter">
                  <i class="organey-icon-twitter"></i>
                  <span>Twitter</span>
                </a>
                <a class="social-linkedin" href="https://linkedin.com/shareArticle?mini=true&amp;url=https://demo.leebrosus.com/organey/product/papaya-single/&amp;title=Papaya Single" target="_blank" title="Share on LinkedIn">
                  <i class="organey-icon-linkedin"></i>
                  <span>Linkedin</span>
                </a>
                <a class="social-pinterest" href="https://pinterest.com/pin/create/button/?url=https%3A%2F%2Fdemo.leebrosus.com%2Forganey%2Fproduct%2Fpapaya-single%2F&amp;description=Papaya+Single&amp;; ?>" target="_blank" title="Share on Pinterest">
                  <i class="organey-icon-pinterest-p"></i>
                  <span>Pinterest</span>
                </a>
                <a class="social-envelope" href="mailto:?subject=Papaya Single&amp;body=https://demo.leebrosus.com/organey/product/papaya-single/" title="Email to a Friend">
                  <i class="organey-icon-envelope"></i>
                  <span>Email</span>
                </a>
              </div>
            </div>

        </div>

    </div>

 </div>

@endsection


@push('styles')

<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">

<style type="text/css">
.col-md-6 {
    float: left;
    width: 50%;
}
/**
 * Container Styles
 */
.container {
  margin: 0 auto;
  padding: 1em;
}

/**
 * Helper Styles
 */
.ir {
  text-indent: 100%;
  white-space: nowrap;
  overflow: hidden;
}

/**
 * Gallery Styles
 * 1. Enable fluid images
 */
.gallery {
  overflow: hidden;
}

.gallery__hero {
  overflow: hidden;
  position: relative;
  padding: 2em;
  margin: 0 0 0.3333333333em;
  background: #fff;
}
.is-zoomed .gallery__hero {
  cursor: move;
}
.is-zoomed .gallery__hero img {
  max-width: none;
  position: absolute;
  z-index: 0;
  top: -50%;
  left: -50%;
}

.gallery__hero-enlarge {
  position: absolute;
  right: 0.5em;
  bottom: 0.5em;
  z-index: 1;
  width: 30px;
  height: 30px;
  opacity: 0.5;
  background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMCIgaGVpZ2h0PSIzMCIgdmlld0JveD0iNS4wIC0xMC4wIDEwMC4wIDEzNS4wIiBmaWxsPSIjMzRCZjQ5Ij48cGF0aCBkPSJNOTMuNTkzIDg2LjgxNkw3Ny4wNDUgNzAuMjY4YzUuNDEzLTYuODczIDguNjQyLTE1LjUyNiA4LjY0Mi0yNC45MTRDODUuNjg3IDIzLjEwNCA2Ny41OTMgNSA0NS4zNDMgNVM1IDIzLjEwNCA1IDQ1LjM1NGMwIDIyLjI0IDE4LjA5NCA0MC4zNDMgNDAuMzQzIDQwLjM0MyA5LjQgMCAxOC4wNjItMy4yNCAyNC45MjQtOC42NTNsMTYuNTUgMTYuNTZjLjkzNy45MjcgMi4xNjIgMS4zOTYgMy4zODggMS4zOTYgMS4yMjUgMCAyLjQ1LS40NyAzLjM5LTEuMzk2IDEuODc0LTEuODc1IDEuODc0LTQuOTEyLS4wMDItNi43ODh6bS00OC4yNS0xMC43MWMtMTYuOTU0IDAtMzAuNzUzLTEzLjc5OC0zMC43NTMtMzAuNzUyIDAtMTYuOTY0IDEzLjgtMzAuNzY0IDMwLjc1My0zMC43NjQgMTYuOTY0IDAgMzAuNzUzIDEzLjggMzAuNzUzIDMwLjc2NCAwIDE2Ljk1NC0xMy43ODggMzAuNzUzLTMwLjc1MyAzMC43NTN6TTYzLjAzMiA0NS4zNTRjMCAyLjM0NC0xLjkwNyA0LjI2Mi00LjI2MiA0LjI2MmgtOS4xNjR2OS4xNjRjMCAyLjM0NC0xLjkwNyA0LjI2Mi00LjI2MiA0LjI2Mi0yLjM1NSAwLTQuMjYyLTEuOTE4LTQuMjYyLTQuMjYydi05LjE2NGgtOS4xNjRjLTIuMzU1IDAtNC4yNjItMS45MTgtNC4yNjItNC4yNjIgMC0yLjM1NSAxLjkwNy00LjI2MiA0LjI2Mi00LjI2Mmg5LjE2NHYtOS4xNzVjMC0yLjM0NCAxLjkwNy00LjI2MiA0LjI2Mi00LjI2MiAyLjM1NSAwIDQuMjYyIDEuOTE4IDQuMjYyIDQuMjYydjkuMTc1aDkuMTY0YzIuMzU1IDAgNC4yNjIgMS45MDcgNC4yNjIgNC4yNjJ6Ii8+PC9zdmc+);
  background-repeat: no-repeat;
  transition: opacity 0.3s cubic-bezier(0.455, 0.03, 0.515, 0.955);
}
.gallery__hero-enlarge:hover {
  opacity: 1;
}
.is-zoomed .gallery__hero-enlarge {
  background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMCIgaGVpZ2h0PSIzMCIgdmlld0JveD0iNS4wIC0xMC4wIDEwMC4wIDEzNS4wIiBmaWxsPSIjMzRCZjQ5Ij48cGF0aCBkPSJNOTMuNTkzIDg2LjgxNkw3Ny4wNDUgNzAuMjY4YzUuNDEzLTYuODczIDguNjQyLTE1LjUyNiA4LjY0Mi0yNC45MTRDODUuNjg3IDIzLjEwNCA2Ny41OTMgNSA0NS4zNDMgNVM1IDIzLjEwNCA1IDQ1LjM1NGMwIDIyLjI0IDE4LjA5NCA0MC4zNDMgNDAuMzQzIDQwLjM0MyA5LjQgMCAxOC4wNjItMy4yNCAyNC45MjQtOC42NTNsMTYuNTUgMTYuNTZjLjkzNy45MjcgMi4xNjIgMS4zOTYgMy4zODggMS4zOTYgMS4yMjUgMCAyLjQ1LS40NyAzLjM5LTEuMzk2IDEuODc0LTEuODc1IDEuODc0LTQuOTEyLS4wMDItNi43ODh6TTE0LjU5IDQ1LjM1NGMwLTE2Ljk2NCAxMy44LTMwLjc2NCAzMC43NTMtMzAuNzY0IDE2Ljk2NCAwIDMwLjc1MyAxMy44IDMwLjc1MyAzMC43NjQgMCAxNi45NTQtMTMuNzkgMzAuNzUzLTMwLjc1MyAzMC43NTMtMTYuOTUzIDAtMzAuNzUzLTEzLjgtMzAuNzUzLTMwLjc1M3pNNTguNzcyIDQ5LjYxSDMxLjkyYy0yLjM1NSAwLTQuMjYzLTEuOTA3LTQuMjYzLTQuMjZzMS45MDgtNC4yNjMgNC4yNjItNC4yNjNINTguNzdjMi4zNTQgMCA0LjI2MiAxLjkwOCA0LjI2MiA0LjI2MnMtMS45MSA0LjI2LTQuMjYyIDQuMjZ6Ii8+PC9zdmc+);
}

.gallery__thumbs {
  text-align: center;
  background: #fff;
}
.gallery__thumbs a {
  display: inline-block;
  width: 20%;
  padding: 0.5em;
  opacity: 0.75;
  transition: opacity 0.3s cubic-bezier(0.455, 0.03, 0.515, 0.955);
}
.gallery__thumbs a:hover {
  opacity: 1;
}
.gallery__thumbs a.is-active {
  opacity: 0.2;
}
    </style>
@endpush

@push('scripts')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.js"></script>

<script type="text/javascript">
var App = (function () {

  //=== Use Strict ===//
  'use strict';

  //=== Private Variables ===//
  var gallery = $('#js-gallery');
  $('.gallery__hero').zoom();
  

  //=== Gallery Object ===//
  var Gallery = {
    zoom: function(imgContainer, img) {
      var containerHeight = imgContainer.outerHeight(),
      src = img.attr('src');
    
    },
    switch: function(trigger, imgContainer) {
      var src = trigger.attr('href'),
      thumbs = trigger.siblings(),
            img = trigger.parent().prev().children();
      
      // Add active class to thumb
      trigger.addClass('is-active');
      
      // Remove active class from thumbs
      thumbs.each(function() {
        if( $(this).hasClass('is-active') ) {
          $(this).removeClass('is-active');
        }
      });

  
      // Switch image source
      img.attr('src', src);
    }
  };

  //=== Public Methods ===//
  function init() {

 
   // Listen for clicks on anchors within gallery
    gallery.delegate('a', 'click', function(event) {
      var trigger = $(this);
      var triggerData = trigger.data("gallery");

      if ( triggerData === 'zoom') {
        var imgContainer = trigger.parent(),
        img = trigger.siblings();
        Gallery.zoom(imgContainer, img);
      } else if ( triggerData === 'thumb') {
        var imgContainer = trigger.parent().siblings();
        Gallery.switch(trigger, imgContainer);
      } else {
        return;
      }

      event.preventDefault();
    });
  }

  //=== Make Methods Public ===//
  return {
    init: init
  };

})();

App.init();
    </script>
    
@endpush