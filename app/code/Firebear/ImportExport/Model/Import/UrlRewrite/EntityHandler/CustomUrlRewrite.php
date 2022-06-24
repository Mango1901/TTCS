<?php
/**
 * Custom
 *
 * @copyright Copyright © 2019 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Firebear\ImportExport\Model\Import\UrlRewrite\EntityHandler;

use Firebear\ImportExport\Model\Import\UrlRewrite\EntityHandler\Common;

class CustomUrlRewrite extends Common
{
    /** @var string  */
    const ENTITY_TYPE = 'custom';

    /**
     * Array of validate attributes
     *
     * @var array
     */
    protected $_validateAttributes = [
        self::COLUMN_TARGET_PATH => self::ERROR_TARGET_PATH_IS_EMPTY,
        self::COLUMN_ENTITY_TYPE => self::ERROR_ENTITY_TYPE_IS_EMPTY,
        self::COLUMN_STORE_ID => self::ERROR_STORE_ID_IS_EMPTY,
        self::COLUMN_REQUEST_PATH => self::ERROR_REQUEST_PATH_IS_EMPTY,
    ];
}
