<?php

namespace Nans\NoticeStatus\Api;

use Nans\NoticeStatus\Api\Data\NoticeInterface;

interface NoticeRepositoryInterface
{
    /**
     * @param array $data
     * @return NoticeInterface
     */
    public function create(array $data = []);

    /**
     * Save record.
     *
     * @param NoticeInterface $object
     * @return NoticeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(NoticeInterface $object);

    /**
     * Retrieve record.
     *
     * @param int $id
     * @return NoticeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Delete record.
     *
     * @param NoticeInterface $object
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(NoticeInterface $object);

    /**
     * Delete record by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return NoticeInterface
     */
    public function getObjectByParams($recordId, $recordType, $type);

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return array
     */
    public function getArrayByParams($recordId, $recordType, $type);
}