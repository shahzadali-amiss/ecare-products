@extends('layouts.common')
@section('content')
<div class="page-title-overlap bg-dark pt-4"> 
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item">
            <a class="text-nowrap" href="index.html">
              {{ ucwords(getCategory($product->grand_category_id)->name) }}
            </a>
          </li>
          <li class="breadcrumb-item text-nowrap">
            <a href="#">
              {{ ucwords(getCategory($product->parent_category_id)->name) }}
            </a>
          </li>
          <li class="breadcrumb-item text-nowrap">
            <a href="#">
              {{ ucwords(getCategory($product->category_id)->name) }}
            </a>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="container">
  <!-- Gallery + details-->
  <div class="bg-light shadow-lg rounded-3 px-4 py-3 mb-5">
    <div class="p-lg-3">
      <div class="pe-lg-4 text-center text-lg-start">
        <h1 class="h3 mb-0">{{ucwords($product->name)}}</h1>
      </div>
      <div class="row mt-lg-5">

        <!-- Product gallery-->
        <div class="col-lg-7 pe-lg-0 pt-lg-4">
          <div class="product-gallery">
            <div class="product-gallery-preview order-sm-2">
              <div class="product-gallery-preview-item active" id="image1">
                <img class="image-zoom" src="{{asset('/product_images/'.$product->image)}}" data-zoom="{{asset('/product_images/'.$product->image)}}" alt="Product image">
                <div class="image-zoom-pane"></div>
              </div>
              @foreach( getOtherProductImages($product->id) as $key => $image )
              <div class="product-gallery-preview-item" id="image{{$key+2}}">
                <img class="image-zoom" src="{{asset('/product_images/'.$image->image)}}" data-zoom="{{asset('/product_images/'.$image->image)}}" alt="Product image">
                <div class="image-zoom-pane"></div>
              </div>
              @endforeach

            </div>
            <div class="product-gallery-thumblist order-sm-1">
              <a class="product-gallery-thumblist-item active" href="#image1">
                <img src="{{asset('/product_images/'.$product->image)}}" alt="Product thumb">
              </a>
              @foreach( getOtherProductImages($product->id) as $key => $image )
              <a class="product-gallery-thumblist-item" href="#image{{$key+2}}">
                <img src="{{asset('/product_images/'.$image->image)}}" alt="Product thumb">
              </a>
              @endforeach
            </div>
          </div>
        </div>
        <!-- Product details-->
        <div class="col-lg-5 pt-4 pt-lg-0">
          <div class="product-details ms-auto pb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <a href="#reviews" data-scroll>
                <div class="star-rating">
                  <i class="star-rating-icon ci-star-filled active"></i>
                  <i class="star-rating-icon ci-star-filled active"></i>
                  <i class="star-rating-icon ci-star-filled active"></i>
                  <i class="star-rating-icon ci-star-filled active"></i>
                  <i class="star-rating-icon ci-star"></i>
                </div>
                <span class="d-inline-block fs-sm text-body align-middle mt-1 ms-1">74 Reviews</span>
              </a>
              {{--<button class="btn-wishlist me-0 me-lg-n3" type="button" data-bs-toggle="tooltip" title="Add to wishlist"><i class="ci-heart"></i></button>--}}
            </div>
            <div class="mb-3">
              <span class="h3 fw-normal text-accent me-1">₹ {{ $product->offer_price}}.
                <small>99</small>
              </span>
              <del class="text-muted fs-lg me-3">₹ {{$product->mrp}}.
                <small>00</small>
              </del>
              <span class="badge bg-danger badge-shadow align-middle mt-n2">Sale</span>
            </div>
            <form class="mb-grid-gutter" action="{{ route('addtocart') }}" method="post">
              @csrf
            @foreach($product_attributes as $key => $value)            
            <div class="fs-sm">
              <span class="text-heading fw-medium me-1">
                Select {{$key}}
                <div class="position-relative me-n4 mt-2">
                @foreach($value as $k => $v)
                  
                  <div class="form-check form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="{{strtolower($key)}}" id="{{strtolower($key)}}{{$k}}" data-bs-label="colorOption" value="{{$v->value}}" {{ $k==0 ? 'checked' : '' }}>
                    <label class="form-option-label" for="{{strtolower($key)}}{{$k}}">
                      <span class="">{{$v->value}}</span>
                    </label>
                  </div>
                  
                @endforeach
                </div>
              </span>
              <!-- <span class="text-muted" id="colorOption">
              </span> -->
            </div>
            @endforeach
           {{-- <div class="position-relative me-n4 mb-3">
              <div class="form-check form-option form-check-inline mb-2">
                <input class="form-check-input" type="radio" name="color" id="color1" data-bs-label="colorOption" value="Red/Dark blue/White" checked>
                <label class="form-option-label rounded-circle" for="color1">
                  <span class="form-option-color rounded-circle" style="background-image: url(img/shop/single/color-opt-1.png)"></span>
                </label>
              </div>
              <!-- <div class="product-badge product-available mt-n1">
                <i class="ci-security-check"></i>Product available
              </div> -->
            </div>--}}

            @php
            {{ $is_in_cart=false; }}
            @endphp
            @foreach( getCartProducts() as $value )
              @if($value->id==$product->id)
                @php
                {{ $is_in_cart=true;break; }}
                @endphp
              @endif
            @endforeach

            @if($is_in_cart)
              <a class="btn btn-primary btn-shadow d-block w-100" href="{{ route('cart') }}">
                Go to cart<i class="ci-arrow-right fs-lg me-2"></i>
              </a>
            @else

            
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              {{--<div class="mb-3">
                <div class="d-flex justify-content-between align-items-center pb-1">
                  <label class="form-label" for="product-size">Size:</label>
                  <a class="nav-link-style fs-sm" href="#size-chart" data-bs-toggle="modal">
                    <i class="ci-ruler lead align-middle me-1 mt-n1"></i>Size guide
                  </a>
                </div>
                <select class="form-select" required id="product-size">
                  <option value="">Select size</option>
                  <option value="xs">XS</option>
                  <option value="s">S</option>
                  <option value="m">M</option>
                  <option value="l">L</option>
                  <option value="xl">XL</option>
                </select>
              </div>--}}
              <div class="mb-3 d-flex align-items-center">
                <input class="form-control me-3" type="number" min="1" max="5" value="1" name="quantity"  style="width: 5rem;"/>
                <!-- <select class="form-select me-3" style="width: 5rem;" name="quantity">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select> -->
                <button class="btn btn-primary btn-shadow d-block w-100" type="submit">
                  <i class="ci-cart fs-lg me-2"></i>Add to Cart
                </button>
              </div>
            </form>
            
            @endif
            <!--------Temporary Product Description-->
            <div class="p-4">
              {{ $product->description }}
            </div>
            <!--------Temporary Product Description end-->
            <!-- Product panels-->
            {{--<div class="accordion mb-4" id="productPanels">
              <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button" href="#productInfo" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="productInfo"><i class="ci-announcement text-muted fs-lg align-middle mt-n1 me-2"></i>Product info</a></h3>
                <div class="accordion-collapse collapse show" id="productInfo" data-bs-parent="#productPanels">
                  <div class="accordion-body">
                    <h6 class="fs-sm mb-2">Composition</h6>
                    <ul class="fs-sm ps-4">
                      <li>Elastic rib: Cotton 95%, Elastane 5%</li>
                      <li>Lining: Cotton 100%</li>
                      <li>Cotton 80%, Polyester 20%</li>
                    </ul>
                    <h6 class="fs-sm mb-2">Art. No.</h6>
                    <ul class="fs-sm ps-4 mb-0">
                      <li>183260098</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button collapsed" href="#shippingOptions" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="shippingOptions"><i class="ci-delivery text-muted lead align-middle mt-n1 me-2"></i>Shipping options</a></h3>
                <div class="accordion-collapse collapse" id="shippingOptions" data-bs-parent="#productPanels">
                  <div class="accordion-body fs-sm">
                    <div class="d-flex justify-content-between border-bottom pb-2">
                      <div>
                        <div class="fw-semibold text-dark">Courier</div>
                        <div class="fs-sm text-muted">2 - 4 days</div>
                      </div>
                      <div>$26.50</div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                      <div>
                        <div class="fw-semibold text-dark">Local shipping</div>
                        <div class="fs-sm text-muted">up to one week</div>
                      </div>
                      <div>$10.00</div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                      <div>
                        <div class="fw-semibold text-dark">Flat rate</div>
                        <div class="fs-sm text-muted">5 - 7 days</div>
                      </div>
                      <div>$33.85</div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                      <div>
                        <div class="fw-semibold text-dark">UPS ground shipping</div>
                        <div class="fs-sm text-muted">4 - 6 days</div>
                      </div>
                      <div>$18.00</div>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                      <div>
                        <div class="fw-semibold text-dark">Local pickup from store</div>
                        <div class="fs-sm text-muted">&mdash;</div>
                      </div>
                      <div>$0.00</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button collapsed" href="#localStore" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="localStore"><i class="ci-location text-muted fs-lg align-middle mt-n1 me-2"></i>Find in local store</a></h3>
                <div class="accordion-collapse collapse" id="localStore" data-bs-parent="#productPanels">
                  <div class="accordion-body">
                    <select class="form-select">
                      <option value>Select your country</option>
                      <option value="Argentina">Argentina</option>
                      <option value="Belgium">Belgium</option>
                      <option value="France">France</option>
                      <option value="Germany">Germany</option>
                      <option value="Spain">Spain</option>
                      <option value="UK">United Kingdom</option>
                      <option value="USA">USA</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- Sharing-->
            <label class="form-label d-inline-block align-middle my-2 me-3">Share:</label>
            <a class="btn-share btn-twitter me-2 my-2" href="#">
              <i class="ci-twitter"></i>Twitter
            </a>
            <a class="btn-share btn-instagram me-2 my-2" href="#">
              <i class="ci-instagram"></i>Instagram
            </a>
            <a class="btn-share btn-facebook my-2" href="#">
              <i class="ci-facebook"></i>Facebook
            </a>--}}
          </div>
        </div>
      </div>
    </div>
  </div>
  {{--<!-- Product description section 1-->
  <div class="row align-items-center py-md-3">
    <div class="col-lg-5 col-md-6 offset-lg-1 order-md-2"><img class="d-block rounded-3" src="img/shop/single/prod-img.jpg')}}" alt="Image"></div>
    <div class="col-lg-4 col-md-6 offset-lg-1 py-4 order-md-1">
      <h2 class="h3 mb-4 pb-2">High quality materials</h2>
      <h6 class="fs-base mb-3">Soft cotton blend</h6>
      <p class="fs-sm text-muted pb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit.</p>
      <h6 class="fs-base mb-3">Washing instructions</h6>
      <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><a class="nav-link active" href="#wash" data-bs-toggle="tab" role="tab"><i class="ci-wash fs-xl"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#bleach" data-bs-toggle="tab" role="tab"><i class="ci-bleach fs-xl"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#hand-wash" data-bs-toggle="tab" role="tab"><i class="ci-hand-wash fs-xl"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#ironing" data-bs-toggle="tab" role="tab"><i class="ci-ironing fs-xl"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#dry-clean" data-bs-toggle="tab" role="tab"><i class="ci-dry-clean fs-xl"></i></a></li>
      </ul>
      <div class="tab-content text-muted fs-sm">
        <div class="tab-pane fade show active" id="wash" role="tabpanel">30° mild machine washing</div>
        <div class="tab-pane fade" id="bleach" role="tabpanel">Do not use any bleach</div>
        <div class="tab-pane fade" id="hand-wash" role="tabpanel">Hand wash normal (30°)</div>
        <div class="tab-pane fade" id="ironing" role="tabpanel">Low temperature ironing</div>
        <div class="tab-pane fade" id="dry-clean" role="tabpanel">Do not dry clean</div>
      </div>
    </div>
  </div>
  <!-- Product description section 2-->
  <div class="row align-items-center py-4 py-lg-5">
    <div class="col-lg-5 col-md-6 offset-lg-1"><img class="d-block rounded-3" src="img/shop/single/prod-map.png" alt="Map"></div>
    <div class="col-lg-4 col-md-6 offset-lg-1 py-4">
      <h2 class="h3 mb-4 pb-2">Where is it made?</h2>
      <h6 class="fs-base mb-3">Apparel Manufacturer, Ltd.</h6>
      <p class="fs-sm text-muted pb-2">​Sam Tower, 6 Road No 32, Dhaka 1875, Bangladesh</p>
      <div class="d-flex mb-2">
        <div class="me-4 pe-2 text-center">
          <h4 class="h2 text-accent mb-1">3258</h4>
          <p>Workers</p>
        </div>
        <div class="me-4 pe-2 text-center">
          <h4 class="h2 text-accent mb-1">43%</h4>
          <p>Female</p>
        </div>
        <div class="text-center">
          <h4 class="h2 text-accent mb-1">57%</h4>
          <p>Male</p>
        </div>
      </div>
      <h6 class="fs-base mb-3">Factory information</h6>
      <p class="fs-sm text-muted pb-md-2">​Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
    </div>
  </div>--}}
</div>
<!-- Reviews-->
{{--<div class="border-top border-bottom my-lg-3 py-5">
  <div class="container pt-md-2" id="reviews">
    <div class="row pb-3">
      <div class="col-lg-4 col-md-5">
        <h2 class="h3 mb-4">74 Reviews</h2>
        <div class="star-rating me-2"><i class="ci-star-filled fs-sm text-accent me-1"></i><i class="ci-star-filled fs-sm text-accent me-1"></i><i class="ci-star-filled fs-sm text-accent me-1"></i><i class="ci-star-filled fs-sm text-accent me-1"></i><i class="ci-star fs-sm text-muted me-1"></i></div><span class="d-inline-block align-middle">4.1 Overall rating</span>
        <p class="pt-3 fs-sm text-muted">58 out of 74 (77%)<br>Customers recommended this product</p>
      </div>
      <div class="col-lg-8 col-md-7">
        <div class="d-flex align-items-center mb-2">
          <div class="text-nowrap me-3"><span class="d-inline-block align-middle text-muted">5</span><i class="ci-star-filled fs-xs ms-1"></i></div>
          <div class="w-100">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div><span class="text-muted ms-3">43</span>
        </div>
        <div class="d-flex align-items-center mb-2">
          <div class="text-nowrap me-3"><span class="d-inline-block align-middle text-muted">4</span><i class="ci-star-filled fs-xs ms-1"></i></div>
          <div class="w-100">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar" role="progressbar" style="width: 27%; background-color: #a7e453;" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div><span class="text-muted ms-3">16</span>
        </div>
        <div class="d-flex align-items-center mb-2">
          <div class="text-nowrap me-3"><span class="d-inline-block align-middle text-muted">3</span><i class="ci-star-filled fs-xs ms-1"></i></div>
          <div class="w-100">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar" role="progressbar" style="width: 17%; background-color: #ffda75;" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div><span class="text-muted ms-3">9</span>
        </div>
        <div class="d-flex align-items-center mb-2">
          <div class="text-nowrap me-3"><span class="d-inline-block align-middle text-muted">2</span><i class="ci-star-filled fs-xs ms-1"></i></div>
          <div class="w-100">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar" role="progressbar" style="width: 9%; background-color: #fea569;" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div><span class="text-muted ms-3">4</span>
        </div>
        <div class="d-flex align-items-center">
          <div class="text-nowrap me-3"><span class="d-inline-block align-middle text-muted">1</span><i class="ci-star-filled fs-xs ms-1"></i></div>
          <div class="w-100">
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-danger" role="progressbar" style="width: 4%;" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div><span class="text-muted ms-3">2</span>
        </div>
      </div>
    </div>
    <hr class="mt-4 mb-3">
    <div class="row pt-4">
      <!-- Reviews list-->
      <div class="col-md-7">
        <div class="d-flex justify-content-end pb-4">
          <div class="d-flex align-items-center flex-nowrap">
            <label class="fs-sm text-muted text-nowrap me-2 d-none d-sm-block" for="sort-reviews">Sort by:</label>
            <select class="form-select form-select-sm" id="sort-reviews">
              <option>Newest</option>
              <option>Oldest</option>
              <option>Popular</option>
              <option>High rating</option>
              <option>Low rating</option>
            </select>
          </div>
        </div>
        <!-- Review-->
        <div class="product-review pb-4 mb-4 border-bottom">
          <div class="d-flex mb-3">
            <div class="d-flex align-items-center me-4 pe-2"><img class="rounded-circle" src="img/shop/reviews/01.jpg')}}" width="50" alt="Rafael Marquez">
              <div class="ps-3">
                <h6 class="fs-sm mb-0">Rafael Marquez</h6><span class="fs-ms text-muted">June 28, 2019</span>
              </div>
            </div>
            <div>
              <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star"></i>
              </div>
              <div class="fs-ms text-muted">83% of users found this review helpful</div>
            </div>
          </div>
          <p class="fs-md mb-2">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est...</p>
          <ul class="list-unstyled fs-ms pt-1">
            <li class="mb-1"><span class="fw-medium">Pros:&nbsp;</span>Consequuntur magni, voluptatem sequi, tempora</li>
            <li class="mb-1"><span class="fw-medium">Cons:&nbsp;</span>Architecto beatae, quis autem</li>
          </ul>
          <div class="text-nowrap">
            <button class="btn-like" type="button">15</button>
            <button class="btn-dislike" type="button">3</button>
          </div>
        </div>
        <!-- Review-->
        <div class="product-review pb-4 mb-4 border-bottom">
          <div class="d-flex mb-3">
            <div class="d-flex align-items-center me-4 pe-2"><img class="rounded-circle" src="img/shop/reviews/02.jpg')}}" width="50" alt="Barbara Palson">
              <div class="ps-3">
                <h6 class="fs-sm mb-0">Barbara Palson</h6><span class="fs-ms text-muted">May 17, 2019</span>
              </div>
            </div>
            <div>
              <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
              </div>
              <div class="fs-ms text-muted">99% of users found this review helpful</div>
            </div>
          </div>
          <p class="fs-md mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          <ul class="list-unstyled fs-ms pt-1">
            <li class="mb-1"><span class="fw-medium">Pros:&nbsp;</span>Consequuntur magni, voluptatem sequi, tempora</li>
            <li class="mb-1"><span class="fw-medium">Cons:&nbsp;</span>Architecto beatae, quis autem</li>
          </ul>
          <div class="text-nowrap">
            <button class="btn-like" type="button">34</button>
            <button class="btn-dislike" type="button">1</button>
          </div>
        </div>
        <!-- Review-->
        <div class="product-review pb-4 mb-4 border-bottom">
          <div class="d-flex mb-3">
            <div class="d-flex align-items-center me-4 pe-2"><img class="rounded-circle" src="img/shop/reviews/03.jpg')}}" width="50" alt="Daniel Adams">
              <div class="ps-3">
                <h6 class="fs-sm mb-0">Daniel Adams</h6><span class="fs-ms text-muted">May 8, 2019</span>
              </div>
            </div>
            <div>
              <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star"></i><i class="star-rating-icon ci-star"></i>
              </div>
              <div class="fs-ms text-muted">75% of users found this review helpful</div>
            </div>
          </div>
          <p class="fs-md mb-2">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem.</p>
          <ul class="list-unstyled fs-ms pt-1">
            <li class="mb-1"><span class="fw-medium">Pros:&nbsp;</span>Consequuntur magni, voluptatem sequi</li>
            <li class="mb-1"><span class="fw-medium">Cons:&nbsp;</span>Architecto beatae,  quis autem, voluptatem sequ</li>
          </ul>
          <div class="text-nowrap">
            <button class="btn-like" type="button">26</button>
            <button class="btn-dislike" type="button">9</button>
          </div>
        </div>
        <div class="text-center">
          <button class="btn btn-outline-accent" type="button"><i class="ci-reload me-2"></i>Load more reviews</button>
        </div>
      </div>
      <!-- Leave review form-->
      <div class="col-md-5 mt-2 pt-4 mt-md-0 pt-md-0">
        <div class="bg-secondary py-grid-gutter px-grid-gutter rounded-3">
          <h3 class="h4 pb-2">Write a review</h3>
          <form class="needs-validation" method="post" novalidate>
            <div class="mb-3">
              <label class="form-label" for="review-name">Your name<span class="text-danger">*</span></label>
              <input class="form-control" type="text" required id="review-name">
              <div class="invalid-feedback">Please enter your name!</div><small class="form-text text-muted">Will be displayed on the comment.</small>
            </div>
            <div class="mb-3">
              <label class="form-label" for="review-email">Your email<span class="text-danger">*</span></label>
              <input class="form-control" type="email" required id="review-email">
              <div class="invalid-feedback">Please provide valid email address!</div><small class="form-text text-muted">Authentication only - we won't spam you.</small>
            </div>
            <div class="mb-3">
              <label class="form-label" for="review-rating">Rating<span class="text-danger">*</span></label>
              <select class="form-select" required id="review-rating">
                <option value="">Choose rating</option>
                <option value="5">5 stars</option>
                <option value="4">4 stars</option>
                <option value="3">3 stars</option>
                <option value="2">2 stars</option>
                <option value="1">1 star</option>
              </select>
              <div class="invalid-feedback">Please choose rating!</div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="review-text">Review<span class="text-danger">*</span></label>
              <textarea class="form-control" rows="6" required id="review-text"></textarea>
              <div class="invalid-feedback">Please write a review!</div><small class="form-text text-muted">Your review must be at least 50 characters.</small>
            </div>
            <div class="mb-3">
              <label class="form-label" for="review-pros">Pros</label>
              <textarea class="form-control" rows="2" placeholder="Separated by commas" id="review-pros"></textarea>
            </div>
            <div class="mb-3 mb-4">
              <label class="form-label" for="review-cons">Cons</label>
              <textarea class="form-control" rows="2" placeholder="Separated by commas" id="review-cons"></textarea>
            </div>
            <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Submit a Review</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>--}}
<!-- Product carousel (Style with)-->
<div class="container pt-5">
  <h2 class="h3 text-center pb-4">Relative Products</h2>
  <div class="tns-carousel tns-controls-static tns-controls-outside">
    <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: true, &quot;nav&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;768&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 30}}}">
      <!-- Product-->
      @foreach( $rel_products as $key => $p )
      <div>
        <div class="card product-card">
          <!-- <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i>
          </button> -->
          <a class="card-img-top d-block overflow-hidden" href="#">
            <img src="{{asset('/product_images/'.$p->image)}}" alt="Product">
          </a>
          <div class="card-body py-2">
            <a class="product-meta d-block fs-xs pb-1" href="#">
              @foreach($parents as $singleParent)
                @if($singleParent->id==$p->parent_category_id)
                  {{ ucwords($singleParent->name) }}
                @endif
              @endforeach
            </a>
            <h3 class="product-title fs-sm">
              <a href="#">{{ ucwords($p->name) }}</a>
            </h3>
            <div class="d-flex justify-content-between">
              <span class="h5 fw-normal text-accent">₹ {{ $p->offer_price}}
              </span>
              <del class="text-muted fs-sm me-3">₹ {{$p->mrp}}
              </del>
             
              <div class="star-rating">
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star"></i>
              </div>
            </div>
          </div>
          <div class="card-body">
            <button class="btn btn-primary btn-sm d-block w-100 mb-2" type="button"><i class="ci-cart fs-sm me-1"></i>Add to Cart</button>
            <!-- <div class="text-center"><a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal"><i class="ci-eye align-middle me-1"></i>Quick view</a></div> -->
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<!-- Product carousel (You may also like)-->
<div class="container py-5 my-md-3">
  <h2 class="h3 text-center pb-4">You may also like</h2>
  <div class="tns-carousel tns-controls-static tns-controls-outside">
    <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: true, &quot;nav&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;768&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 30}}}">
      <!-- Product-->
      
      @foreach( $more_products as $key => $p )
      <div>
        <div class="card product-card">
          <!-- <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i>
          </button> -->
          <a class="card-img-top d-block overflow-hidden" href="{{route('single', $p->id)}}">
            <img src="{{asset('/product_images/'.$p->image)}}" alt="Product">
          </a>
          <div class="card-body py-2">
            <a class="product-meta d-block fs-xs pb-1" href="{{route('single', $p->id)}}">
              @foreach($parents as $singleParent)
                @if($singleParent->id==$p->parent_category_id)
                  {{ ucwords($singleParent->name) }}
                @endif
              @endforeach
            </a>
            <h3 class="product-title fs-sm">
              <a href="#">{{ ucwords($p->name) }}</a>
            </h3>
            <div class="d-flex justify-content-between">
              <span class="h5 fw-normal text-accent">₹ {{ $p->offer_price}}
              </span>
              <del class="text-muted fs-sm me-3">₹ {{$p->mrp}}
              </del>
             
              <div class="star-rating">
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star-filled active"></i>
                <i class="star-rating-icon ci-star"></i>
              </div>
            </div>
          </div>
          <div class="card-body">
            <button class="btn btn-primary btn-sm d-block w-100 mb-2" type="button"><i class="ci-cart fs-sm me-1"></i>Add to Cart</button>
            <!-- <div class="text-center"><a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal"><i class="ci-eye align-middle me-1"></i>Quick view</a></div> -->
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</div>
</main>

@endsection