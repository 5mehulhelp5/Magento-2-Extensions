# [Magexperts](https://magexperts.com/) [Rocket JavaScript Extension for Magento 2](https://magexperts.com/rocket-javascript-deferred-javascript)


[![Total Downloads](https://poser.pugx.org/magexperts/module-rocketjavascript/downloads)](https://packagist.org/packages/magexperts/module-rocketjavascript)
[![Latest Stable Version](https://poser.pugx.org/magexperts/module-rocketjavascript/v/stable)](https://packagist.org/packages/magexperts/module-rocketjavascript)


<a href="https://savelife.in.ua/en/donate-en/#donate-army-card-monthly"><img width="830" height="208" src="https://cm.magexperts.com/blog/support-ukraine.png"></a>

<img width="150" height="100" src="https://magexperts.com/media/wysiwyg/made_in_ukraine.jpg">

## Magento2 Footer JavaScript
## Magento2 Deferred JavaScript
## Magento2 Optimized Bundle JavaScript


<a href="https://magexperts.com/rocket-javascript-deferred-javascript"><img width="190" height="70" src="https://cm.magexperts.com/wysiwyg/products/download-magexperts-extensions.png"></a>
  
## Configuration
  * To enable or disable extension please navigate to Magento 2 Admin Panel > Stores > Magexperts Extensions > Rocket JavaScript

## Requirements
  * Magento Community Edition 2.1.x-2.4.x or Magento Enterprise Edition 2.1.x-2.4.x
  
## Installation
* [Install Rocket JavaScript Extension for Magento 2 via Composer or anarchive](https://magexperts.com/blog/rocket-javascript-installation)

## Get List Of Used JS On A Sigle Page
```
/* Use in browser console */
globalSrc = '';
jQuery('script').each(function(){
if (!jQuery(this).attr('src')) return;
var src = jQuery(this).attr('src');
if (src.indexOf(require.toUrl('')) != -1 && src.indexOf('Magexperts_LazyLoad') == -1) {
var src = (src.replace(require.toUrl(''), ''));
globalSrc += "\n" + src;
}
})
console.log(globalSrc);

```
## Demo

Try out our open demo and if you like our extension **please give us some star on Github ★**
<table>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        Storefront Demo
      </td>
      <td align="center" valign="middle">
        Admin Panel Demo
      </td align="center" valign="middle">
    </tr>
    <tr>
      <td align="center" valign="middle">
        <a href="https://opt.demo.magexperts.top/">
          <img
            src="https://magexperts.com/static/version1520969775/frontend/Magexperts/new/en_US/images/product-tab-demo-1.jpg"
            alt="Magneto 2 Rocket JavaScript Extension Storefront Demo"
            height="220"
          >
        </a>
      </td>
      <td align="center" valign="middle">
        <a href="https://opt.demo.magexperts.top/admin/admin/">
          <img
            src="https://magexperts.com/static/version1520969775/frontend/Magexperts/new/en_US/images/product-tab-demo-2.jpg"
            alt="Magneto 2 Rocket JavaScript Extension Admin Panel Demo"
            height="220"
          >
        </a>
      </td>
    </tr>
    <tr>
      <td align="center" valign="middle">
        <a href="https://opt.demo.magexperts.top/">
          view
        </a>
      </td>
      <td align="center" valign="middle">
        <a href="https://opt.demo.magexperts.top/admin/admin/">
          view
        </a>
      </td>
    </tr>
  </tbody>
</table>

## Support
If you have any issues, please [contact us](mailto:support@magexperts.com)
then if you still need help, open a bug report in GitHub's
[issue tracker](https://github.com/magexperts/module-rocketjavascript/issues).

Please do not use Magento Marketplace's Reviews or (especially) the Q&A for support.
There isn't a way for us to reply to reviews and the Q&A moderation is very slow.

## License
The code is licensed under [Open Software License ("OSL") v. 3.0](http://opensource.org/licenses/osl-3.0.php).

## [Magento 2 Extensions](https://magexperts.com/magento-2-extensions) by Magexperts
### [Magento 2 Admin Panel Extensions](https://magexperts.com/magento-2-extensions/admin-extensions)
  * [Magento 2 Automatic Related Products](https://magexperts.com/magento-2-automatic-related-products)
  * [Magento 2 Automatic Related Products Plus](https://magexperts.com/magento-2-automatic-related-products/pricing)
  * [Magento 2 Edit Order Extension](https://magexperts.com/magento-2-edit-order-extension)
  * [Magento 2 Better Order Grid Extension](https://magexperts.com/magento-2-better-order-grid-extension)
  * [Magento 2 Product Tabs Extension](https://magexperts.com/magento-2/extensions/product-tabs)
  * [Magento 2 Extended Product Grid](https://magexperts.com/magento-2-product-grid-inline-editor)
  * [Magento 2 Google Shopping Feed](https://magexperts.com/magento-2-google-shopping-feed-extension)
  * [Magento 2 Google Tag Manager](https://magexperts.com/magento-2-google-tag-manager)
  * [Magento 2 Admin View Extension](https://magexperts.com/magento-2-admin-view-extension)
  * [Magento 2 Zero Downtime Deployment](https://magexperts.com/blog/magento-2-zero-downtime-deployment)
  * [Magento 2 Admin Email Notifications](https://magexperts.com/magento-2-admin-email-notifications)
  * [Magento 2 Dynamic Categories](https://magexperts.com/magento-2-dynamic-categories)
  * [Magento 2 Convert Guest to Customer Extension](https://magexperts.com/magento2-convert-guest-to-customer)
  * [Magento 2 Conflict Detector Extension](https://magexperts.com/magento2-conflict-detector)
  * [Magento 2 Login As Customer Extension](https://magexperts.com/login-as-customer-magento-2-extension)
  * [Magento 2 Mautic Integration Extension](https://magexperts.com/magento-2-mautic-extension)
  * [Magento 2 CMS Display Rules Extension](https://magexperts.com/magento-2-cms-display-rules-extension)
  * [Magento 2 Zendesk Chat Extension](https://magexperts.com/magento-2-zendesk-chat-extension)
  * [Magento 2 YouTube Widget Extension](https://magexperts.com/magento2-youtube-extension)
  * [Magento 2 CLI Extension](https://magexperts.com/magento2-cli-extension)
  * [Magento 2 Facebook Pixel Extension](https://magexperts.com/magento-2-facebook-pixel-extension)
  * [Magento 2 Price History](https://magexperts.com/magento-2-price-history)
  * [Magento 2 Google Customer Reviews](https://magexperts.com/magento-2-google-customer-reviews)
  * [Magento 2 Email Attachments](https://magexperts.com/magento-2-email-attachments)
    
### [Magento 2 Blog Extensions](https://magexperts.com/magento-2-extensions/blog-extensions)

  * [Magento 2 Blog Extension](https://magexperts.com/magento2-blog-extension)
  * [Magento 2 Blog Plus Extension](https://magexperts.com/magento2-blog-extension/pricing)
  * [Magento 2 Blog Extra Extension](https://magexperts.com/magento2-blog-extension/pricing)
  * [Magento 2 Multi Blog Extension](https://magexperts.com/magento-2-multi-blog-extension)
  * [Magento 2 AMP Blog Extension](https://magexperts.com/magento-2-amp-blog-extension)
  * [Magento 2 Product Widget Advanced Extension](https://magexperts.com/magento-2-product-widget)


### [Magento 2 SEO Extensions](https://magexperts.com/magento-2-extensions/magento-2-seo-extensions)

  * [Magento 2 SEO Extension](https://magexperts.com/magento-2-seo-extension)
  * [Magento 2 Rich Snippets Extension](https://magexperts.com/magento-2-rich-snippets)
  * [Magento 2 HTML Sitemap Extension](https://magexperts.com/magento-2-html-sitemap-extension)
  * [Magento 2 XML Sitemap Extension](https://magexperts.com/magento-2-xml-sitemap-extension)
  * [Magento 2 SEO Suite Ultimate Extension](https://magexperts.com/magento-2-seo-suite-ultimate-extension)
  * [Magento 2 Twitter Cards Extension](https://magexperts.com/magento-2-twitter-cards-extension)
  * [Magento 2 Facebook Open Graph Extension](https://magexperts.com/magento-2-open-graph-extension-og-tags)
  * [Magento 2 Hreflang Tags Extension](https://magexperts.com/magento2-alternate-hreflang-extension)
  * [Magento 2 Google Analytics 4 Extension](https://magexperts.com/magento-2-google-analytics-4)

### [Magento 2 Cart Extensions](https://magexperts.com/magento-2-extensions/cart-extensions)

  * [Better Magento 2 Checkout Extension](https://magexperts.com/better-magento-2-checkout-extension)
  * [Magento 2 Coupon Code Link](https://magexperts.com/magento-2-coupon-code-link)

### [Magento 2 Speed Optimization Extensions](https://magexperts.com/magento-2-extensions/speed-optimization-extensions)

  * [Magento 2 Lazy Load Extension](https://magexperts.com/magento-2-image-lazy-load-extension)
  * [Magento 2 WebP Optimized Images Extension](https://magexperts.com/magento-2-webp-optimized-images)

### [Magento 2 Multi-Language Extensions](https://magexperts.com/magento-2-extensions/multi-language-extensions)

  * [Magento 2 Auto Currency Switcher Extension](https://magexperts.com/magento-2-currency-switcher-auto-currency-by-country)
  * [Magento 2 Auto Language Switcher Extension](https://magexperts.com/magento-2-auto-language-switcher)
  * [Magento 2 GeoIP Switcher Extension](https://magexperts.com/magento-2-geoip-switcher-extension)
  * [Magento 2 Translation Extension](https://magexperts.com/magento-2-translation-extension)
  * [Magento 2 Translation Plus Extension](https://magexperts.com/magento-2-translation-extension/pricing)

  ### Magento 2 Point of Sale
  * [Magento 2 POS System](https://magexperts.com/magento-pos-system)
  
  ### Shopware Extensions
  * [Shopware WebP Extension](https://magexperts.com/shopware/extensions/webp)
  * [Shopware Blog Extension](https://magexperts.com/shopware/extensions/blog)
   
  ### Shopify Apps
  * [Shopify Login As Customer](https://apps.shopify.com/login-as-customer)
  * [Shopify Blog](https://apps.shopify.com/magexperts-blog)
  
  ### Magento 2 Theme
  * [Optimized Magento 2 Theme](https://magexperts.com/optimized-magento-2-theme)
