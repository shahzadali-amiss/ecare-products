<!-- Featured category (Hoodie)-->
    <?php 
      $id = 0;
    ?>
    @foreach($grands as $key =>$gc)
      <section class="container mt-5 pt-md-4">
        <div class="row">
          <!-- Banner with controls-->
          <div class="col-lg-5  {{($key%2 != 0) ? 'order-lg-2' : ''}}">
            <div class="d-flex flex-column h-100 overflow-hidden rounded-3" style="background-color: #e2e9ef;">
              <div class="d-flex justify-content-between px-grid-gutter py-grid-gutter">
                <div class="{{($key%2 != 0) ? 'order-lg-2' : ''}}">
                  <h3 class="mb-1">{{ucwords($gc->name)}}</h3><a class="fs-md" href="{{route('single', $gc->id)}}">
                    @if($key%2 != 0)
                    <i class="ci-arrow-left fs-xs align-middle me-1"></i>
                    @endif
                    Shop {{ucwords($gc->name)}}
                    @if($key%2 == 0)
                    <i class="ci-arrow-right fs-xs align-middle ms-1"></i>
                    @endif
                  </a>
                </div>
                <div class="tns-carousel-controls {{($key%2 != 0) ? 'order-lg-1' : ''}}" id="fashion{{$gc->id}}">
                  <button type="button"><i class="ci-arrow-left"></i></button>
                  <button type="button"><i class="ci-arrow-right"></i></button>
                </div>
              </div>
              <a class="d-none d-lg-block mt-auto" href="{{route('single', $gc->id)}}">
                <img class="d-block w-100" src="{{asset('category_images/')}}/{{$gc->image}}" alt="For Women">
              </a>
            </div>
          </div>
          <!-- Product grid (carousel)-->

          <div class="col-lg-7 pt-4 pt-md-0 px-0 {{($key%2 != 0) ? 'order-lg-1' : ''}}">
            <div class="tns-carousel">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;nav&quot;: false, &quot;controlsContainer&quot;: &quot;#fashion{{$gc->id}}&quot;}">
                <!-- Carousel item-->
                
                

                  <!-- <div class="row mx-n2"> -->
                  @php $j=0; @endphp
                  
                  @for($i = 0; $i < count($products); $i++)
                      @if($products[$i]->grand_category_id==$gc->id)
                      @if($j%6==0)
                      <div>
                        <div class="row mx-n2">
                      @endif
                      @php $j++; @endphp
                      <div class="col-lg-4 col-6 px-0 px-sm-2 mb-sm-4">
                        <div class="card product-card card-static p-1">
                          <!-- <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist">
                            <i class="ci-heart"></i>
                          </button> -->
                          <a class="card-img-top d-block overflow-hidden" href="{{route('single', $products[$i]->id)}}">
                            <img src="{{asset('/product_images/'.$products[$i]->image)}}" alt="Product" class="position-absolute">
                          </a>
                          <div class="product-card-content">
                            <div class="card-body py-2">
                              <a class="product-meta d-inline-block fs-xs pb-1" href="{{route('single', $products[$i]->id)}}">
                                @foreach($categories as $cts)
                                  @if($cts->id == $products[$i]->category_id)
                                    {{ucwords($cts->name)}}
                                  @endif
                                @endforeach    
                              </a>
                              
                              <h3 class="product-title fs-sm"><a href="{{route('single', $products[$i]->id)}}">{{ucwords($products[$i]->name)}}</a></h3>
                              <div class="d-flex justify-content-between">
                                <div class="product-price">
                                  <del class="text-muted">&#x20B9; {{ucwords($products[$i]->mrp)}}.
                                  </del><br>
                                  <span class="text-accent">&#x20B9; {{ucwords($products[$i]->offer_price)}}.
                                  </span>
                                </div>
                                <div class="star-rating">
                                  <i class="star-rating-icon ci-star-filled active"></i>
                                  <i class="star-rating-icon ci-star-filled active"></i>
                                  <i class="star-rating-icon ci-star-filled active"></i>
                                  <i class="star-rating-icon ci-star-filled active"></i>
                                  <i class="star-rating-icon ci-star"></i>
                                </div>  
                              </div>
                            </div>
                            <div class="row justify-content-around product-call-to-action px-3 px-lg-0">
                              @php
                              {{ $is_in_cart=false; }}
                              @endphp
                              @foreach( getCartProducts() as $value )
                                @if($value->id==$products[$i]->id)
                                  @php
                                  {{ $is_in_cart=true;break; }}
                                  @endphp
                                @endif
                              @endforeach
                              @if($is_in_cart)
                                <a class="col-12 btn btn-secondary btn-sm" href="{{route('single', $products[$i]->id)}}">
                                  <small>View details</small>
                                </a>
                              @else
                                <form class="col-12 col-md-5 px-0 me-1 mb-2 mb-md-0" action="{{ route('addtocart') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="product_id" value="{{ $products[$i]->id }}">
                                  <input type="hidden" name="quantity" value="1">
                                  @foreach(getProductAttributes($products[$i]->id) as $key => $value)
                                  <input type="hidden" name="attribute[{{strtolower($key)}}]" value="{{$value[0]->value}}">
                                  @endforeach
                                  <button class="w-100 btn btn-primary btn-sm px-2" type="submit">
                                    <small><i class="ci-cart fs-sm me-1"></i>Add to Cart</small>
                                  </button>
                                </form>
                                <a class="col-12 col-md-5 btn btn-secondary btn-sm" href="{{route('single', $products[$i]->id)}}"><small>View details</small>
                                </a>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                      @if($j%6==0 || $j==6)
                        </div>
                      </div>
                      @endif  
                      @endif
                    @endfor                   
              </div>
            </div>
          </div>
        </div>
      </section>
      
      @endforeach
      @push('scripts')
      <script type="text/javascript">
        // async function addtocart(pid, qty){
        //   const params = {
        //       productId: pid,
        //       quantity: qty
        //   };
        //   const options = {
        //       method: 'POST',
        //       body: JSON.stringify( params )  
        //   };
        //   console.log(options);
        //   fetch( '/api/home/addtocart/', options )
        //       .then( response => response.json() )
        //       .then( response => {
        //           console.log(response);
        //       } );
        // }
      </script>
      @endpush

      @push('styles')
        <style>
          .star-rating .star-rating-icon{
            font-size: 0.5rem;
          }
          @media (max-width: 560px){

            .product-price{
              font-size: 13px;
            }  
          }
        </style>
      @endpush
