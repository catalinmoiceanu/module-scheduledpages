<?php

namespace CatalinMoiceanu\ScheduledPages\Observer\Cms;

use Magento\Framework\Event\ObserverInterface;
use CatalinMoiceanu\ScheduledPages\Helper\Page;

class PageObserver implements ObserverInterface
{
    /** @var \CatalinMoiceanu\ScheduledPages\Model\PostDataProcessor $postDataProcessor */
    protected $postDataProcessor;

    /**
     * @param \CatalinMoiceanu\ScheduledPages\Model\PostDataProcessor $postDataProcessor
     */
    public function __construct(\CatalinMoiceanu\ScheduledPages\Model\PostDataProcessor $postDataProcessor)
    {
        $this->postDataProcessor = $postDataProcessor;
    }

    /**
     * Filter scheduled_from and scheduled_to dates
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $page = $observer->getEvent()->getPage();

        $filteredData = $this->postDataProcessor->filter([
            Page::KEY_SCHEDULE_FROM => $page->getData(Page::KEY_SCHEDULE_FROM),
            Page::KEY_SCHEDULE_TO => $page->getData(Page::KEY_SCHEDULE_TO)
        ]);

        $page->setData(Page::KEY_SCHEDULE_FROM, $filteredData[Page::KEY_SCHEDULE_FROM]);
        $page->setData(Page::KEY_SCHEDULE_TO, $filteredData[Page::KEY_SCHEDULE_TO]);

        return $this;
    }
}
