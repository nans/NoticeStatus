<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Model\ResourceModel\Notice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Model\Notice as Model;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = NoticeInterface::KEY_ID;
    protected $_mainTable = 'nans_notice_status';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
