<?php

namespace Nans\NoticeStatus\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as ResourceModel;
use Symfony\Component\String\Exception\InvalidArgumentException;

class Notice extends AbstractModel implements NoticeInterface
{
    /**
     * @return int
     */
    public function getType(): int
    {
        return (int)$this->getData(self::KEY_TYPE);
    }

    /**
     * @return int
     */
    public function getRecordId(): int
    {
        return (int)$this->getData(self::KEY_RECORD_ID);
    }

    /**
     * @return string
     */
    public function getRecordType(): string
    {
        return $this->getData(self::KEY_RECORD_TYPE);
    }

    /**
     * @return int
     */
    public function getSent(): int
    {
        return (int)$this->getData(self::KEY_SENT);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return (int)$this->getData(self::KEY_COUNT);
    }

    /**
     * @return string
     */
    public function getCreationTime(): string
    {
        return $this->getData(self::KEY_CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime(): string
    {
        return $this->getData(self::KEY_UPDATE_TIME);
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        if (strlen($type) > 5 || !is_numeric($type)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_TYPE, (int)$type);
    }

    /**
     * @param int $recordId
     */
    public function setRecordId(int $recordId): void
    {
        if (strlen($recordId) > 10 || !is_numeric($recordId)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_RECORD_ID, (int)$recordId);
    }

    /**
     * @param string $recordType
     */
    public function setRecordType(string $recordType): void
    {
        if (strlen($recordType) > 255) {
            throw new InvalidArgumentException();
        }

        $this->setData(self::KEY_RECORD_TYPE, $recordType);
    }

    /**
     * @param int $sent
     */
    public function setSent(int $sent): void
    {
        if (strlen($sent) > 1 || !is_numeric($sent)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_SENT, (int)$sent);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        if (strlen($count) > 10 || !is_numeric($count)) {
            throw new InvalidArgumentException();
        }
        $this->setData(self::KEY_COUNT, (int)$count);
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Identifier getter
     *
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->_getData($this->_idFieldName);
    }
}
