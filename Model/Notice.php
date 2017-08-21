<?php

namespace Nans\NoticeStatus\Model;

use Magento\Framework\Model\AbstractModel;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;

class Notice extends AbstractModel implements NoticeInterface
{
    const EMAIL_TYPE = 0;
    const SMS_TYPE = 1;
    const MOBILE_TYPE = 2;//todo add api

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->getData(self::getColumnType());
    }

    /**
     * @return int
     */
    public function getRecordId()
    {
        return $this->getData(self::getColumnRecordId());
    }

    /**
     * @return string
     */
    public function getRecordType()
    {
        return $this->getData(self::getColumnRecordType());
    }

    /**
     * @return int
     */
    public function getSent()
    {
        return $this->getData(self::getColumnSent());
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->getData(self::getColumnCount());
    }

    /**
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::getColumnCreationTime());
    }

    /**
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::getColumnUpdateTime());
    }

    /**
     * @param int
     */
    public function setType($type)
    {
        $this->setData(self::getColumnType(), $type);
    }

    /**
     * @param int
     */
    public function setRecordId($recordId)
    {
        $this->setData(self::getColumnRecordId(), $recordId);
    }

    /**
     * @param string
     */
    public function setRecordType($recordType)
    {
        $this->setData(self::getColumnRecordType(), $recordType);
    }

    /**
     * @param int
     */
    public function setSent($sent)
    {
        $this->setData(self::getColumnSent(), $sent);
    }

    /**
     * @param int
     */
    public function setCount($count)
    {
        $this->setData(self::getColumnCount(), $count);
    }

    /**
     * @return string
     */
    public static function getColumnId()
    {
        return 'notice_id';
    }

    /**
     * @return string
     */
    public static function getColumnType()
    {
        return 'type';
    }

    /**
     * @return string
     */
    public static function getColumnRecordId()
    {
        return 'record_id';
    }

    /**
     * @return string
     */
    public static function getColumnRecordType()
    {
        return 'record_type';
    }

    /**
     * @return string
     */
    public static function getColumnSent()
    {
        return 'sent';
    }

    /**
     * @return string
     */
    public static function getColumnCount()
    {
        return 'count';
    }

    /**
     * @return string
     */
    public static function getColumnCreationTime()
    {
        return 'creation_time';
    }

    /**
     * @return string
     */
    public static function getColumnUpdateTime()
    {
        return 'update_time';
    }
}