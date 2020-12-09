<?php

namespace Companyinfo\Review\Ui\Component\Listing\Grid\Column;

class Action extends \Magento\Ui\Component\Listing\Columns\Column
{
	const URL_PATH_VIEW = 'review/review/view';
    const URL_PATH_EDIT = 'review/review/edit';
    const URL_PATH_DELETE = 'review/review/delete';
    
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

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
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                    	'view' => [
                    		'href' => $this->urlBuilder->getUrl(
                    			static::URL_PATH_VIEW,
                    			[
                    				'id' => $item['id']
                    			]
                    		),
                    		'label' => __('View')
                    	],
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.review }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.review }" record?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}