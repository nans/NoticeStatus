<?php

namespace Nans\NoticeStatus\Model;

use Exception;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Api\NoticeApiInterface;
use Nans\NoticeStatus\Api\NoticeRepositoryInterface;
use Magento\Framework\App\Request\Http;

class NoticeApi implements NoticeApiInterface
{
    /**
     * @var Http
     */
    protected $_request;

    /**
     * @var NoticeRepositoryInterface
     */
    protected $_notificationRepository;

    /**
     * @param Http $request
     * @param NoticeRepositoryInterface $notificationRepository
     */
    public function __construct(
        Http $request,
        NoticeRepositoryInterface $notificationRepository
    ) {
        $this->_request = $request;
        $this->_notificationRepository = $notificationRepository;
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
     * @url /rest/V1/notice/id/1/record_type/typee/type/1
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
     */
    public function getNoticeByParams($recordId, $recordType, $type)
    {
        try {
            return $this->_notificationRepository->getArrayByParams($recordId, $recordType, $type);
        } catch (Exception $exception) {
            return [];
        }
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
     * /rest/V1/notice/add
     * @return boolean
     */
    public function createNotice()
    {
        $recordId = $this->getParamFromRequest(Notice::RECORD_ID);
        $recordType = $this->getParamFromRequest(Notice::RECORD_TYPE);
        $type = $this->getParamFromRequest(Notice::TYPE);
        $sent = $this->getParamFromRequest(Notice::SENT);
        $count = $this->getParamFromRequest(Notice::COUNT);

        if ((!$recordId && $recordId)
            || !$recordType
            || (!$type && $type != 0)
            || (!$sent && $sent != 0)
            || (!$count && $count != 0)
        ) {
            return false;
        }

        try {
            /** @var Notice $notice */
            $notice = $this->_notificationRepository->create();
            $notice->setRecordId($recordId);
            $notice->setRecordType($recordType);
            $notice->setType($type);
            $notice->setSent($sent);
            $notice->setCount($count);
            $this->_notificationRepository->save($notice);
        } catch (Exception $exception) {
            return false;
        }
        return true;
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
            return $this->_notificationRepository->getObjectByParams($recordId, $recordType, $type);
        } catch (Exception $exception) {
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

    /**
     * @param string
     * @return string
     */
    private function getParamFromRequest($paramName)
    {
        return trim($this->_request->getParam($paramName));
    }
}