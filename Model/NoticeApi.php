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
     * @url /rest/V1/notice/sent/1/record_type/typee/type/1/count/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSent($recordId, $recordType, $type = Notice::EMAIL_TYPE, $count = 1)
    {
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        return $this->_baseCheck($notice, $count);
    }

    /**
     * @url /rest/V1/notice/sent_day/1/record_type/typee/day/1/type/1/count/1
     * @param int $recordId
     * @param int $day
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentByDay($recordId, $recordType, $day = 1, $type = Notice::EMAIL_TYPE, $count = 1)
    {   //todo add custom time?
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$this->_baseCheck($notice, $count) || $this->_checkDateByDays($notice->getUpdateTime(), $day)) {
            return false;
        }
        return true;
    }

    /**
     * @url /rest/V1/notice/sent_week/1/record_type/typee/type/1/count/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type = Notice::EMAIL_TYPE, $count = 1)
    {
        return $this->isNoticeSentByDay($recordId, $recordType, 7, $type, $count);
    }

    /**
     * @url /rest/V1/notice/sent_week/1/record_type/typee/type/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentMonth($recordId, $recordType, $type = Notice::EMAIL_TYPE, $count = 1)
    {
        $days = date('t', strtotime('-1 month'));
        return $this->isNoticeSentByDay($recordId, $recordType, $days, $type, $count);
    }

    /**
     * @url /rest/V1/notice/sent_year/1/record_type/typee/type/1/count/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentYear($recordId, $recordType, $type = Notice::EMAIL_TYPE, $count = 1)
    {
        $days = date('t', strtotime('-1 year'));
        return $this->isNoticeSentByDay($recordId, $recordType, $days, $type, $count);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return string
     */
    public function getNoticeByParams($recordId, $recordType, $type)
    {
        return $this->_getNoticeByParams($recordId, $recordType, $type);
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
     * @param Notice $notice
     * @param int $count
     * @return boolean
     */
    protected function _baseCheck($notice, $count)
    {//todo rename
        if (!$notice || !$notice->getSent() || $notice->getCount() < $count) {
            return false;//todo simplify
        }
        return true;
    }

    /**
     * @param string $date
     * @param int $days
     * @return boolean
     */
    private function _checkDateByDays($date, $days)
    {
        return time() - strtotime($date) > $this->_getTimeInDays($days);
    }

    /**
     * @param int $days
     * @return int
     */
    private function _getTimeInDays($days = 1)
    {
        return 24 * 60 * 60 * $days;
    }
}