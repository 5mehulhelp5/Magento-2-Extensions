# Better Magento 2 WYSIWYG TinyMCE4 & TinyMCE5 Editor by [Magexperts](https://magexperts.com)

<a href="https://savelife.in.ua/en/donate-en/#donate-army-card-monthly"><img width="830" height="208" src="https://cm.magexperts.com/blog/support-ukraine.png"></a>

<img width="150" height="100" src="https://magexperts.com/media/wysiwyg/made_in_ukraine.jpg">

## Overview 

[![Total Downloads](https://poser.pugx.org/magexperts/module-wysiwyg-advanced/downloads)](https://packagist.org/packages/magexperts/module-wysiwyg-advanced)
[![Latest Stable Version](https://poser.pugx.org/magexperts/module-wysiwyg-advanced/v/stable)](https://packagist.org/packages/magexperts/module-wysiwyg-advanced)

This extension allows you to extend TinyMCE 4 & 5 tools in Magento 2, e.g.: add <strong>text color</strong>, image, html code, undo-redo, styleselect, fontsizeselect, forecolor backcolor, bold, italic, underline, strikethrough, alignleft, aligncenter, alignright alignjustify, bullist, numlist, outdent, indent, table, image, code. [Read more details...](https://magexperts.com/blog/magento-2.3-tinymce-4-text-color-tool-missing)

Based on [stackexchange answer](https://magento.stackexchange.com/questions/263745/magento-2-3-tinymce4-toolbar-and-plugin-configuration#answer-263891) by [Mike Dubs](https://magento.stackexchange.com/users/77224/mike-dubs).


<div>
          <img
            src="https://magexperts.com/media/wysiwyg/Blog/TinyMCE4-magento2-v2.png"
            alt="TinyMCE 4 in Magento 2" />
</div>

## Installation
```
composer require magexperts/module-wysiwyg-advanced
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

## Enabling emoji 😋
1. Change "utf8" to "utf8mb4" for initStatements in app/etc/env.php file. Example:
```
'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
...
                'initStatements' => 'SET NAMES utf8mb4;',
...
            ]
        ]
    ],
```

2. Alter database tables and set utf8mb4 encoding. Run SQL queries:
```
# For blog posts
ALTER TABLE magexperts_blog_post CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
# For blog categories
ALTER TABLE magexperts_blog_category CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
# For blog tags
ALTER TABLE magexperts_blog_tag CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
# For products
ALTER TABLE catalog_product_entity_varchar CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
ALTER TABLE catalog_product_entity_text CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
# For categories
ALTER TABLE catalog_category_entity_varchar CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
ALTER TABLE catalog_category_entity_text CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
```


## [Magento 2 Extensions](https://magexperts.com/magento-2-extensions) by Magexperts
### [Magento 2 Admin Panel Extensions](https://magexperts.com/magento-2-extensions/admin-extensions)
  * [Magento 2 Automatic Related Products](https://magexperts.com/magento-2-automatic-related-products)
  * [Magento 2 Automatic Related Products Plus](https://magexperts.com/magento-2-automatic-related-products/pricing)
  * [Magento 2 Edit Order Extension](https://magexperts.com/magento-2-edit-order-extension)
  * [Magento 2 Better Order Grid Extension](https://magexperts.com/magento-2-better-order-grid-extension)
  * [Magento 2 Extended Product Grid](https://magexperts.com/magento-2-product-grid-inline-editor)
  * [Magento 2 Product Tabs Extension](https://magexperts.com/magento-2/extensions/product-tabs)
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
  * [Magento 2 Rocket JavaScript Extension](https://magexperts.com/rocket-javascript-deferred-javascript)

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
