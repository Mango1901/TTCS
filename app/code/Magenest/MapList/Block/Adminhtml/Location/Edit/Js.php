<?php
/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 9/23/16
 * Time: 14:34
 */

namespace Magenest\MapList\Block\Adminhtml\Location\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;

class Js extends \Magento\Backend\Block\Template
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = array()
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $data);
    }

    public function getMapApi()
    {
        return $this->_scopeConfig->getValue('maplist/map/api');
    }

    public function getCountry()
    {
        return $this->_scopeConfig->getValue('maplist/map/country');
    }

    public function getZoom()
    {
        return $this->_scopeConfig->getValue('maplist/map/zoom');
    }

    public function getLocation()
    {
        return $this->_coreRegistry->registry('maplist_location_location');
    }

    public function getSelectedProduct()
    {
        $data = $this->_coreRegistry->registry('maplist_location_selected_product');
        $productId = array();
        if (!$data) {
            return $productId;
        }

        foreach ($data as $value) {
            $productId[] = $value['product_id'];
        }

        return $productId;
    }
    public function getLocationIcon()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $mediaUrl = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        if ($model && $model->getData('small_image')!=null) {
            $images = $model->getData('small_image');
            $url = $mediaUrl.'catalog/category/'.$images;
            return $url;
        } else {
            return null;
        }
    }
    public function getLocationGalleryImage()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $mediaUrl = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        if ($model) {
            $url = [];
            if ($model->getData('gallery')!=null) {
                $image=array();
                $images = $model->getData('gallery');
                $image[] = explode(';', $images);
                for ($i = 0; $i < sizeof($image[0]); $i++) {
                    $url[$i] = $mediaUrl.'catalog/category/'.$image[0][$i];
                }
            }
            return $url;
        }
        return null;
    }
    public function getAddress()
    {
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        return $model ? $model->getData('address') : "";

    }
    public function getNameGalleryImage(){
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        $url = [];
        if ($model && $model->getData('gallery')!=null) {
            $image=array();
            $images = $model->getData('gallery');
            $image[] = explode(';', $images);
            for ($i = 0; $i < sizeof($image[0]); $i++) {
                $url[$i] = $image[0][$i];
            }
        }
        return $url;
    }

    public function getSelectedBrands(){
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        $brandsList = array();
        if(isset($model['brands'])){
            $brands = array();
            $brandsList = $model['brands'] != '' ? json_decode($model['brands']) : $brands;
        }
        return $brandsList;
    }
    public function getSelectedPayment(){
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        $paymentList = array();
        if(isset($model['payment_methods'])){
            $payment = array();
            $paymentList = $model['payment_methods'] != '' ? json_decode($model['payment_methods']) : $payment;
        }
        return $paymentList;
    }
    public function getParkingAtm(){
        $model = $this->_coreRegistry->registry('maplist_location_edit');
        return json_decode($model['parking_atm']);
    }

    protected function _toHtml()
    {
        return parent::_toHtml(); // TODO: Change the autogenerated stub
    }
}