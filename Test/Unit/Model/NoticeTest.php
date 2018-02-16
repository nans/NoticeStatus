<?php

namespace Nans\NoticeStatus\Test\Unit\Model;

use InvalidArgumentException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Nans\NoticeStatus\Model\Notice;
use PHPUnit_Framework_TestCase;

class NoticeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Notice
     */
    protected $_model;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->_model = $objectManager->getObject(Notice::class);
    }

    public function testSetSent()
    {
        $status = 1;
        $this->_model->setSent($status);
        $this->assertEquals($status, $this->_model->getData(Notice::KEY_SENT));
    }

    public function testSetSentValidation()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $count = '';
        $this->_model->setSent($count);
    }

    public function testGetSent()
    {
        $status = 0;
        $this->_model->setSent($status);
        $this->assertEquals($status, $this->_model->getSent());
    }

    public function testSetCount()
    {
        $count = 10;
        $this->_model->setCount($count);
        $this->assertEquals($count, $this->_model->getData(Notice::KEY_COUNT));
    }

    public function testSetCountValidation()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $count = 'string';
        $this->_model->setCount($count);
    }

    public function testGetCount()
    {
        $count = 15;
        $this->_model->setCount($count);
        $this->assertEquals($count, $this->_model->getCount());
    }
}