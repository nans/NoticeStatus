<?php

declare(strict_types=1);

namespace Nans\NoticeStatus\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Model\AbstractModel;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Api\NoticeRepositoryInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as NoticeResource;

class NoticeRepository implements NoticeRepositoryInterface
{
    /**
     * @var array
     */
    protected array $instances = [];

    /**
     * @var NoticeResource
     */
    protected NoticeResource $resource;

    /**
     * @var NoticeFactory
     */
    protected NoticeFactory $factory;

    /**
     * @param NoticeResource $resource
     * @param NoticeFactory $factory
     */
    public function __construct(
        NoticeResource $resource,
        NoticeFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @param NoticeInterface $object
     * @return NoticeInterface
     * @throws LocalizedException
     */
    public function save(NoticeInterface $object): NoticeInterface
    {
        /** @var NoticeInterface|AbstractModel $object */
        try {
            $this->resource->save($object);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the record: %1', $exception->getMessage()));
        }
        return $object;
    }

    /**
     * @param int $id
     * @return NoticeInterface
     * @throws LocalizedException
     */
    public function getById(int $id): NoticeInterface
    {
        if (!isset($this->instances[$id])) {
            /** @var NoticeInterface|AbstractModel $object */
            $object = $this->create();
            $this->resource->load($object, $id);
            if (!$object->getId()) {
                throw new NoSuchEntityException();
            }
            $this->instances[$id] = $object;
        }
        return $this->instances[$id];
    }

    /**
     * @param NoticeInterface $object
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(NoticeInterface $object): bool
    {
        /** @var NoticeInterface|AbstractModel $object */
        $id = $object->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($object);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove %1', $id));
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * @param int $id
     * @return bool true on success
     * @throws LocalizedException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return NoticeInterface
     * @throws NoSuchEntityException
     */
    public function getObjectByParams(int $recordId, string $recordType, int $type): NoticeInterface
    {
        $data = $this->getArrayByParams($recordId, $recordType, $type);
        if (!$data) {
            throw new NoSuchEntityException();
        }
        return $this->create($data);
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @return array
     * @throws NoSuchEntityException
     */
    public function getArrayByParams(int $recordId, string $recordType, int $type): array
    {
        $data = $this->resource->getByParams($recordId, $recordType, $type);
        if (!$data) {
            throw new NoSuchEntityException();
        }
        return $data;
    }

    /**
     * @param array $data
     * @return NoticeInterface
     */
    public function create(array $data = []): NoticeInterface
    {
        return $this->factory->create(['data' => $data]);
    }
}
