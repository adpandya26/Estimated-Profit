<?php
namespace Aditya\Estimatedprofit\Model\ResourceModel;
 
class Customestimatedprofit extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('custom_estimated_profit', 'id');
    }
}