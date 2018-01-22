<?php

namespace Nans\NoticeStatus\Model;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
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
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSent($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        return $this->_isNoticeSend($this->_getNoticeByParams($recordId, $recordType, $type));
    }

    /**
     * @param int $recordId
     * @param int $day
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentByDayNumber($recordId, $recordType, $day = 1, $type = Notice::EMAIL_TYPE)
    {
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        return $this->_isNoticeSend($notice) && !$this->_timePassedByDays($notice->getUpdateTime(), $day);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        return $this->isNoticeSentByDayNumber($recordId, $recordType, 7, $type);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentMonth($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        $days = date('t', strtotime('-1 month'));
        return $this->isNoticeSentByDayNumber($recordId, $recordType, $days, $type);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentYear($recordId, $recordType, $type = Notice::EMAIL_TYPE)
    {
        $days = $this->_getDaysFromTime(time() - strtotime('-1 year'));
        return $this->isNoticeSentByDayNumber($recordId, $recordType, $days, $type);
    }

    /**
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
        return $this->_isNoticeSend($notice) && $notice->getCount() >= $count;
    }

    /**
     * @return boolean
     */
    public function createNotice()
    {
        $recordId = $this->_getParamFromRequest(Notice::RECORD_ID);
        $recordType = $this->_getParamFromRequest(Notice::RECORD_TYPE);
        $type = $this->_getParamFromRequest(Notice::TYPE);
        $sent = $this->_getParamFromRequest(Notice::SENT);
        $count = $this->_getParamFromRequest(Notice::COUNT);

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
     * @param NoticeInterface $notice
     * @return boolean
     */
    protected function _isNoticeSend($notice)
    {
        return $notice && $notice->getSent();
    }

    /**
     * @param string $date
     * @param int $days
     * @return boolean
     */
    private function _timePassedByDays($date, $days)
    {
        $value = $this->_getTimeInDays($days) < (time() - strtotime($date));
        return $value;
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
     * @param $time
     * @return int
     */
    private function _getDaysFromTime($time)
    {
        return $time / 24 / 60 / 60;
    }

    /**
     * @param string
     * @return string
     */
    private function _getParamFromRequest($paramName)
    {
        return trim($this->_request->getParam($paramName));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteNotice($id)
    {
        try {
            $this->_notificationRepository->deleteById($id);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function deleteNoticeByParams()
    {
        $recordId = $this->_getParamFromRequest(Notice::RECORD_ID);
        $recordType = $this->_getParamFromRequest(Notice::RECORD_TYPE);
        $type = $this->_getParamFromRequest(Notice::TYPE);

        if ((!$recordId && $recordId) || !$recordType || (!$type && $type != 0)) {
            return false;
        }

        try {
            $notice = $this->_notificationRepository->getObjectByParams($recordId, $recordType, $type);
            $this->_notificationRepository->delete($notice);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return boolean
     */
    public function updateNotice()
    {
        $id = $this->_getParamFromRequest(Notice::ID);
        $recordId = $this->_getParamFromRequest(Notice::RECORD_ID);
        $recordType = $this->_getParamFromRequest(Notice::RECORD_TYPE);
        $type = $this->_getParamFromRequest(Notice::TYPE);
        $sent = $this->_getParamFromRequest(Notice::SENT);
        $count = $this->_getParamFromRequest(Notice::COUNT);

        /** @var Notice $notice */
        try {
            if ($id) {
                $notice = $this->_notificationRepository->getById($id);
            } else {
                if ($recordId && $recordType && ($type || $type == 0)) {
                    $notice = $this->_notificationRepository->getObjectByParams($recordId, $recordType, $type);
                }
            }

            if (!empty($count) || ($count != '' && $count == 0)) {
                $notice->setCount($count);
            }
            if (!empty($sent) || ($sent != '' && $sent == 0)) {
                $notice->setSent($sent);
            }

            $this->_notificationRepository->save($notice);
            return true;
        } catch (NoSuchEntityException $exception) {
            return false;
        }
    }
}