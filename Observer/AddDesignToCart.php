<?php
/**
 * @author Printcart <printcart@gmail.com>
 * Created at 01/18/21 10:00 AM GTM+07:00
 */

namespace Printcart\Design\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class AddDesignToCart implements ObserverInterface
{
    protected $_request;
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder
    ) {
        $this->_request = $request;
        $this->jsonEncoder = $jsonEncoder;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        if ($this->_request->getPostValue('designs')) {
            $designs = $this->jsonEncoder->encode($this->_request->getPostValue('designs'));
            $quoteItem->setData('designs', $designs);
        }
    }
}
