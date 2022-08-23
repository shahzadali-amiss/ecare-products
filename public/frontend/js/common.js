let base_url = window.origin;
let cartItems = [];
let uid = $('#user_id').val();
let visitor_id = $('#visitor_id').val();

loadCartItems(uid);

function loadCartItems(uid){
    $.get("/api/get_cart_items", 
    {
      user_id: uid,
      visitor_id: visitor_id
    },
    function(data,status){
        if(status == 'success'){
            cartItems = data.product
            bindItemIntoCart()
        }
    });
}

$(".add-to-cart").click(function(){
    let thisElement = this;
    let qty = $(this).parent().find('.item.qty').val();
    let pid = $(this).parent().find('.item.pid').val();

    $.post(base_url+"/api/add_to_cart",
    {
      pid: pid,
      qty: qty,
      user_id: uid,
      visitor_id: visitor_id
    },
    function(data,status){
        
        if(status == 'success'){
            cartItems.push(data.product)
            bindItemIntoCart()

            $('.item_added_into_cart').fadeIn(0);
            $(thisElement).removeClass('loading')

            setTimeout(function(){
                $('.item_added_into_cart').fadeOut(500);
            }, 2000);
        }
        
    });
});

function bindItemIntoCart(){
    // console.log(cartItems)

    let cart = $('.widget_shopping_cart');
    let total = 0;
    let items = 0;
    let div = `<div class="widget_shopping_cart_content" style="opacity: 1;">
                <div class="woocommerce-mini-cart-scroll">
                    <ul class="woocommerce-mini-cart cart_list product_list_widget ">`;

    $.each( cartItems, function( key, item ) {
        items++;
        // console.log(key)
        // console.log(item)
        div += `<li class="woocommerce-mini-cart-item mini_cart_item">
                    <a href="javascript:void(0)" class="remove remove_from_cart" aria-label="Remove this item" data-cart_id="${item.id}">×</a>
                    <a href="">
                      <img width="400" height="400" src="${base_url}/product_images/${item.image}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Revslider Organey" srcset="${base_url}/product_images/${item.image}" sizes="(max-width: 400px) 100vw, 400px">${item.name}</a>
                    <span class="quantity">${item.quantity} × <span class="woocommerce-Price-amount amount">
                        <bdi>
                          <span class="woocommerce-Price-currencySymbol">&#8377;</span>${item.price} </bdi>
                      </span>
                    </span>
                  </li>`;

        total += parseInt(item.price * item.quantity);

    });

    div += `</ul>
              </div>
              <p class="woocommerce-mini-cart__total total">
                <strong>Subtotal:</strong>
                <span class="woocommerce-Price-amount amount">
                  <bdi>
                    <span class="woocommerce-Price-currencySymbol">&#8377;</span>${total}</bdi>
                </span>
              </p>
              <p class="woocommerce-mini-cart__buttons buttons">
                <a href="${base_url}/shop/cart" class="button wc-forward">View cart</a>
                <a href="${base_url}/shop/checkout" class="button checkout wc-forward">Checkout</a>
              </p>
            </div>`;

    // console.log(div);

    $('.site-header-cart.menu span.count').html(items);
    $('.site-header-cart.menu span.amount span span').html(total);

    $(cart).html(div);
}


$(document).on('click', '.remove_from_cart', function(){

    cart_id = $(this).attr('data-cart_id');

    $.post("/api/remove_from_cart",
    {
      id: cart_id,
      user_id: uid
    },
    function(data,status){
        
        if(status == 'success'){
            cartItems = data.product
            bindItemIntoCart();
        }
        
    });

    if($(this).hasClass('this_is_cart_page'))
        location.reload();
})