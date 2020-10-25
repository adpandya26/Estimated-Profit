<?php
namespace Aditya\Estimatedprofit\Ui\Component\Listing\Column;
 
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Aditya\Estimatedprofit\Model\Customestimatedprofit;
 
class Profit extends Column
{
 
    protected $_orderRepository;
    protected $_searchCriteria;
    protected $_customestimatedprofit;
    protected $_pricingHelper;
 
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        Customestimatedprofit $customestimatedprofit,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        array $components = [], array $data = [])
    {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        $this->_customestimatedprofit = $customestimatedprofit;
        $this->_pricingHelper = $pricingHelper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $order  = $this->_orderRepository->get($item["entity_id"]);
 
                $order_id = $order->getEntityId();
                $collection = $this->_customestimatedprofit->getCollection();
                $collection->addFieldToFilter('order_id',$order_id);
                $data = $collection->getFirstItem();
 
 
 
                $item[$this->getData('name')] = !empty($data->getEstimatedPrice()) ? $this->_pricingHelper->currency($data->getEstimatedPrice(),true,false) : '';
            }
        }
        return $dataSource;
    }
}