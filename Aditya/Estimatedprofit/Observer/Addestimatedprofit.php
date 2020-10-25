<?php

namespace Aditya\Estimatedprofit\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class Addestimatedprofit implements ObserverInterface
{
    protected $logger;

    protected $orderRepository;

    protected $_productFactory;

    protected $_objectManager;
    
    protected $_pricingHelper;


    public function __construct(LoggerInterface $logger,\Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Pricing\Helper\Data $pricingHelper)
    {
        $this->logger = $logger;
        $this->_productFactory = $productFactory;
        $this->_objectManager = $objectManager;
        $this->_pricingHelper = $pricingHelper;

    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();
            $order_id = $order->getEntityId();
            $finalAmounttotal = 0;
             foreach($order->getAllItems() as $item){

                $product = $this->_productFactory->create();
                $productData = $product->load($item->getProductId());

                $productPriceById = number_format($productData->getPrice(), 2, ".", ",");
                $productSpecialById = number_format($productData->getSpecialPrice(), 2, ".", ",");
                $finalAmount = $item->getQtyOrdered() * ($productPriceById - $productSpecialById);
                $finalAmounttotal += $finalAmount;

             }
                $customestimateObj = $this->_objectManager->create('Aditya\Estimatedprofit\Model\Customestimatedprofit');
                $customestimateObj->setOrderId($order_id);
                $customestimateObj->setEstimatedPrice($finalAmounttotal);
                $customestimateObj->save();
                 //$this->logger->info($finalAmounttotal);
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}