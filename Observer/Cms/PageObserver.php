<?php

namespace CatalinMoiceanu\ScheduledPages\Observer\Cms;

use Magento\Framework\Event\ObserverInterface;

class PageObserver implements ObserverInterface
{
    /** @var \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter */
    protected $dateFilter;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     */
    public function __construct(\Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter)
    {
        $this->dateFilter = $dateFilter;
    }

    /**
     * Filter scheduled_from and scheduled_to dates
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $filterRules = [];
        $data = $observer->getPage()->getData();

        foreach (['schedule_from', 'schedule_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $this->dateFilter;
            }
        }

        $data = (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
        $observer->getPage()->setData($data);

        return $this;
    }
}
