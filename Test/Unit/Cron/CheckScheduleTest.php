<?php

namespace CatalinMoiceanu\ScheduledPages\Test\Unit\Cron;

class CheckScheduleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Cms\Model\PageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pageFactoryMock;

    /**
     * @var \CatalinMoiceanu\ScheduledPages\Helper\Cron|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cronHelperMock;

    /**
     * @var \CatalinMoiceanu\ScheduledPages\Cron\CheckSchedule|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectMock;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $collectionMock;

    /**
     * @var \Magento\Cms\Model\Page|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pageMock;

    public function setUp()
    {
        $this->pageFactoryMock = $this
            ->getMockBuilder('Magento\Cms\Model\PageFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $this->cronHelperMock = $this
            ->getMockBuilder('CatalinMoiceanu\ScheduledPages\Helper\Cron')
            ->disableOriginalConstructor()
            ->getMock();
        $this->objectMock = $this
            ->getMockBuilder('CatalinMoiceanu\ScheduledPages\Cron\CheckSchedule')
            ->setConstructorArgs([$this->pageFactoryMock, $this->cronHelperMock])
            ->getMock();
        $this->pageMock = $this
            ->getMockBuilder('Magento\Cms\Model\Page')
            ->setMethods([
                'create',
                'save',
                'getCollection',
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $this->collectionMock = $this
            ->getMockBuilder('Magento\Cms\Model\ResourceModel\Page\Collection')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @group CatalinMoiceanu_ScheduledPages
     */
    public function testGetCollection()
    {
        $this->pageFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->pageMock);
        $this->pageMock
            ->expects($this->once())
            ->method('getCollection')
            ->willReturn($this->collectionMock);

        $actual = $this->invokeProtectedMethod('getCollection');

        $this->assertSame($this->collectionMock, $actual);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    protected function invokeProtectedMethod($method, $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($this->objectMock));
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($this->objectMock, $parameters);
    }
}
