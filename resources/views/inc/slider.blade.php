<section class="bg-secondary py-4 pt-md-5">
        <div class="container py-xl-2">
          <div class="row">
            <!-- Slider     -->
            <div class="col-xl-9 pt-xl-4 order-xl-2">
              <div class="tns-carousel">
                <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 1, &quot;controls&quot;: true, &quot;loop&quot;: false}">
                  @foreach( getPrimaryAdBanners() as $banner )
                  <div>
                    <div class="row align-items-center">
                      <div class="col-md-6 order-md-2"><img class="d-block mx-auto" src="{{asset('banner_images')}}/{{$banner->image}}" alt="{{$banner->title}}"></div>
                      <div class="col-lg-5 col-md-6 offset-lg-1 order-md-1 pt-4 pb-md-4 text-center text-md-start">
                        <h2 class="fw-light pb-1 from-bottom">{{$banner->subtitle}}</h2>
                        <h1 class="display-4 from-bottom delay-1">{{$banner->title}}</h1>
                        <h5 class="fw-light pb-3 from-bottom delay-2">{{$banner->tagline}}</h5>
                        <div class="d-table scale-up delay-4 mx-auto mx-md-0"><a class="btn btn-primary btn-shadow" href="{{$banner->link}}">{{$banner->button_title}}<i class="ci-arrow-right ms-2 me-n1"></i></a></div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!-- Banner group-->
            <div class="col-xl-3 order-xl-1 pt-4 mt-3 mt-xl-0 pt-xl-0">
              <div class="table-responsive" data-simplebar>
                <div class="d-flex d-xl-block">
                  @foreach( getSecondaryAdBanners() as $banner )
                  <a class="d-flex align-items-center bg-faded-info rounded-3 pt-2 ps-2 mb-4 me-4 me-xl-0" href="{{$banner->link}}" style="min-width: 16rem;">
                    <img src="{{asset('banner_images')}}/{{$banner->image}}" width="125" alt="Banner">
                    <div class="py-4 px-2">
                      <h5 class="mb-2 fw-light w-100 line-break">
                        {!! htmlspecialchars_decode($banner->title) !!}
                      </h5>
                      <div class="text-info fs-sm">{{$banner->button_title}}<i class="ci-arrow-right fs-xs ms-1"></i>
                      </div>
                    </div>
                  </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      @push('styles')
      <style type="text/css">
        .line-break p{
          /*white-space: normal;*/
          /*overflow-wrap: break-word;*/
        }

        .line-break p strong{
          display: inline-block;
        }

        .tns-carousel [data-controls]{
          background: none;
          border:none;
        }

        .tns-carousel [data-controls] i{
          font-size: 20px;
          font-weight: 900;
          color:#373f50;
        }
      </style>
      @endpush