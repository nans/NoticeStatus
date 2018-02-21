<?php

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
    public function getId();

    /**
     * @return int
     */
    public function getType();

    /**
     * @return int
     */
    public function getRecordId();

    /**
     * @return string
     */
    public function getRecordType();

    /**
     * @return int
     */
    public function getSent();

    /**
     * @return int
     */
    public function getCount();

    /**
     * @return string
     */
    public function getCreationTime();

    /**
     * @return string
     */
    public function getUpdateTime();

    /**
     * @param int
     */
    public function setId($id);

    /**
     * @param int
     */
    public function setType($type);

    /**
     * @param int
     */
    public function setRecordId($recordId);

    /**
     * @param string
     */
    public function setRecordType($recordType);

    /**
     * @param int
     */
    public function setSent($sent);

    /**
     * @param int
     */
    public function setCount($count);
}