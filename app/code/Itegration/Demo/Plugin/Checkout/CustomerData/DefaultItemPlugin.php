<?php

namespace Itegration\Demo\Plugin\Checkout\CustomerData;

use Magento\Quote\Model\Quote\Item;

class DefaultItemPlugin
{
    /*
     * around plugin to provide short description of product to cart.
     */
    public function aroundGetItemData($subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);
        $product = $item->getProduct();

        $atts = [
            "product_shortdescription" => $product->getShortDescription()
        ];

        return array_merge($data, $atts);
    }
}
