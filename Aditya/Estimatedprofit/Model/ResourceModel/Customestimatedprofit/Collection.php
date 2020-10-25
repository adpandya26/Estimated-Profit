<?php
namespace Aditya\Estimatedprofit\Model\ResourceModel\Customestimatedprofit;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Aditya\Estimatedprofit\Model\Customestimatedprofit', 'Aditya\Estimatedprofit\Model\ResourceModel\Customestimatedprofit');
    }
 
    
}