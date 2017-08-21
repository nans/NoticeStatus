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
     * @return boolean
     */
    public function isNoticeSent($recordId, $recordType, $type);

    /**
     * @param int $count
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isLimitedNoticeSent($count, $recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentToday($recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentDay($recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type);
}