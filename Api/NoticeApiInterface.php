<?php

namespace Nans\NoticeStatus\Api;

interface NoticeApiInterface
{
    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
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
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentLimited($recordId, $recordType, $type, $count);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $day
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentByDayNumber($recordId, $recordType, $day, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentWeek($recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentMonth($recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentYear($recordId, $recordType, $type);

    /**
     * @return boolean
     */
    public function createNotice();

    /**
     * @param int $id
     * @return bool
     */
    public function deleteNotice($id);

    /**
     * @return bool
     */
    public function deleteNoticeByParams();

    /**
     * @return boolean
     */
    public function updateNotice();

    /**
     * @param int $recordId
     * @param string $recordType
     * @param $type
     * @param $sent
     * @param $count
     * @return boolean
     */
    public function updateNoticeByParams($recordId, $recordType, $type, $sent, $count);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param $type
     * @param $sent
     * @param $count
     * @return boolean
     */
    public function createNoticeByParams($recordId, $recordType, $type, $sent, $count);

    /**
     * @param int $id
     * @param int $sent
     * @return boolean
     */
    public function setNoticeStatusById($id, $sent);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int string $type
     * @param int string $sent
     * @return bool
     */
    public function setNoticeStatusByParams($recordId, $recordType, $type, $sent);
}