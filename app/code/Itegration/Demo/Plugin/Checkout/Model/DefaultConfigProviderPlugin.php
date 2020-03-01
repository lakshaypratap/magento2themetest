<?php
namespace Itegration\Demo\Plugin\Checkout\Model;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Model\ProductRepository as ProductRepository;

class DefaultConfigProviderPlugin extends \Magento\Framework\Model\AbstractModel
{
    /*
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /*
     * @var ProductRepository
     */
    protected $productRepository;

    public function __construct(
        CheckoutSession $checkoutSession,
        ProductRepository $productRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
    }

    /*
     * after plugin to provide short description of product to checkout.
     */
    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
        array $result
    ) {
        $items = $result['totalsData']['items'];
        foreach ($items as $index => $item) {
            $quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);
            $product = $this->productRepository->getById($quoteItem->getProduct()->getId());
            $items[$index]['short_description'] = $product->getShortDescription();
        }
        $result['totalsData']['items'] = $items;
        return $result;
    }
}
