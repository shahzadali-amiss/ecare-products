<section id="home_category_products" class="elementor-section elementor-top-section elementor-element elementor-element-083eee1 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="083eee1" data-element_type="section" data-settings='{"stretch_section":"section-stretched"}'>
  <div class="elementor-container elementor-column-gap-no">
    

    @foreach($categories as $key => $category)

        @if(count($category->products) > 0)
        <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-8a4e6f4" data-id="8a4e6f4" data-element_type="column" data-settings='{"background_background":"classic"}'>
          <div class="elementor-widget-wrap elementor-element-populated box{{$key}}" style='background-image: url("category_images/{{ $category->image }}")'>
            <div class="elementor-element elementor-element-f6a7c37 elementor-widget elementor-widget-heading" data-id="f6a7c37" data-element_type="widget" data-widget_type="heading.default">
              <div class="elementor-widget-container">
                <h2 class="elementor-heading-title elementor-size-default">{{ ucwords($category->name) }}</h2>
              </div>
            </div>
            <div class="elementor-element elementor-element-660a683 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="660a683" data-element_type="widget" data-widget_type="icon-list.default">
              <div class="elementor-widget-container">
                <ul class="elementor-icon-list-items">

                    @foreach($category->products as $product)
                        <li class="elementor-icon-list-item">
                            <a href="">
                                <span class="elementor-icon-list-icon">
                                    <i aria-hidden="true" class="fas fa-circle"></i>
                                </span>
                                <span class="elementor-icon-list-text">{{ ucwords($product->name) }}</span>
                            </a>
                        </li>
                    @endforeach

                </ul>
              </div>
            </div>
          </div>
        </div>
        @endif

    @endforeach

  </div>
</section>