<?php

namespace Nans\NoticeStatus\Model\ResourceModel\Notice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Nans\NoticeStatus\Model\Notice as Model;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;

class Collection extends AbstractCollection
{
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