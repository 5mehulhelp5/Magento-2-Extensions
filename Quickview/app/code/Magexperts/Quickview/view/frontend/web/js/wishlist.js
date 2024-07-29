/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category  Magexperts
 * @package   Magexperts_Quickview
 * @author    Extension Team
 * @copyright Copyright (c) 2017-2020 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
define(
    [
        "jquery",
    ],
    function ($) {
        $(".product-addto-links .towishlist").hover(
            function (e) {
               var dataPost=$(this).attr("data-post");
                var urlWishList="wishlist\\/index\\/add";
                var urlMagexpertsWistList="bss_quickview\\/wishlist\\/add";
                dataPost=dataPost.replace(urlWishList,urlMagexpertsWistList);
                urlWishList="wishlist/index/add";
                urlMagexpertsWistList="bss_quickview/wishlist/add";
                dataPost=dataPost.replace(urlWishList,urlMagexpertsWistList);
                $(this).attr("data-post",dataPost);
            }
        );
    }
);
