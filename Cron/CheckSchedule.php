<?php

namespace CatalinMoiceanu\ScheduledPages\Cron;

class CheckSchedule
{
    /** @var  \Magento\Cms\Model\PageFactory $pageFactory */
    protected $pageFactory;

    /** @var  \CatalinMoiceanu\ScheduledPages\Helper\Cron */
    protected $cronHelper;

    /**
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory,
        \CatalinMoiceanu\ScheduledPages\Helper\Cron $cronHelper
    )
    {
        $this->pageFactory = $pageFactory;
        $this->cronHelper = $cronHelper;
    }

    public function execute()
    {
        $this->processPagesThatShouldBeInactive();
        $this->processPagesThatShouldBeActive();
    }

    protected function processPagesThatShouldBeInactive()
    {
        $collection = $this->getCollection();
        $this->cronHelper->filterPagesThatShouldBeInactive($collection);
        foreach ($collection as $page)
        {
            $this->cronHelper->updatePageStatus($page, false);
        }
    }

    protected function processPagesThatShouldBeActive()
    {
        $collection = $this->getCollection();
        $this->cronHelper->filterPagesThatShouldBeActive($collection);
        foreach ($collection as $page)
        {
            $this->cronHelper->updatePageStatus($page, true);
        }
    }

    /**
     * @return \Magento\Cms\Model\ResourceModel\Page\Collection $collection
     */
    protected function getCollection()
    {
        $page = $this->pageFactory->create();
        $collection = $page->getCollection();
        return $collection;
    }
}