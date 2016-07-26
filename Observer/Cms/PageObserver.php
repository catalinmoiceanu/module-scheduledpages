<?php

namespace CatalinMoiceanu\ScheduledPages\Observer\Cms;

use Magento\Framework\Event\ObserverInterface;

class PageObserver implements ObserverInterface
{
    /**
     * Filter scheduled_from and scheduled_to dates
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $dateFilter = $objectManager->get('Magento\Framework\Stdlib\DateTime\Filter\Date');
        $filterRules = [];
        $data = $observer->getPage()->getData();

        foreach (['schedule_from', 'schedule_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $dateFilter;
            }
        }

        $data = (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
        $observer->getPage()->setData($data);

        return $this;
    }
}
