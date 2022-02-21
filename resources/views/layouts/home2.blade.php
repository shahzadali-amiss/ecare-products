<!DOCTYPE html>
<html dir="ltr" lang="en">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>MAHIR BHARAT</title>
        <base />
        <meta name="description" content="My Store" />
        <script src="{{asset('catalog/view/javascript/jquery/jquery-2.1.1.min.js')}}"></script>
        <link href="{{asset('catalog/view/javascript/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
        <script src="{{asset('catalog/view/javascript/bootstrap/js/bootstrap.min.js')}}"></script>
        <link href="{{asset('catalog/view/javascript/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&amp;display=swap" rel="stylesheet" /> 

        <script src="{{asset('catalog/view/javascript/mahardhi/jquery.elevateZoom.min.js')}}"></script>
        <script src="{{asset('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('catalog/view/javascript/mahardhi/owl.carousel.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('catalog/view/javascript/mahardhi/quickview.js')}}"></script>
        <link href="{{asset('catalog/view/theme/mahardhi/stylesheet/mahardhi/mahardhi-font.css')}}" rel="stylesheet" />
        <link href="{{asset('catalog/view/theme/mahardhi/stylesheet/mahardhi/animate.min.css')}}" rel="stylesheet" />
        <link href="{{asset('catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.carousel.min.css')}}" rel="stylesheet" />
        <link href="{{asset('catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.theme.default.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{asset('catalog/view/javascript/jquery/magnific/magnific-popup.css')}}" />

        <script type="text/javascript" src="{{asset('catalog/view/javascript/mahardhi/slick.js')}}"></script>
        <link href="{{asset('catalog/view/theme/mahardhi/stylesheet/mahardhi/slick.css')}}" rel="stylesheet" />

        <script src="{{asset('catalog/view/javascript/mahardhi/mahardhi_search.js')}}"></script>
        <style>
            :root {
                --primary-color: #222222;
                --primary-hover-color: #ff1515;
                --secondary-color: #ffffff;
                --secondary-light-color: #777777;
                --background-color: #f7f7f7;
                --border-color: #e5e5e5;
            }
        </style>
        <link href="{{asset('catalog/view/theme/mahardhi/stylesheet/stylesheet.css')}}" rel="stylesheet" />
        <link href="{{asset('catalog/view/javascript/jquery/swiper/css/swiper.min.css')}}" type="text/css" rel="stylesheet" media="screen" />
        <link href="{{asset('catalog/view/javascript/jquery/swiper/css/opencart.css')}}" type="text/css" rel="stylesheet" media="screen" />
        <script src="{{asset('catalog/view/javascript/jquery/swiper/js/swiper.jquery.min.js')}}"></script>
        <script src="{{asset('catalog/view/javascript/mahardhi/tabs.js')}}"></script>
        <script src="{{asset('catalog/view/javascript/mahardhi/jquery.cookie.js')}}"></script>
        <script src="{{asset('catalog/view/javascript/common.js')}}"></script>
        <script src="{{asset('catalog/view/javascript/mahardhi/jquery-ui.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('catalog/view/theme/mahardhi/stylesheet/mahardhi/jquery-ui.min.css')}}" />
        <script src="{{asset('catalog/view/javascript/mahardhi/custom.js')}}"></script>
        <link href="{{asset('image/catalog/cart.png')}}" rel="icon" />

        <style type="text/css">
            }
        	#top {
						margin-bottom: 45px;
					}

					ul#collection_cities li span {
					    display: block;
					    /*font-weight: bold;*/
					    font-size: 15px;
					}
					ul#collection_cities li {
					    float: left;
					    list-style: none;
					    width: 20%;
					    text-align: center;
					    height: 160px;
					}
					section#collection_cities {
					    background: #fff;
					    padding: 0px;
					}
                    .newsletter-wrap {
                        background: url(images/banner22.jpg);
                        background-size: 50% 101%;
                        background-position: 0 -2px;
                    }
                    section#collection_cities .left_col {
                        float: left;
                        width: 50%;
                        height: 100%;
                        /*background: #052c3b;*/
                    }
                    ul#collection_cities li img {
                        width: 50%;
                        height: 77px;
                    }
                    section#collection_cities .right_col {
                        float: left;
                        width: 50%;
                    }
                    section#collection_cities .container {
                        padding: 0;
                        margin: 0;
                        width: auto;
                    }
                    ul#collection_cities li img {
                        width: 50%;
                    }
                    .loader {
                        display: none !important;
                    }
        </style>

        <link rel="stylesheet" href="css/map_custom.css">
    </head>
    <body class="common-home">
        <div class="loader"></div>
        @include('inc.nav-without-login')
        
        @yield('content')
        
        @include('inc.home-footer')
        <!-- top scroll -->
        <a href="#" class="scrollToTop back-to-top" data-toggle="tooltip" title="Top"><i class="fa fa-angle-up"></i></a>
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/map_scripts.js')}}"></script>
    </body>
</html>