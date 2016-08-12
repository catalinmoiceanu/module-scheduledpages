<?php

namespace CatalinMoiceanu\ScheduledPages\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class CronTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var \CatalinMoiceanu\ScheduledPages\Helper\Cron|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectMock;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $collectionMock;

    /**
     * @var \Magento\Framework\DB\Select|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $selectMock;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $adapterMock;

    /**
     * @var \Magento\Cms\Model\Page|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pageMock;

    public function setUp()
    {
        $this->contextMock = $this
            ->getMockBuilder('Magento\Framework\App\Helper\Context')
            ->disableOriginalConstructor()
            ->getMock();
        $this->objectMock = $this
            ->getMockBuilder('CatalinMoiceanu\ScheduledPages\Helper\Cron')
            ->setConstructorArgs(array($this->contextMock))
            ->setMethods(null)
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
            ->setMethods(['addFieldToFilter', 'getSelect'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->selectMock = $this
            ->getMockBuilder('Magento\Framework\DB\Select')
            ->setMethods(['getAdapter', 'orWhere'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->adapterMock = $this
            ->getMockBuilder('Magento\Framework\DB\Adapter\AdapterInterface')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @group CatalinMoiceanu_ScheduledPages
     *
     * @param bool $expectedStatus
     * @dataProvider getStatusDataProvider
     */
    public function testUpdatePageStatus($expectedStatus)
    {
        $this->pageMock
            ->expects($this->once())
            ->method('save')
            ->willReturnSelf();

        $this->objectMock->updatePageStatus($this->pageMock, $expectedStatus);

        $this->assertEquals($expectedStatus, $this->pageMock->getIsActive());

    }

    /**
     * @return array
     */
    public function getStatusDataProvider()
    {
        return [
            [ 1 ],
            [ 0 ],
            [ 1 ],
            [ 1 ],
            [ 0 ],
            [ 1 ],
            [ 1 ],
        ];
    }


    /**
     * @group CatalinMoiceanu_ScheduledPages
     */
    public function testFilterPagesThatShouldBeInactive()
    {
        $this->collectionMock
            ->expects($this->once())
            ->method('addFieldToFilter')
            ->willReturnSelf();
        $this->objectMock->filterPagesThatShouldBeInactive($this->collectionMock);
    }

    /**
     * @group CatalinMoiceanu_ScheduledPages
     */
    public function testFilterPagesThatShouldBeActive()
    {
        $this->collectionMock
            ->expects($this->once())
            ->method('getSelect')
            ->willReturn($this->selectMock);
        $this->selectMock
            ->expects($this->once())
            ->method('getAdapter')
            ->willReturn($this->adapterMock);
        $this->selectMock
            ->expects($this->exactly(4))
            ->method('orWhere')
            ->willReturnSelf();
        $this->objectMock->filterPagesThatShouldBeActive($this->collectionMock);
    }
}