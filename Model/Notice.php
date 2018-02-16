<?php

namespace Nans\NoticeStatus\Model;

use Zend\Code\Reflection\Exception\InvalidArgumentException;
use Magento\Framework\Model\AbstractModel;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;

class Notice extends AbstractModel implements NoticeInterface
{
    const TYPE_EMAIL = 1;
    const TYPE_SMS = 2;
    const TYPE_MOBILE = 3;

    const KEY_ID = 'notice_id';
    const KEY_TYPE = 'type';
    const KEY_RECORD_ID = 'record_id';
    const KEY_RECORD_TYPE = 'record_type';
    const KEY_SENT = 'sent';
    const KEY_COUNT = 'count';
    const KEY_CREATION_TIME = 'creation_time';
    const KEY_UPDATE_TIME = 'update_time';

    /**
     * @return int
     */
    public function getType()
    {
        return (int)$this->getData(self::KEY_TYPE);
    }

    /**
     * @return int
     */
    public function getRecordId()
    {
        return (int)$this->getData(self::KEY_RECORD_ID);
    }

    /**
     * @return string
     */
    public function getRecordType()
    {
        return $this->getData(self::KEY_RECORD_TYPE);
    }

    /**
     * @return int
     */
    public function getSent()
    {
        return (int)$this->getData(self::KEY_SENT);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int)$this->getData(self::KEY_COUNT);
    }

    /**
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::KEY_CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::KEY_UPDATE_TIME);
    }

    /**
     * @param int
     */
    public function setType($type)
    {
        if (strlen($type) > 5 || !is_numeric($type)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_TYPE, (int)$type);
    }

    /**
     * @param int
     */
    public function setRecordId($recordId)
    {
        if (strlen($recordId) > 10 || !is_numeric($recordId)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_RECORD_ID, (int)$recordId);
    }

    /**
     * @param string
     */
    public function setRecordType($recordType)
    {
        if (strlen($recordType) > 255) {
            throw new InvalidArgumentException();
        }

        $this->setData(self::KEY_RECORD_TYPE, $recordType);
    }

    /**
     * @param int
     */
    public function setSent($sent)
    {
        if (strlen($sent) > 1 || !is_numeric($sent)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_SENT, (int)$sent);
    }

    /**
     * @param int
     */
    public function setCount($count)
    {
        if (strlen($count) > 10 || !is_numeric($count)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_COUNT, (int)$count);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}