<?php

namespace Printcart\Design\Observer;

class OrderSaveAfter implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Printcart\Design\Helper\Data $helper,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Printcart\Design\Service\PrintcartApiService $apiService,
        \Magento\Framework\Json\DecoderInterface $jsonDecoder
    ) {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->productRepository = $productRepository;
        $this->apiService = $apiService;
        $this->jsonDecoder = $jsonDecoder;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getData('order');
        if ($order->getPrintcartProjectId()) {
            return;
        }
        $orderItems = $order->getAllItems();
        $designIds = [];

        foreach ($orderItems as $item) {
            if ($item->getDesigns()) {
                $designIds = array_column(array_merge($designIds, $this->jsonDecoder->decode($item->getDesigns())), 'id');
            }
        }

        if ($designIds) {
            $data = [
                "name" => $order->getIncrementId(),
                "status" => "processing",
                "design_ids" => $designIds
            ];

            $project = $this->apiService->createProject($data, $this->getAccessToken());

            if ($project) {
                $projectData = $this->jsonDecoder->decode($project)['data'];
                $order->setPrintcartProjectId($projectData['id']);
                $order->save();
            }
        }
    }

    protected function getAccessToken()
    {
        return $this->helper->getConfig('design/general/api_key');
    }
}
