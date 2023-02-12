<div align="center">

![Magento 2 FREE SEO Suite](https://i.imgur.com/d8QEHRb.png)
# Magento 2 FREE SEO Suite

</div>

<div align="center">

[![Packagist Version](https://img.shields.io/github/v/tag/MagePsycho/magento2-seo-suite?logo=packagist&sort=semver&label=packagist&style=for-the-badge)](https://packagist.org/packages/magepsycho/magento2-discountlimit)
[![Packagist Downloads](https://img.shields.io/packagist/dt/magepsycho/magento2-seosuite.svg?logo=packagist&style=for-the-badge)](https://packagist.org/packages/magepsycho/magento2-seosuite/stats)
![Supported Magento Versions](https://img.shields.io/badge/magento-%202.3_|_2.4-brightgreen.svg?logo=magento&longCache=true&style=for-the-badge)
![License](https://img.shields.io/badge/license-MIT-green?color=%23234&style=for-the-badge)

</div>

## Overview
[Magento 2 FREE SEO Suite](https://www.magepsycho.com/magento2-free-seo-suite.html) extension optimizes SEO strategies for your e-commerce store.

The default SEO settings in Magento 2 are not enough to improve your store's search visibility. With this extension, you can maximize your SEO strategies for better search engine rankings.

## Key Features
* Adds canonical URL to the homepage, CMS pages, and contact us page
* Eliminates non-canonical product URLs from `sitemap.xml`
* Offers HTML sitemap creation
* Enables SEO pagination using `rel="prev"` and `rel="next"` meta tags
* Adds "NOINDEX,NOFOLLOW" meta robots to `/customer`, `/checkout`, and `/catalogsearch` pages

## Feature Highlights

### Manage Duplicate Content
This extension helps to avoid duplicate content problems on the homepage, CMS pages, and contact us pages.  
It uses the concept of "Canonical URL" to specify the preferred version of a web page, avoiding duplicity and improving search ranking by using a `rel="canonical"` link in HTML.

The extension also removes non-preferred product URLs from "sitemap.xml" by setting a canonical version.

For example: the "/" version of the homepage will be designated as the preferred one, even among multiple variations such as

* `/index.php`
* `/cms/`
* `/cms/index`
* `/cms/index/index`
* `/home`

### HTML Sitemap

The extension offers an "HTML Sitemap" to help visitors find their way around your store. This feature will add a link to a page called "/sitemap" in the footer.

*An "HTML Sitemap" is a webpage that lists all the links on a website in an organized manner to help visitors navigate and improve the website's SEO by providing search engines with a clear structure.*

### SEO Pagination

The extension enhances paginated pages, like category pages, by adding `rel="next"` and `rel="prev"` attributes for pagination.  
Just like `rel="canonical"` helps with duplicate content, `rel="next"` and `rel="prev"` HTML link elements help identify the relationship between different URLs in a paginated series.

***Important**: The "Prev/Next" recommendation from Google Webmaster Guide is no longer applicable as of Spring 2019. (Reference: https://support.google.com/webmasters/thread/2783047?hl=en)*

### "No Index, No Follow" Meta Tag
The extension allows you to choose which pages should have the "NOINDEX,NOFOLLOW" meta robots tag.  
You can choose which pages should have the "NOINDEX,NOFOLLOW" meta robots tag.  

By default, these tags will be added to the following pages:  
* Customer pages (`/customer/*/*`)
* Cart/Checkout pages (`/checkout/*/*`)
* CMS 404 page (`/cms/noroute/index`)
* Product review page (`/review/product/list`)
* Search result pages (`/catalogsearch/*/*`)

*This can be useful for pages with duplicate or low-quality content, under construction or development, sensitive information, or thin or no content.*

## 🛠️ Installation

### 1 Using Composer (Preferred)
```
composer require magepsycho/magento2-seosuite
```

### 2 Using Modman
```
modman init
modman clone git@github.com:MagePsycho/magento2-seo-suite.git
```

### 3 Using Zip File
* Download the [Extension Zip File](https://github.com/MagePsycho/magento2-seo-suite/archive/master.zip)
* Extract & upload the files to `/path/to/magento2/app/code/MagePsycho/SeoSuite/`

After installation by either means, activate the extension with following steps

1. Enable the module
```
php bin/magento module:enable MagePsycho_SeoSuite --clear-static-content
php bin/magento setup:upgrade
```
2. Flush the store cache
```
php bin/magento cache:flush
```
3. Deploy static content - *in Production mode only*
```
rm -rf pub/static/* var/view_preprocessed/*
php bin/magento setup:static-content:deploy
```
4. Go to Admin > MARKETING > SEO Suite > Manage Settings

## Live Demo:

* [Backend Demo](http://m2default.mage-expo.com/admin_m2demo/?module=seosuite)
* [Frontend Demo](http://m2default.mage-expo.com/)

## Changelog

**Version 1.0.0 (2023-02-07)**

* Initial Release.

## Authors
- Raj KB [![Twitter Follow](https://img.shields.io/twitter/follow/rajkbnp.svg?style=social)](https://twitter.com/rajkbnp)

## Contributors

![Contributors](https://contrib.rocks/image?repo=magepsycho/magento2-seo-suite)

## To Contribute
Any contribution to the development of `Magento 2 FREE SEO Suite` is highly welcome.  
The best possibility to provide any code is to open a [pull request on GitHub](https://github.com/MagePsycho/magento2-seo-suite/pulls).

## Need Support?
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/MagePsycho/magento2-seo-suite/issues).

Please [visit our store](https://www.magepsycho.com/extensions/magento-2.html) for more FREE / paid extensions OR [contact us](https://magepsycho.com/contact) for customization / development services.
