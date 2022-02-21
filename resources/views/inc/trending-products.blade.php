<!-- Products grid (Trending products)-->
      <section class="container mt-5 pt-md-4">
        <!-- Heading-->
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
          <h2 class="h3 mb-0 pt-3 me-2">Trending Products</h2>
          <div class="pt-3"><a class="btn btn-outline-accent btn-sm" href="{{route('all-products')}}">More products<i class="ci-arrow-right ms-1 me-n1"></i></a></div>
        </div>
        <!-- Grid-->
        <div class="row pt-2 mx-n2">
          <!-- Product-->
          @foreach($t_products as $tps)
          <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-4">
            <div class="card product-card">
              <div class="product-card-actions d-flex align-items-center">
              </div><a class="card-img-top d-block overflow-hidden" href="{{route('single', $tps->id)}}"><img src="{{asset('/product_images/'.$tps->image)}}" alt="Product"></a>
              <div class="card-body py-2"><a class="product-meta d-block fs-xs pb-1" href="{{route('single', $tps->id)}}">{{ucwords($tps->name)}}</a>
                <h3 class="product-title fs-sm"><a href="shop-single-v2.html">@foreach($categories as $cts)
                  @if($cts->id == $tps->category_id)
                    {{ucwords($cts->name)}}
                  @endif
                @endforeach
                </a></h3>
                <div class="d-flex justify-content-between">
                  <div class="product-price"><span class="text-accent"><del class="me-2">₹{{$tps->mrp}}</del>₹{{$tps->offer_price}}</span></div>
                </div> 
              </div>
              <div class="card-body card-body-hidden">
                @php
                {{ $is_in_cart=false; }}
                @endphp
                @foreach( getCartProducts() as $value )
                  @if($value->id==$tps->id)
                    @php
                    {{ $is_in_cart=true;break; }}
                    @endphp
                  @endif
                @endforeach
                @if(!$is_in_cart)
                <form action="{{ route('addtocart') }}" method="POST" id="add-to-cart">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $tps->id }}">
                  <input type="hidden" name="quantity" value="1">
                </form>
                <button class="btn btn-primary btn-sm d-block w-100 mb-2" onclick="jQuery('#add-to-cart').submit();" type="button"><i class="ci-cart fs-sm me-1"></i>Add to Cart</button>
                @endif
                <a class="btn btn-secondary btn-sm d-block w-100 mb-2" href="{{route('single', $tps->id)}}">View details</a>
              </div>
            </div>
            <hr class="d-sm-none">
          </div>
        @endforeach

        </div>
      </section>