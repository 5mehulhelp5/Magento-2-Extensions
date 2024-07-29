This Magento 2 extension optimizes SEO strategies for your e-commerce store.

The default SEO settings in Magento 2 are not enough to improve your store's search visibility. With this extension, you can maximize your SEO strategies for better search engine rankings.

Key Features
Adds canonical URL to the homepage, CMS pages, and contact us page
Eliminates non-canonical product URLs from sitemap.xml
Offers HTML sitemap creation
Enables SEO pagination using rel="prev" and rel="next" meta tags
Adds "NOINDEX,NOFOLLOW" meta robots to /customer, /checkout, and /catalogsearch pages
Feature Highlights
Manage Duplicate Content
This extension helps to avoid duplicate content problems on the homepage, CMS pages, and contact us pages.
It uses the concept of "Canonical URL" to specify the preferred version of a web page, avoiding duplicity and improving search ranking by using a rel="canonical" link in HTML.

The extension also removes non-preferred product URLs from "sitemap.xml" by setting a canonical version.

For example: the "/" version of the homepage will be designated as the preferred one, even among multiple variations such as

/index.php
/cms/
/cms/index
/cms/index/index
/home
M2 SEO Suite - Storefront - Canonical URLs

HTML Sitemap
The extension offers an "HTML Sitemap" to help visitors find their way around your store. This feature will add a link to a page called "/sitemap" in the footer.

An "HTML Sitemap" is a webpage that lists all the links on a website in an organized manner to help visitors navigate and improve the website's SEO by providing search engines with a clear structure.

M2 SEO Suite - HTML Sitemap - Admin SettingsM2 SEO Suite - HTML Sitemap - Storefront
SEO Pagination
The extension enhances paginated pages, like category pages, by adding rel="next" and rel="prev" attributes for pagination.
Just like rel="canonical" helps with duplicate content, rel="next" and rel="prev" HTML link elements help identify the relationship between different URLs in a paginated series.

M2 SEO Suite - SEO Pagination

Important: The "Prev/Next" recommendation from Google Webmaster Guide is no longer applicable as of Spring 2019. (Reference: https://support.google.com/webmasters/thread/2783047?hl=en)

"No Index, No Follow" Meta Tag
The extension allows you to choose which pages should have the "NOINDEX,NOFOLLOW" meta robots tag.
You can choose which pages should have the "NOINDEX,NOFOLLOW" meta robots tag.
By default, these tags will be added to the following pages:

Customer pages (/customer/*/*)
Cart/Checkout pages (/checkout/*/*)
CMS 404 page (/cms/noroute/index)
Product review page (/review/product/list)
Search result pages (/catalogsearch/*/*)
M2 SEO Suite - Meta Robots - Admin SettingsM2 SEO Suite - Meta Robots - Storefront
This can be useful for pages with duplicate or low-quality content, under construction or development, sensitive information, or thin or no content.