<?php

namespace CatalinMoiceanu\ScheduledPages\Test\Unit\Observer\Cms;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PageObserverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CatalinMoiceanu\ScheduledPages\Observer\Cms\PageObserver
     */
    protected $observer;

    /**
     * @var \Magento\Framework\Event\Observer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $observerMock;

    /**
     * @var \Magento\Framework\Event|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventMock;

    /**
     * @var \Magento\Cms\Model\Page|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectMock;

    public function setUp()
    {
        $this->observerMock = $this
            ->getMockBuilder('Magento\Framework\Event\Observer')
            ->disableOriginalConstructor()
            ->getMock();
        $this->eventMock = $this
            ->getMockBuilder('Magento\Framework\Event')
            ->setMethods(['getPage'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->objectMock = $this
            ->getMockBuilder('Magento\Cms\Model\Page')
            ->setMethods(['getData'])
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new ObjectManager($this);
        $this->observer = $objectManager->getObject('CatalinMoiceanu\ScheduledPages\Observer\Cms\PageObserver', []);
    }

    /**
     * @group CatalinMoiceanu_ScheduledPages
     */
    public function testPageObserver()
    {
        $this->observerMock
            ->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);
        $this->eventMock
            ->expects($this->any())
            ->method('getPage')
            ->willReturn($this->objectMock);
        $this->objectMock
            ->expects($this->any())
            ->method('getData')
            ->willReturn([
                'schedule_from' =>'04/18/1989',
                'schedule_to' =>'04/18/2089',
            ]);

        $this->assertEquals($this->observer, $this->observer->execute($this->observerMock));
    }
}