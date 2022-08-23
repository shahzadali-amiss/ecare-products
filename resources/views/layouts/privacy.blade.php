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
                                    <div class="organey-woocommerce-title">Privacy & Policy</div>
                                    <nav class="woocommerce-breadcrumb"><a
                                            href="{{ route('welcome') }}">Home</a><i aria-hidden="true"
                                            class="organey-icon-angle-right"></i>Privacy</nav>
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
                {{-- <div class="organey-sorting">
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
                </div> --}}
                <div class="elementor-element elementor-element-60c69b4 elementor-widget elementor-widget-heading"
                    data-id="60c69b4" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h4 class="elementor-heading-title elementor-size-default text-center mb-4">
                          UTILIZATION OF YOUR INFORMATION
                        </h4>
                    </div>
                </div>
                <div class="elementor-element elementor-element-9877a20 elementor-widget-mobile__width-initial elementor-widget elementor-widget-text-editor"
                    data-id="9877a20" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>We get access to your personal information with the help of either of the two options namely; when a purchase is done by you from our website, personal information such as your name, address and email address is shared with us and secondly as a result of your browsing our store, your computer's internet protocol (IP) address is made available to us. This further provides us with information that helps us to learn about your browser and operating system. Utilizing the personal information, we may send you emails about our store, new products and other updates.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-60c69b4 elementor-widget elementor-widget-heading"
                    data-id="60c69b4" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h4 class="elementor-heading-title elementor-size-default text-center">
                          CONSENT
                        </h4>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Granting of consent 
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>When you provide us with personal information to complete a transaction, verify your credit card, place an order, arrange for a delivery or return a purchase, we infer that you consent to our collecting the same and using it for that specific reason solely.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Disclosure 
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>We are liable to disclose your personal information if law demands to do so or in the eventuality of violation of our Terms of Service by you.</p>
                    </div>
                </div> 
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Links
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>When you click on links on our store, they may direct you away from our site. We are not legally as well as morally responsible for the privacy activities, the other sites indulge in. It is advised and encouraged that you read the privacy statements carefully of such sites.When you click on links on our store, they may direct you away from our site. We are not legally as well as morally responsible for the privacy activities, the other sites indulge in. It is advised and encouraged that you read the privacy statements carefully of such sites.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Security
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>To safeguard your personal information, we take necessary precautions and adopt stringent measures and ensure that the same is not inappropriately lost, misused, accessed, disclosed, altered or destroyed. The credit card information provided by you is encrypted using secure socket layer technology (SSL) .It is against our policy to store any debit / credit details.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Changes to this privacy policy
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>We reserve the right to modify the existent privacy policy at any time; hence it is important that you review it on a regular basis. Modifications and clarifications will take effect immediately upon their being posted on the website. In the case of material changes made to the policy, you will be notified here. This will allow you to have access to facts such as, what information we collect, how we use it, and under what circumstances, we decide to disclose it.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-60c69b4 elementor-widget elementor-widget-heading"
                    data-id="60c69b4" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h4 class="elementor-heading-title elementor-size-default text-center">
                          SHIPPING AND RETURNS
                        </h4>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Shipping
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <ul>
                          <li>Shipping is done from our Delhi office and is free within India. Once your item has been processed & dispatched it is usually delivered within the ‘Estimated arrival time’ mentioned on the product page
                          </li>
                          <li>Shipping times are to be used only for reference purpose. They are based on time from order. We do not take responsibility for delays arising due to customs clearance or payment transaction
                          </li>
                          <li>If your order has multiple products with different delivery dates, once ready, all the products are shipped collectively as one shipment.</li>
                          <li>Upon placing an order, you will receive an email acknowledgment initially. Subsequently, another email will be sent by us once we have verified your payment details and approved your order for shipping purposes. In the event of a problem in processing your order, you will receive an email elaborating upon the issue and possibly requesting further information. You will be regularly updated on the delivery status of your order via email.
                          </li>
                          <li>Please note that bharatreshma.com does not deliver to P.O. Box or Drop Box addresses. Customers are requested to provide full addresses with the postal code / zip code.</li>
                          <li>For shipping to multiple addresses please contact us at xyz@gmail.com for assistance.</li>
                          <li>We are also unable to redirect orders once your items have been dispatched. Therefore, please ensure you provide a suitable shipping address so that we can deliver as per the specified delivery times.</li>
                          <li>In case it’s an emergency please contact us at xyz@gmail.com for assistance.</li>
                        </ul>
                    </div>
                </div> 
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Returns
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>We are unable to accept returns on any products.</p>
                    </div>
                </div>

            </main>
        </div>
        
    </div>

@endsection