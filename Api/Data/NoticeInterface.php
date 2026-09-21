<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Api\Data;

interface NoticeInterface
{
    const KEY_ID = 'notice_id';
    const KEY_TYPE = 'type';
    const KEY_RECORD_ID = 'record_id';
    const KEY_RECORD_TYPE = 'record_type';
    const KEY_SENT = 'sent';
    const KEY_COUNT = 'count';
    const KEY_CREATION_TIME = 'creation_time';
    const KEY_UPDATE_TIME = 'update_time';

    const TYPE_EMAIL = 1;
    const TYPE_SMS = 2;
    const TYPE_MOBILE = 3;

    /**
     * @return int
     */
    public function getType(): int;

    /**
     * @return int
     */
    public function getRecordId(): int;

    /**
     * @return string
     */
    public function getRecordType(): string;

    /**
     * @return int
     */
    public function getSent(): int;

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @return string
     */
    public function getCreationTime(): string;

    /**
     * @return string
     */
    public function getUpdateTime(): string;

    /**
     * @param int $type
     */
    public function setType(int $type): void;

    /**
     * @param int $recordId
     */
    public function setRecordId(int $recordId): void;

    /**
     * @param string $recordType
     */
    public function setRecordType(string $recordType): void;

    /**
     * @param int $sent
     */
    public function setSent(int $sent): void;

    /**
     * @param int $count
     */
    public function setCount(int $count): void;
}
