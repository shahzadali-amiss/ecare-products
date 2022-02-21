<footer class="mt-80">
            <div class="container">
                <div class="row">
                    <div class="footer-top">
                        <div class="col-sm-4">
                            <div class="position-footer-left">
                                <div class="news">
                                    <div class="newsletterblock">
                                        <div class="newsletter-form block-content">
                                            <div class="news-info">
                                                <div class="news-dec">
                                                    <div class="title-text">Subscribe Newsletter</div>
                                                    <div class="news-description">Subscribe to our newsletters now and stay up to date with new collections and exclusive offers.</div>
                                                </div>
                                            </div>
                                            <!-- newsletter box -->
                                            <form name="frmnewsletter" id="frmnewsletter" onsubmit="subscribe();return false" method="post">
                                                <div class="subscribe-form">
                                                    <i class="icon-mail"></i>
                                                    <input type="email" name="newsletter_usr_email" id="newsletter_usr_email" placeholder="Enter your email..." class="form-control input-lg inputNew txtemail" required />
                                                    <button type="submit" class="subscribe-btn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                                </div>
                                                <!-- newsletter notofication -->
                                                <div class="newsletter-message"></div>
                                                <!-- newsletter notofication -->
                                            </form>
                                            <!-- newsletter box -->
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    <!--
                                    //add
                                    function subscribe(){
                                    	$.ajax({
                                    		type: 'post',
                                    		url: 'index.php?route=extension/module/mahardhi_newsletter/subscribe',
                                    		dataType: 'html',
                                    		data:$("#frmnewsletter").serialize(),
                                    		success: function (html) {
                                    			try {
                                    				eval(html);
                                    			}
                                    			catch (e) {
                                    			}
                                    		}
                                    	});
                                    }

                                    // check for validation
                                    $(document).ready(function() {
                                    	$('#newsletter_usr_email').keypress(function(e) {
                                    		if(e.which == 13) {
                                    			e.preventDefault();
                                    			subscribe();
                                    		}
                                    	});
                                    });
                                    //-->
                                </script>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="footer-content">
                                <h5>Information</h5>
                                <ul class="list-unstyled">
                                    <li><a href="index8816.html?route=information/information&amp;information_id=4">About Us</a></li>
                                    <li><a href="index1766.html?route=information/information&amp;information_id=6">Delivery Information</a></li>
                                    <li><a href="index1679.html?route=information/information&amp;information_id=3">Privacy Policy</a></li>
                                    <li><a href="index99e4.html?route=information/information&amp;information_id=5">Terms &amp; Conditions</a></li>
                                    <li><a href="index2724.html?route=information/contact">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="footer-content">
                                <h5>My Account</h5>
                                <ul class="list-unstyled">
                                    <li><a href="indexe223.html?route=account/account">My Account</a></li>
                                    <li><a href="indexe223.html?route=account/order">Order History</a></li>
                                    <li><a href="indexe223.html?route=account/wishlist">Wish List</a></li>
                                    <li><a href="indexe223.html?route=account/newsletter">Newsletter</a></li>
                                    <li><a href="index71ba.html?route=account/return/add">Returns</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="position-footer-right">
                                <h5 class="toggled title">contact info</h5>
                                <ul class="list-unstyled">
                                    <li>
                                        <div class="site">
                                            <div class="contact_title">address:</div>
                                            <div class="contact_site">A 123, New Delhi, India</div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="phone">
                                            <div class="contact_title">phone:</div>
                                            <div class="contact_site">011-2666-6666, +91-8888-999-999</div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="email">
                                            <div class="contact_title">email:</div>
                                            <div class="contact_site"><a href="mailto:info@mahirbharat.com">info@mahirbharat.com</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="container">
                    <div class="footer-bottom">
                        <p class="powered">All right reserved <a href="#">Mahir Bharat</a> &copy; 2022</p>
                        <div class="position-footer-bottom">
                            <div class="follow-link">
                                <div class="social-media">
                                    <a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-youtube-play"></i></a><a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"> <i class="fa fa-pinterest-p"></i></a>
                                </div>
                            </div>
                            <div class="payment-link"><img src="{{asset('image/catalog/payment.png')}}" alt="" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>