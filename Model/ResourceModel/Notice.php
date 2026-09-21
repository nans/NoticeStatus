<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Model\ResourceModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Nans\NoticeStatus\Api\Data\NoticeInterface;

class Notice extends AbstractDb
{
    const MAIN_TABLE = 'nans_notice_status';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, NoticeInterface::KEY_ID);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
     * @throws NoSuchEntityException
     */
    public function getByParams(int $recordId, string $recordType, int $type): array
    {
        if (!$recordId || !$recordType || !$type) {
            throw new NoSuchEntityException();
        }
        $select = $this->getConnection()
            ->select()
            ->from(['main_table' => $this->getConnection()->getTableName(self::MAIN_TABLE)])
            ->where(NoticeInterface::KEY_RECORD_ID . ' = ?', $recordId)
            ->where(NoticeInterface::KEY_RECORD_TYPE . ' = ?', $recordType)
            ->where(NoticeInterface::KEY_TYPE . ' = ?', $type);
        $result = $this->getConnection()->fetchRow($select);
        if($result === false){
            throw new NoSuchEntityException();
        }
        return $result;
    }
}
