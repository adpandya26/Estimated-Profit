<?php
namespace Aditya\Estimatedprofit\Model\ResourceModel\Order\Grid;
 
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderGridCollection;
use Psr\Log\LoggerInterface as Logger;


class Collection extends OrderGridCollection
{
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'sales_order_grid',
        $resourceModel = Order::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
    protected function _renderFiltersBefore() {
        $joinTable = $this->getTable('custom_estimated_profit');
        $this->getSelect()->joinLeft(
            ['customEst' => $joinTable],
            'main_table.entity_id = customEst.order_id',
            ['estimated_price']
        );
        parent::_renderFiltersBefore();
    }
}