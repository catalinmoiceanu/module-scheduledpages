<?php

namespace CatalinMoiceanu\ScheduledPages\Helper;

use Magento\Framework\App\Helper\Context;

class Cron extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var string $now */
    protected $now;

    /**
     * Cron constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
        $this->now = date('Y-m-d H:i:s');
    }

    /**
     * @param \Magento\Cms\Model\Page $page
     * @param bool $state
     */
    public function updatePageStatus(\Magento\Cms\Model\Page $page, $state)
    {
        $page->setIsActive($state);
        $page->save();
    }

    /**
     * @param \Magento\Cms\Model\ResourceModel\Page\Collection $collection
     */
    public function filterPagesThatShouldBeInactive(\Magento\Cms\Model\ResourceModel\Page\Collection $collection)
    {
        $fields = [ Page::KEY_SCHEDULE_FROM, Page::KEY_SCHEDULE_TO ];
        $condition = [
            [ 'gteq' => $this->now ],
            [ 'lteq' => $this->now ]
        ];
        $collection->addFieldToFilter($fields, $condition);
    }

    /**
     * @param \Magento\Cms\Model\ResourceModel\Page\Collection $collection
     */
    public function filterPagesThatShouldBeActive(\Magento\Cms\Model\ResourceModel\Page\Collection $collection)
    {
        $select = $collection->getSelect();
        $adapter = $select->getAdapter();

        $columnScheduleFrom = $adapter->quoteIdentifier(Page::KEY_SCHEDULE_FROM);
        $columnScheduleTo = $adapter->quoteIdentifier(Page::KEY_SCHEDULE_TO);
        $sqlFromLessThan = $adapter->quoteInto($columnScheduleFrom . " <= ?", $this->now);
        $sqlFromIsNull = $adapter->quote($columnScheduleFrom . " IS NULL");
        $sqlToGreaterThan = $adapter->quoteInto($columnScheduleTo . " >= ?", $this->now);
        $sqlToIsNull = $adapter->quote($columnScheduleTo . " IS NULL");

        $select
            ->orWhere($sqlFromLessThan . " AND " . $sqlToGreaterThan)
            ->orWhere($sqlFromLessThan . " AND " . $sqlToIsNull)
            ->orWhere($sqlFromIsNull . " AND " . $sqlToGreaterThan)
            ->orWhere($sqlFromIsNull . " AND " . $sqlToIsNull);
    }
}