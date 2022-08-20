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
                                    <div class="organey-woocommerce-title">Shop</div>
                                    <nav class="woocommerce-breadcrumb"><a
                                            href="https://demo.leebrosus.com/organey">Home</a><i aria-hidden="true"
                                            class="organey-icon-angle-right"></i>Shop</nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <header class="woocommerce-products-header">
    </header>
    <div class="container clearfix site-main">
        <div id="primary" class="content-area">
            <main id="main" class="main" role="main">
                <div class="woocommerce-notices-wrapper"></div>
                <div class="organey-sorting">
                    <div class="skeleton-body" style="width: 100%;">
                        <h3 style="margin-bottom: 0;">Product Catalog</h3>
                        <form action="{{ route('all-products') }}" class="woocommerce-ordering" style="float: right; margin: -38px 0 0 0;" method="get">
                            <select name="orderby" class="orderby" aria-label="Shop order">
                                <option value="date">Sort by latest</option>
                                <option value="price">Sort by price: low to high</option>
                                <option value="price-desc">Sort by price: high to low</option>
                            </select>
                        </form>
                    </div>
                </div>
                <ul class="organey-products products columns-4 columns-mobile-2">
                    
                    @foreach($products as $product)
                        <li class="product-style-default product type-product post-93 status-publish first onbackorder
                        product_cat-fruits product_cat-uncategorized product_tag-fruits has-post-thumbnail sale virtual purchasable product-type-simple">
                          <div class="skeleton-body">
                            <div class="product-block">
                              <div class="product-transition">
                                
                                @if($product->discount_percentage > 0)
                                    <span class="onsale">-{{ $product->discount_percentage }}%</span>
                                @endif

                                <div class="product-img-wrap none"> 
                                  <div class="inner">
                                    <div class="product-image">
                                      <img width="400" height="400" src='{{ asset("product_images/$product->image") }}' />
                                    </div> 
                                  </div> 
                                </div>
                                <div class="quick-shop-wrapper"> 
                                  <div class="quick-shop-close cross-button">
                                    <span>Close</span>
                                  </div>
                                  <div class="quick-shop-form"> </div> 
                                </div>
                                <a href="{{ route('single', $product->id) }}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
                              </div>
                              <div class="product-caption">
                                <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                  <span style="width:80%">Rated 
                                    <strong class="rating">4.00</strong> 
                                    outof 5
                                  </span>
                                </div>
                                <h2 class="woocommerce-loop-product__title">
                                  <a href="https:\/\/demo.leebrosus.com\/organey\/product\/papaya-single\/">
                                      {{ ucwords($product->name) }}
                                  </a>
                                </h2>
                                <span class="price">
                                  <del aria-hidden="true">
                                    <span class="woocommerce-Price-amount amount">
                                      <bdi>
                                        <span class="woocommerce-Price-currencySymbol">&#8377;</span>{{ $product->mrp }}
                                      </bdi>
                                    </span>
                                  </del>
                                  <ins>
                                    <span class="woocommerce-Price-amount amount">
                                      <bdi>
                                        <span class="woocommerce-Price-currencySymbol">&#8377;</span>{{ $product->offer_price }}
                                      </bdi>
                                    </span>
                                  </ins>
                                </span>
                                <div class="add-to-cart-wrap">
                                    <input type="hidden" class="item pid" value="{{ $product->id }}">
                                    <input type="hidden" class="item qty" value="1">
                                    <a href="javascript:void(0)" data-quantity="1" class="add-to-cart button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="93" data-product_sku="gorgeous-iron-computer-10479353" aria-label="Add &ldquo;Papaya Single&rdquo; to your cart" rel="nofollow">Add to cart</a>
                                </div> 
                              </div>
                            </div> 
                          </div>
                        </li>

                    @endforeach

                </ul>
                
                {{ $products->links() }}

            </main>
        </div>
        
    </div>

@endsection