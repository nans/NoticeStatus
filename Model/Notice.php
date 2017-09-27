<?php

namespace Nans\NoticeStatus\Model;

use Magento\Framework\Model\AbstractModel;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;

class Notice extends AbstractModel implements NoticeInterface
{
    const EMAIL_TYPE = 0;
    const SMS_TYPE = 1;
    const MOBILE_TYPE = 2;

    const ID = 'notice_id';
    const TYPE = 'type';
    const RECORD_ID = 'record_id';
    const RECORD_TYPE = 'record_type';
    const SENT = 'sent';
    const COUNT = 'count';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';


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
        return $this->getData(self::TYPE);
    }

    /**
     * @return int
     */
    public function getRecordId()
    {
        return $this->getData(self::RECORD_ID);
    }

    /**
     * @return string
     */
    public function getRecordType()
    {
        return $this->getData(self::RECORD_TYPE);
    }

    /**
     * @return int
     */
    public function getSent()
    {
        return $this->getData(self::SENT);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->getData(self::COUNT);
    }

    /**
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @param int
     */
    public function setType($type)
    {
        $this->setData(self::TYPE, $type);
    }

    /**
     * @param int
     */
    public function setRecordId($recordId)
    {
        $this->setData(self::RECORD_ID, $recordId);
    }

    /**
     * @param string
     */
    public function setRecordType($recordType)
    {
        $this->setData(self::RECORD_TYPE, $recordType);
    }

    /**
     * @param int
     */
    public function setSent($sent)
    {
        $this->setData(self::SENT, $sent);
    }

    /**
     * @param int
     */
    public function setCount($count)
    {
        $this->setData(self::COUNT, $count);
    }
}