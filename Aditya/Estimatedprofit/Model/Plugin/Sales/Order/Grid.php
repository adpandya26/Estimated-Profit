<?php
namespace Aditya\Estimatedprofit\Model\Plugin\Sales\Order;
 
class Grid
{
 
    public static $table = 'sales_order_grid';
    public static $leftJoinTable = 'custom_estimated_profit';
 
    public function afterSearch($intercepter, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {
 
            $leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);
 
            $collection
                ->getSelect()
                ->joinLeft(
                    ['ep'=>$leftJoinTableName],
                    "ep.order_id = main_table.entity_id",
                    [
                        'estimated_price' => 'ep.estimated_price'
                    ]
                );
 
            $where = $collection->getSelect()->getPart(\Magento\Framework\DB\Select::WHERE);
 
            $collection->getSelect()->setPart(\Magento\Framework\DB\Select::WHERE, $where);
 
        }
        return $collection;
 
 
    }
 
 
}