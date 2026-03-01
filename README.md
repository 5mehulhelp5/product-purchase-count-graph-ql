# **Magento 2 Product Purchase Count GraphQL Extension** #

[![M2 Coding Standard](https://github.com/AttilaSagiDev/product-purchase-count-graph-ql/actions/workflows/codesniffer-actions.yml/badge.svg?branch=develop)](https://github.com/AttilaSagiDev/product-purchase-count-graph-ql/actions/workflows/codesniffer-actions.yml)

## Description ##

This extension will add GraphQL support to the Product Purchase Count Magento 2 module. Adding support to get how many unique customers bought the specific product via GraphQL Query.

## Features ##

- Adding support to receive to get how many unique customers bought the specific product via GraphQL Query

It is a separate module that does not change the default Magento files.

Support:
- Magento Community Edition 2.4.x

- Adobe Commerce 2.4.x

## Installation ##

** Important! Always install and test the extension in your development environment, and not on your live or production server. **

1. Backup your store database and the whole Magento 2 directory

2. Install Product Purchase Count Magento 2 extension. Please see:
   https://github.com/AttilaSagiDev/product-purchase-count/releases/

3. Enable extension
   Please use the following commands in your Magento 2 console:

   ```
   bin/magento module:enable Space_ProductPurchaseCountGraphQl

   bin/magento setup:upgrade 
   ```

## Change Log ##

Version 1.0.1 - Mar 1, 2026
- Add unit tests
- PHP 8.4 upgrades

Version 1.0.0 - Sep 25, 2024
- Compatibility with Magento Community Edition  2.4.x

- Compatibility with Adobe Commerce 2.4.x

## Support ##

If you have any questions about the extension, please get in touch with me.

## License ##

MIT License.
