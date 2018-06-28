<?php

namespace CatalinMoiceanu\ScheduledPages\Model;

use CatalinMoiceanu\ScheduledPages\Helper\Page;

class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * PostDataProcessor constructor.
     *
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     */
    public function __construct(\Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter)
    {
        $this->dateFilter = $dateFilter;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function filter($data)
    {
        $filterRules = [];

        foreach ([Page::KEY_SCHEDULE_FROM, Page::KEY_SCHEDULE_TO] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $this->dateFilter;
            }
        }

        return (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
    }
}
