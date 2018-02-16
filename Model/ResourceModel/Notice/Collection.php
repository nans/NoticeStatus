<?php

namespace Nans\NoticeStatus\Model\ResourceModel\Notice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Nans\NoticeStatus\Model\Notice as Model;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = Model::KEY_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}