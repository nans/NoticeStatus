<?php

namespace Nans\NoticeStatus\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Nans\NoticeStatus\Api\Data\NoticeInterface;
use Nans\NoticeStatus\Api\NoticeRepositoryInterface;
use Nans\NoticeStatus\Model\ResourceModel\Notice as NoticeResource;

class NoticeRepository implements NoticeRepositoryInterface
{
    /**
     * @var array
     */
    protected $_instances = [];

    /**
     * @var NoticeResource
     */
    protected $_resource;

    /**
     * auto generated class
     * @var NoticeFactory
     */
    protected $_factory;

    /**
     * @param NoticeResource $resource
     * @param NoticeFactory $factory
     */
    public function __construct(
        NoticeResource $resource,
        NoticeFactory $factory
    ) {
        $this->_resource = $resource;
        $this->_factory = $factory;
    }

    /**
     * Save data.
     *
     * @param NoticeInterface $object
     * @return NoticeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(NoticeInterface $object)
    {
        /** @var NoticeInterface|\Magento\Framework\Model\AbstractModel $object */
        try {
            $this->_resource->save($object);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the record: %1',
                $exception->getMessage()
            ));
        }
        return $object;
    }

    /**
     * Retrieve data.
     *
     * @param int $id
     * @return NoticeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id)
    {
        if (!isset($this->_instances[$id])) {
            /** @var NoticeInterface|\Magento\Framework\Model\AbstractModel $object */
            $object = $this->_factory->create();
            $this->_resource->load($object, $id);
            if (!$object->getId()) {
                throw new NoSuchEntityException(__('Data does not exist'));
            }
            $this->_instances[$id] = $object;
        }
        return $this->_instances[$id];
    }

    /**
     * Delete data.
     *
     * @param NoticeInterface $object
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(NoticeInterface $object)
    {
        /** @var NoticeInterface|\Magento\Framework\Model\AbstractModel $object */
        $id = $object->getId();
        try {
            unset($this->_instances[$id]);
            $this->_resource->delete($object);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove %1', $id)
            );
        }
        unset($this->_instances[$id]);
        return true;
    }

    /**
     * Delete data by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param int $recordId
     * @param string $recordType
     * @param int $type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return NoticeInterface
     */
    public function getByParams($recordId, $recordType, $type)
    {
        $data = $this->_resource->getByParams($recordId, $recordType, $type);
        if (!$data) {
            throw new NoSuchEntityException(__('Data does not exist'));
        }
        $model = $this->_factory->create(['data' => $data]);
        //$model->setData($data);
        return $model;
    }
}