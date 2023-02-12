<?php

namespace MagePsycho\SeoSuite\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use MagePsycho\SeoSuite\Model\Config\ModuleMetadata;
use MagePsycho\SeoSuite\Helper\Data as SeoSuiteHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Version extends Field
{
    /**
     * @var SeoSuiteHelper
     */
    protected $seoSuiteHelper;

    /**
     * @var ModuleMetadata
     */
    private $moduleMetadata;

    public function __construct(
        Context $context,
        SeoSuiteHelper $seoSuiteHelper,
        ModuleMetadata $moduleMetadata
    ) {
        $this->seoSuiteHelper = $seoSuiteHelper;
        $this->moduleMetadata = $moduleMetadata;
        parent::__construct($context);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        if ($this->moduleMetadata->soldViaMagentoMarketplace()) {
            $versionLabel = $this->moduleMetadata->getVersion();
        } else {
            $versionLabel = sprintf(
                '<a href="%s" title="%s" target="_blank">%s</a>',
                $this->moduleMetadata->getUrl(),
                $this->moduleMetadata->getName(),
                $this->moduleMetadata->getVersion()
            );
        }
        $element->setValue($versionLabel);

        return $element->getValue();
    }
}
