<?php
/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 10/10/16
 * Time: 20:58
 */

namespace Magenest\MapList\Model;

use Magento\Framework\Model\AbstractModel;
use Magenest\MapList\Helper\Constant;

class LocationGallery extends AbstractModel
{
    protected $_idFieldName = Constant::LOCATION_GALLERY_TABLE_ID;

    protected function _construct()
    {
        $this->_init(Constant::LOCATION_GALLERY_RESOURCE_MODEL);
    }
}
