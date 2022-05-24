<?php

namespace Printcart\Design\Plugin\Order\Item;

class Renderer
{
    public function beforeToHtml(\Magento\Sales\Block\Order\Item\Renderer\DefaultRenderer $subject)
    {
        $subject->setTemplate('Printcart_Design::order/items/renderer/default.phtml');
    }
}
