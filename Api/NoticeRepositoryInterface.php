<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Api;

use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface NoticeRepositoryInterface
{
    /**
     * @param array $data
     * @return NoticeInterface
     */
    public function create(array $data = []):NoticeInterface;

    /**
     * Save record.
     *
     * @param NoticeInterface $object
     * @return NoticeInterface
     * @throws LocalizedException
     */
    public function save(NoticeInterface $object): NoticeInterface;

    /**
     * Retrieve record.
     *
     * @param int $id
     * @return NoticeInterface
     * @throws LocalizedException
     */
    public function getById(int $id):NoticeInterface;

    /**
     * Delete record.
     *
     * @param NoticeInterface $object
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(NoticeInterface $object): bool;

    /**
     * Delete record by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return NoticeInterface
     * @throws NoSuchEntityException
     */
    public function getObjectByParams(int $recordId, string $recordType, int $type): NoticeInterface;

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
     * @throws NoSuchEntityException
     */
    public function getArrayByParams(int $recordId, string $recordType, int $type):array;
}
