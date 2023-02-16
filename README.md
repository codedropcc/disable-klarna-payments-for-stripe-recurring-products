# Disable Klarna For Stripe Recurring Products

Fix the issue like  
`Order line totals do not total order_amount - XXXX != YYYY`

When you've installed [Klarna](https://marketplace.magento.com/klarna-m2-klarna.html) and [Stripe Payments](https://marketplace.magento.com/stripe-stripe-payments.html) and enabled recurring products with initial fee you'll face a problem on checkout page what looks like `Order line totals do not total order_amount - XXXX != YYYY`.

This extension will disable Klarna payments when customer cart(basket) have product with stripe recurring product.

Tested on Magento CE 2.4.2  
Required PHP ^7.4

Installation:  
```
composer require codedropcc/disable-klarna-for-stripe-recurring-products
```
