<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Api\Data;

interface NoticeInterface
{
    const string KEY_ID = 'notice_id';
    const string KEY_TYPE = 'type';
    const string KEY_RECORD_ID = 'record_id';
    const string KEY_RECORD_TYPE = 'record_type';
    const string KEY_SENT = 'sent';
    const string KEY_COUNT = 'count';
    const string KEY_CREATION_TIME = 'creation_time';
    const string KEY_UPDATE_TIME = 'update_time';

    const int TYPE_EMAIL = 1;
    const int TYPE_SMS = 2;
    const int TYPE_MOBILE = 3;

    /**
     * @return int
     */
    public function getId():int;

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
