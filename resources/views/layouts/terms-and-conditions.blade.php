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
                                    <div class="organey-woocommerce-title">Terms and Conditions</div>
                                    <nav class="woocommerce-breadcrumb"><a
                                            href="{{ route('welcome') }}">Home</a><i aria-hidden="true"
                                            class="organey-icon-angle-right"></i>Terms / Conditions</nav>
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
                          TERMS AND CONDITIONS
                        </h4>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           Welcome to (“E-care”).
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-9877a20 elementor-widget-mobile__width-initial elementor-widget elementor-widget-text-editor"
                    data-id="9877a20" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Website and / or its affiliates offer website features and other products and services when you visit and shop at WEBSITE NAME. Wherever in the site, you come across terms like "we", "us" and "our" , please be informed that it refers to WEBSITE NAME. The site offers  all information, tools and services available from this site to you, the user, conditioned upon your approval of all terms, conditions, policies and notices stated here.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>By visiting our site and / or buying something from us, you submit to our "Service" and accept to be bound by the following terms and conditions ("Terms of Service", "Terms"), comprising those additional terms and conditions and policies mentioned herein and / or available by hyperlink. These Terms of Service apply to all users of the site, be it any category, such as  browsers, vendors, customers, merchants, and / or contributors of content.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Please read these Terms of Service carefully before visiting or using our website.Addition of new feature or tool on a regular basis to the website is a normal occurrence. Please be advised that any new addition to the current website will also be subject to the Terms of Service. You can review the most current version of the Terms of Service at any time on this page. We reserve the right to update, edit or replace any part of these Terms of Service by posting updates and/or changes to our website. Your continued use of or access to the website following the posting of any changes constitutes acceptance of those Changess.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>This electronic record is generated by a computer system and does not require any physical or digital signature. Notwithstanding anything contained or said in any other document, if there is a conflict between the terms mentioned herein below and any other document, the terms contained in the present T&C shall solely prevail for the purpose of usage of the Site.</p>
                    </div>
                </div>

                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 1 - GENERAL CONDITIONS
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access the Service or any contact on the website through which the service is provided. Written permission by us is mandatory for this purpose. The headings used in this agreement are included for convenience only and will not limit or otherwise affect these Terms.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 2 - ONLINE STORE TERMS
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>By agreeing to the Terms of Service, you acknowledge that you are at least the age of majority in your state or country of residence and you give us your consent to allow any of your minor dependents to use this site.</p>
                    </div>
                </div> 
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 3 - MODIFICATIONS TO THE SERVICES AND GOODS' PRICES.
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Prices for our products are subject to change without prior notice. We reserve the right that at any given time we can modify or discontinue the Service (or any part or content thereof) without notice. We shall not be answerable to you or to any third-party for any modification, price change, suspension or discontinuation of as any of our  Services.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 4 - ACCURACY OF BILLING AND ACCOUNT INFORMATION
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>In the capacity of sole deciding authority, we can limit or cancel quantities purchased per person, per household from the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. Any cancellation or modification of an order will be communicated to you by contacting you on the e-mail and/or billing address/phone number provided at the time the order was made. We reserve the right to limit or cancel orders that, in our sole judgment, appear to be placed by wholesalers, resellers or distributors.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>You agree to provide current, complete and accurate purchase and account information for all purchases made at our store. You commit to immediately update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as and when considered necessary.. For more details, please review our Returns Policy.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 5 - PERSONAL INFORMATION
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Your submission of personal information through the store is governed by our Privacy Policy.</p>
                    </div>
                </div>
                
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 6 - ERRORS, DISCREPENCIES AND OMISSIONS
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Occasionally there may be information on our site or in the Service that contains typographical errors, inaccuracies or omissions related to product descriptions, pricing, promotions, offers, product shipping charges, transit times and availability. We reserve the exclusive right to correct any errors, inaccuracies or omissions, and to change or update information or cancel orders if we are convinced of the inaccuracy of the  information provided in the Service or on any related Website .This action can be executed at any time without prior notice (including after you have submitted your order).</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 7 - PROHIBITED USES
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its content </p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <ul>
                          <li>
                            for any unlawful motive
                          </li>
                          <li>
                            to encourage others to perform or participate in any unlawful acts;
                          </li>
                          <li>to infringe upon or violate our intellectual property rights or the intellectual property rights of others;</li>
                          <li>to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability;
                          </li>
                          <li>to submit false or misleading information;</li>
                          <li>to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the smoothoperation of the Service or of any related website, other websites, or the Internet;</li>
                          <li> to collect or track the personal information of others;</li>
                          <li>to spam, phish, pharm, pretext, spider, crawl, or scrape;</li>
                          <li>for any obscene or immoral purpose; or</li>
                          <li>to interfere with or circumvent the security features of the Service or any related website for violating any of the prohibited uses.</li>
                        </ul>
                    </div>
                </div> 
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 8 - INTELLECTUAL PROPERTY RIGHTS
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Unless otherwise indicated or anything contained to the contrary or any proprietary material owned by a third party and so expressly mentioned, we own all Intellectual Property Rights to and into the Website, including, without limitation, any and all rights, title and interest in and to copyright, related rights, patents, utility models, trademarks, trade names, service marks, designs, know-how, trade secrets and inventions (whether patentable or not ), goodwill, source code, meta tags, databases, text, content, graphics, icons, and hyperlinks. You are obligated to acknowledge and agree that you shall not use, reproduce or distribute any content from the Website belonging to us without obtaining prior authorization from it.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>User shall not upload post or otherwise make available on the Site any material protected by copyright, trademark or other proprietary right without the express permission of the legal owner of the copyright, trademark or other proprietary right. NAME OF WEBSITE is not responsible or obliged to provide the users with indications, markings or anything else that may aid the user in determining whether the material in question is copyrighted or trademarked. User shall be solely liable for any damage resulting from any infringement of Copyrights, trademarks, proprietary rights or any other harm resulting from such a submission. By submitting material to any public area of the Site, user implies that the owner of such material has granted our Website the royalty-free, continuous, irrevocable, non- exclusive rights and license to use, reproduce, alter, adapt, publish, translate and circulate such material (partial or entire content) worldwide and/or to include it in other works in any form, media or technology now known or hereafter developed for the full term of any copyright that may exist in such material. User also permits any other end user to access, view, and store or reproduce the material for that end user’s personal use. User hereby grants WEBSITE NAME the right to edit, copy, publish and distribute any material made available on the Site by the User. The foregoing provisions of Section 25 apply equally to and are for the benefit of WEBSITE NAME, its subsidiaries, affiliates and its third party content providers and licensors and each shall have the right to assert and enforce such provisions directly or on its own behalf.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 9 - PRIVACY
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>We consider the protection of your privacy as our prime responsibility. We understand and agree that your personal information is one of our most important assets. We store and process your Information including any sensitive financial information collected (as defined under the Information Technology Act, 2000), if any, on computers that may be protected by physical as well as state of the art technological security measures and procedures in accordance with Information Technology Act 2000 and Rules there under. If you have any objection whatsoever to our current Privacy Policy or your information being transferred or used in this way, please do not use the Website.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 10 - BILLING
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>The price of our merchandise as mentioned on our website, is the Maximum Retail Price (MRP) for the said product. The aforesaid MRP is inclusive of all local taxes as are applicable in India. Additional applicable taxes may be levied depending upon the destination where the order has to be shipped to. The tax rate applied and charged upon the order shall include combined tax rate for both state and local tax rates in accordance with the address where the order is being shipped. THE WEBSITE reserves the right to collect taxes and / or such other levy / duty / surcharge that it may have to incur in addition to the normal taxes it may have to pay. We may also charge delivery Charges which may include postal charges / shipment charges or any other charges applicable in  the customer's country.</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 11 - SHIPPING & PROCESSING FEE
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Our shipping and processing charges are intended as compensation for the website as the expenses incurred for the purpose of  processing and delivering your order, handling and packing the products of your purchase. For further information, please refer to our Shipping & Returns Policy</p>
                    </div>
                </div>
                <div class="elementor-element elementor-element-c3b872e elementor-widget elementor-widget-heading"
                    data-id="c3b872e" data-element_type="widget"
                    data-widget_type="heading.default">
                    <div class="elementor-widget-container privacy">
                        <h6 class="elementor-heading-title elementor-size-default">
                           SECTION 12 - CONTACT INFORMATION
                        </h6>
                    </div>
                </div>
                <div class="elementor-element elementor-element-e128bd7 elementor-widget elementor-widget-text-editor"
                    data-id="e128bd7" data-element_type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        <p>Queries regarding the Terms of Service can be sent to us at E MAIL ID </p>
                    </div>
                </div>

            </main>
        </div>
        
    </div>

@endsection