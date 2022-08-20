<section class="elementor-section elementor-top-section elementor-element elementor-element-a79e51c elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="a79e51c" data-element_type="section" data-settings='{"stretch_section":"section-stretched"}' id="home_category_shop">
  <div class="elementor-container elementor-column-gap-no">
    
    @foreach($categories as $key => $category)
      <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-6d9706b" data-id="6d9706b" data-element_type="column" data-settings='{"background_background":"classic"}'>
        <div class="elementor-widget-wrap elementor-element-populated">
          <div class="elementor-element elementor-element-6013886 box-align-left elementor-cta--valign-top button-style-yes elementor-widget elementor-widget-organey-banner" data-id="6013886" data-element_type="widget" data-widget_type="organey-banner.default">
            <div class="elementor-widget-container">
              <div class="skeleton-body">
                <div class="elementor-cta--skin-cover elementor-cta elementor-organey-banner">
                  <div class="elementor-cta__bg-wrapper">
                    <div class="elementor-cta__bg elementor-bg" style='background-image: url("category_images/{{ $category->image }}")'></div>
                    <div class="elementor-cta__bg-overlay"></div>
                  </div>
                  <div class="elementor-cta__content">
                    <h2 class="elementor-cta__title elementor-cta__content-item elementor-content-item">{{ ucwords($category->name) }} Shop</h2>
                    <!-- <div class="elementor-cta__subtitle elementor-cta__content-item elementor-content-item">-35% Off</div> -->
                    <div class="elementor-cta__button-wrapper elementor-cta__content-item elementor-content-item ">
                      <a class="elementor-cta__button elementor-button-custom" href="" target="_blank">
                        <span>Shop Now <i aria-hidden="true" class="organey-icon-organey-icon-short-arrow-left"></i>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach

  </div>
</section>