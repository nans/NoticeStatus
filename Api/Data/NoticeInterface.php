<?php

namespace Nans\NoticeStatus\Api\Data;

interface NoticeInterface
{
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