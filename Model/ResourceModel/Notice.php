<?php

namespace Nans\NoticeStatus\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Nans\NoticeStatus\Model\Notice as Model;

class Notice extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init($this->getTableName(), Model::getColumnId());
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
     */
    public function getByParams($recordId, $recordType, $type)
    {
        $select = $this->getConnection()
            ->select()
            ->from(['main_table' => $this->getConnection()->getTableName($this->getMainTable())])
            ->where(Model::getColumnRecordId() . ' = ?', $recordId)
            ->where(Model::getColumnRecordType() . ' = ?', $recordType)
            ->where(Model::getColumnType() . ' = ?', $type);
        return $this->getConnection()->fetchRow($select);
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'nans_notice_status';
    }
}