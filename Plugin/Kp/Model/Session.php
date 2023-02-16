<?php

namespace CodeDrop\DisableKlarnaForStripeRecurringProducts\Plugin\Kp\Model;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Checkout\Model\Session as MagentoSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Item;
use Klarna\Kp\Model\Session as KlarnaSession;

class Session
{
    protected MagentoSession $session;
    protected ProductFactory $productFactory;
    protected ProductResource $productResource;

    public function __construct(MagentoSession $session, ProductFactory $productFactory, ProductResource $productResource)
    {
        $this->session = $session;
        $this->productFactory = $productFactory;
        $this->productResource = $productResource;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function afterCanSendRequest(KlarnaSession $subject, $result) : bool
    {
        return $result && $this->isQuoteContainsStripeRecurringProduct();
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    protected function isQuoteContainsStripeRecurringProduct() : bool
    {
        $quote = $this->session->getQuote();
        /** @var Item $item */
        foreach ($quote->getAllItems() as $item) {
            $product = $this->productFactory->create();
            $this->productResource->load($product, $item->getProduct()->getId());
            if ($product->getStripeSubEnabled() === '1') {
                return false;
            }
        }

        return true;
    }
}
