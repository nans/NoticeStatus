<?php

namespace Nans\NoticeStatus\Api;

interface NoticeApiInterface
{
    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return string
     */
    public function getNoticeByParams($recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSent($recordId, $recordType, $type, $count);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $day
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentByDay($recordId, $recordType, $day, $type, $count);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type, $count);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentMonth($recordId, $recordType, $type, $count);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentYear($recordId, $recordType, $type, $count);
}