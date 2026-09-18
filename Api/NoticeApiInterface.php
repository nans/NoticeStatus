<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Api;

interface NoticeApiInterface
{
    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
     */
    public function getNoticeByParams(int $recordId, string $recordType, int $type): array;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSent(int $recordId, string $recordType, int $type): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $count
     * @return boolean
     */
    public function isNoticeSentLimited(int $recordId, string $recordType, int $type, int $count): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $day
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentByDayNumber(int $recordId, string $recordType, int $day, int $type): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentWeek(int $recordId, string $recordType, int $type): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentMonth(int $recordId, string $recordType, int $type): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return boolean
     */
    public function isNoticeSentYear(int $recordId, string $recordType, int $type): bool;

    /**
     * @return boolean
     */
    public function createNotice(): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteNotice(int $id): bool;

    /**
     * @return bool
     */
    public function deleteNoticeByParams(): bool;

    /**
     * @return boolean
     */
    public function updateNotice(): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $sent
     * @param int $count
     * @return boolean
     */
    public function updateNoticeByParams(int $recordId, string $recordType, int $type, int $sent, int $count): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $sent
     * @param int $count
     * @return boolean
     */
    public function createNoticeByParams(int $recordId, string $recordType, int $type, int $sent, int $count): bool;

    /**
     * @param int $id
     * @param int $sent
     * @return boolean
     */
    public function setNoticeStatusById(int $id, int $sent): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @param int $sent
     * @return bool
     */
    public function setNoticeStatusByParams(int $recordId, string $recordType, int $type, int $sent): bool;
}
