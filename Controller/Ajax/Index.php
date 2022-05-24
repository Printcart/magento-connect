<?php
/**
 * @author Printcart <printcart@gmail.com>
 * Created at 01/18/21 10:00 AM GTM+07:00
 */

namespace Printcart\Design\Controller\Ajax;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    protected $_jsonHelper;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_jsonHelper = $jsonHelper;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $parentId = $this->getRequest()->getParam('parentId');
        $content = $this->_view->getLayout()->createBlock("Printcart\Design\Block\Product\View")
                                            ->setData('integration_product_id', $id)
                                            ->setData('parent_id', $parentId)
                                            ->setTemplate("Printcart_Design::tooldesignbyajax.phtml");

        $result = ['content' => $content->toHtml()];
        $this->getResponse()->representJson($this->_jsonHelper->jsonEncode($result));
    }
}
