jQuery(function() {
    var webappdesign_height = jQuery('div[class*=webappdesign-img-').outerHeight();
    var webappdesign_width = jQuery('div[class*=webappdesign-img-').width();
    var webappdesign_height_buttons = jQuery('div[class*=webappdesign-hover-buttons-').outerHeight();
    
    jQuery('div[class*=webappdesign-details-').css({
    'min-height' : webappdesign_height - (webappdesign_height_buttons * .7),
    'width' : webappdesign_width
    });
    jQuery('body').on('touchstart', function webappdesign_touchstart(){
        jQuery('div[class*="webappdesign-product-"]').off('hover');
    });

    jQuery('div[class*="webappdesign-product-"]').hover(
        function()
        {
            productID = jQuery(this).attr('class').split(' ')[0].split('-')[2];
            show_product_details(productID, 'none', 'block');
        },
        function()
        {
            productID = jQuery(this).attr('class').split(' ')[0].split('-')[2];
            show_product_details(productID, 'block', 'none');
        }
    );

    function show_product_details(productID, display_a, display_b)
    {
        jQuery('.webappdesign-img-' + productID).css('display', display_a);
        jQuery('.webappdesign-details-' + productID).css('display', display_b);
        jQuery('.webappdesign-hover-buttons-' + productID).delay( 2000 ).css('display', display_b);

        jQuery('.post-' + productID + ' .woocommerce-loop-product__title').css('display', display_a);
        jQuery('.post-' + productID + ' .price').css('display', display_a);

        jQuery('.post-' + productID + ' > .add_to_cart_button').css('display', display_a);
    }
});