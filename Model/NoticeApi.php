<?php

namespace Nans\NoticeStatus\Model;

use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Api\NoticeApiInterface;
use Nans\NoticeStatus\Api\NoticeRepositoryInterface;

class NoticeApi implements NoticeApiInterface
{
    /**
     * @var NoticeRepositoryInterface
     */
    protected $_notificationRepository;

    /**
     * @var NoticeFactory
     */
    protected $_notificationFactory;

    /**
     * @param NoticeRepositoryInterface $notificationRepository
     * @param NoticeFactory $notificationFactory
     */
    public function __construct(
        NoticeRepositoryInterface $notificationRepository,
        NoticeFactory $notificationFactory
    ) {
        $this->_notificationRepository = $notificationRepository;
        $this->_notificationFactory = $notificationFactory;
    }

    /**
     * @url /rest/V1/notice/sent/1/record_type/typee/type/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSent($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        return $this->_sendCheck($notice);
    }

    /**
     * @url /rest/V1/notice/sent_day/1/record_type/typee/day/1/type/1
     * @param int $recordId
     * @param int $day
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentByDay($recordId, $recordType, $day = 1, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        if (!$this->_sendCheck($notice) && $this->_checkDateByDays($notice->getUpdateTime(), $day)) {
            return false;
        }
        return true;
    }

    /**
     * @url /rest/V1/notice/sent_week/1/record_type/typee/type/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        return $this->isNoticeSentByDay($recordId, $recordType, 7, $type);
    }

    /**
     * @url /rest/V1/notice/sent_week/1/record_type/typee/type/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentMonth($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        $days = date('t', strtotime('-1 month'));
        return $this->isNoticeSentByDay($recordId, $recordType, $days, $type);
    }

    /**
     * @url /rest/V1/notice/sent_year/1/record_type/typee/type/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentYear($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        $days = date('t', strtotime('-1 year'));
        return $this->isNoticeSentByDay($recordId, $recordType, $days, $type);
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
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentLimited($recordId, $recordType, $type, $count)
    {
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        return $this->_sendCheck($notice) && $notice->getCount() >= $count;
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
     * @return boolean
     */
    protected function _sendCheck($notice)
    {
        return !(!$notice || !$notice->getSent());
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