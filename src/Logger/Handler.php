<?php

namespace MagePsycho\SeoSuite\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/magepsycho_seosuite.log';

    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;
}
