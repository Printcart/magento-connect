<?php

namespace Printcart\Design\Ui\Component\Listing\Columns\Sales;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Project extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Column name
     */
    const NAME = 'column.project';

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $projectId = $item['printcart_project_id'];
                
                $item[$this->getData('name')]['edit'] = [
                    'href' => 'https://dashboard.printcart.com/project/'.$projectId,
                    'label' => __($projectId),
                    'hidden' => false,
                ];
            }
        }

        return $dataSource;
    }
}
