<?php

namespace Nans\NoticeStatus\Model;

use Exception;
use Magento\Framework\App\Request\Http;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Api\NoticeApiInterface;
use Nans\NoticeStatus\Api\NoticeRepositoryInterface;

class NoticeApi implements NoticeApiInterface
{
    /**
     * @var Http
     */
    protected Http $_request;

    /**
     * @var NoticeRepositoryInterface
     */
    protected NoticeRepositoryInterface $_notificationRepository;

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
    public function isNoticeSent($recordId, $recordType, $type = Notice::TYPE_EMAIL): bool
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
    public function isNoticeSentByDayNumber($recordId, $recordType, $day = 1, $type = Notice::TYPE_EMAIL): bool
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
    public function isNoticeSentWeek($recordId, $recordType, $type = Notice::TYPE_EMAIL): bool
    {
        return $this->isNoticeSentByDayNumber($recordId, $recordType, 7, $type);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentMonth($recordId, $recordType, $type = Notice::TYPE_EMAIL): bool
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
    public function isNoticeSentYear($recordId, $recordType, $type = Notice::TYPE_EMAIL): bool
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
    public function getNoticeByParams($recordId, $recordType, $type): array
    {
        try {
            return [$this->_notificationRepository->getArrayByParams($recordId, $recordType, $type)];
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
    public function isNoticeSentLimited($recordId, $recordType, $type, $count): bool
    {
        /** @var Notice $notice */
        $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
        return $this->_isNoticeSend($notice) && $notice->getCount() >= $count;
    }

    /**
     * @return boolean
     */
    public function createNotice(): bool
    {
        $recordId = $this->_getParamFromRequest(Notice::KEY_RECORD_ID);
        $recordType = $this->_getParamFromRequest(Notice::KEY_RECORD_TYPE);
        $type = $this->_getParamFromRequest(Notice::KEY_TYPE);
        $sent = $this->_getParamFromRequest(Notice::KEY_SENT);
        $count = $this->_getParamFromRequest(Notice::KEY_COUNT);

        if ((!$recordId && $recordId)
            || !$recordType
            || (!$type && $type != 0)
            || (!$sent && $sent != 0)
            || (!$count && $count != 0)
        ) {
            return false;
        }

        try {
            $this->createNoticeByParams($recordId, $recordType, $type, $sent, $count);
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $sent
     * @param int $count
     * @return bool
     */
    public function createNoticeByParams(int $recordId, string $recordType, int $type, int $sent, int $count):bool
    {
        try {
            /** @var Notice $notice */
            $notice = $this->_notificationRepository->create();
            $notice->setRecordId($recordId);
            $notice->setRecordType($recordType);
            $notice->setType($type);
            $notice->setSent($sent);
            $notice->setCount($count);
            $this->_notificationRepository->save($notice);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteNotice(int $id):bool
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
    public function deleteNoticeByParams():bool
    {
        $recordId = $this->_getParamFromRequest(NoticeInterface::KEY_RECORD_ID);
        $recordType = $this->_getParamFromRequest(NoticeInterface::KEY_RECORD_TYPE);
        $type = $this->_getParamFromRequest(NoticeInterface::KEY_TYPE);

        if (!$recordId || !$recordType || (!$type && $type != 0)) {
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
    public function updateNotice():bool
    {
        $recordId = $this->_getParamFromRequest(NoticeInterface::KEY_RECORD_ID);
        $recordType = $this->_getParamFromRequest(NoticeInterface::KEY_RECORD_TYPE);
        $type = $this->_getParamFromRequest(NoticeInterface::KEY_TYPE);
        $sent = $this->_getParamFromRequest(NoticeInterface::KEY_SENT);
        $count = $this->_getParamFromRequest(NoticeInterface::KEY_COUNT);

        /** @var Notice $notice */
        try {
            $this->updateNoticeByParams($recordId, $recordType, $type, $sent, $count);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $sent
     * @param int $count
     * @return bool
     */
    public function updateNoticeByParams(int$recordId, string $recordType,int $type,int $sent,int $count):bool
    {
        try {
            $notice = $this->_notificationRepository->getObjectByParams($recordId, $recordType, $type);
            if (!empty($count) || ($count != '' && $count == 0)) {
                $notice->setCount($count);
            }
            if (!empty($sent) || ($sent != '' && $sent == 0)) {
                $notice->setSent($sent);
            }
            $this->_notificationRepository->save($notice);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $id
     * @param int $sent
     * @return boolean
     */
    public function setNoticeStatusById(int $id, int $sent): bool
    {
        try {
            /** @var Notice $notice */
            $notice = $this->_notificationRepository->getById($id);
            $notice->setSent($sent);
            $this->_notificationRepository->save($notice);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $sent
     * @return bool
     */
    public function setNoticeStatusByParams(int $recordId, string $recordType, int $type, int $sent): bool
    {
        try {
            /** @var Notice $notice */
            $notice = $this->_getNoticeByParams($recordId, $recordType, $type);
            $notice->setSent($sent);
            $this->_notificationRepository->save($notice);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return NoticeInterface|null
     */
    protected function _getNoticeByParams(int $recordId, string $recordType, int $type = NoticeInterface::TYPE_EMAIL): ?NoticeInterface
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
    protected function _isNoticeSend(NoticeInterface $notice): bool
    {
        return $notice && $notice->getSent();
    }

    /**
     * @param string $date
     * @param int $days
     * @return boolean
     */
    private function _timePassedByDays(string $date, int $days): bool
    {
        return $this->_getTimeInDays($days) < (time() - strtotime($date));
    }

    /**
     * @param int $days
     * @return int
     */
    private function _getTimeInDays(int $days = 1): int
    {
        return 24 * 60 * 60 * $days;
    }

    /**
     * @param int|float $time
     * @return int
     */
    private function _getDaysFromTime(int|float $time): int
    {
        return (int)($time / 24 / 60 / 60);
    }

    /**
     * @param string $paramName
     * @return string
     */
    private function _getParamFromRequest(string $paramName): string
    {
        return trim($this->_request->getParam($paramName));
    }
}
