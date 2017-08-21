<?php

namespace Nans\NoticeStatus\Model;

use Magento\Framework\ObjectManagerInterface;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Api\NoticeApiInterface;
use Nans\NoticeStatus\Api\NoticeRepositoryInterface;



class NoticeApi implements NoticeApiInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var NoticeRepositoryInterface
     */
    protected $_notificationRepository;

    /**
     * @var NoticeFactory
     */
    protected $_notificationFactory;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param NoticeRepositoryInterface $notificationRepository
     * @param NoticeFactory $notificationFactory
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        NoticeRepositoryInterface $notificationRepository,
        NoticeFactory $notificationFactory
    ) {
        $this->_objectManager = $objectManager;
        $this->_notificationRepository = $notificationRepository;
        $this->_notificationFactory = $notificationFactory;
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return NoticeInterface|null
     */
    protected function _getNoticeByParams($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        try {
            return $this->_notificationRepository->getByParams($recordId, $recordType, $type);
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSent($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notification */
        $notification = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$notification || !$notification->getSent()) {
            return false;
        }
        return true;
    }

    /**
     * @param int $count
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isLimitedNoticeSent($count, $recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notification */
        $notification = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$notification || !$notification->getSent() || $notification->getCount() < $count) {
            return false;
        }
        return true;
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentToday($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notification */
        $notification = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$notification || !$notification->getSent()) {
            return false;
        }
        return true;
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentDay($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notification */
        $notification = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$notification || !$notification->getSent() || $notification->getUpdateTime() - time() > 24 * 60 * 60) {
            return false;
        }
        return true;
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notification */
        $notification = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$notification || !$notification->getSent() || $notification->getUpdateTime() - time() > 7 * 24 * 60 * 60) {
            return false;
        }
        return true;
    }

    //todo month year?

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return string
     */
    public function getNoticeByParams($recordId, $recordType, $type)
    {
        return null;
    }
}