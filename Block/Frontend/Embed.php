<?php

namespace Justuno\Jumagext\Block\Frontend;

use Magento\Framework\View\Element\Template;
use Justuno\Jumagext\Helper\Data;
use Magento\Framework\App\Request\Http;
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;

class Embed extends Template
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var Http
     */
    protected $_request;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * Embed constructor.
     * @param Data $helper
     * @param Http $request
     * @param Registry $registry
     * @param Session $customerSession
     * @param array $data
     * @param Template\Context $context
     */
    public function __construct(
        Data $helper,
        Http $request,
        Session $customerSession,
        Registry $registry,
        Template\Context $context,
        array $data = [])
    {
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        $this->registry = $registry;
        $this->_request = $request;
        $this->data = $data;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getValueACCID()
    {
        return $this->helper->getACCID();
    }

    /**
     * @return string
     */
    public function getValueJUAJAX()
    {
        return $this->helper->getJUAJAX();
    }

    /**
     * @return object
     */
    public function getCurrentProductID()
    {
        return  $this->registry->registry('current_product')->getID();
    }


    /**
     * @return boolean
     */
    public function customerLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * @return string
     */
    public function getCustomerID()
    {
        return $this->customerSession->getCustomer()->getId();
    }

    /**
     * @return string
     */
    public function getFullActionName()
    {
        return $this->_request->getFullActionName();
    }
}
