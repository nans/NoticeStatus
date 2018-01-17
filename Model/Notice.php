<?php

namespace Nans\NoticeStatus\Model;

use Magento\Framework\Model\AbstractModel;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;
use Zend\Code\Reflection\Exception\InvalidArgumentException;

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
        return (int)$this->getData(self::TYPE);
    }

    /**
     * @return int
     */
    public function getRecordId()
    {
        return (int)$this->getData(self::RECORD_ID);
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
        return (int)$this->getData(self::SENT);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int)$this->getData(self::COUNT);
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
        if (strlen($type) > 5 || !is_numeric($type)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::TYPE, (int)$type);
    }

    /**
     * @param int
     */
    public function setRecordId($recordId)
    {
        if (strlen($recordId) > 10 || !is_numeric($recordId)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::RECORD_ID, (int)$recordId);
    }

    /**
     * @param string
     */
    public function setRecordType($recordType)
    {
        if (strlen($recordType) > 255) {
            throw new InvalidArgumentException();
        }

        $this->setData(self::RECORD_TYPE, $recordType);
    }

    /**
     * @param int
     */
    public function setSent($sent)
    {
        if (strlen($sent) > 1 || !is_numeric($sent)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::SENT, (int)$sent);
    }

    /**
     * @param int
     */
    public function setCount($count)
    {
        if (strlen($count) > 10 || !is_numeric($count)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::COUNT, (int)$count);
    }
}