<?php

namespace MagePsycho\SeoSuite\Model\ResourceModel\Cms;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\GetUtilityPageIdentifiersInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * @category   MagePsycho
 * @package    MagePsycho_SeoSuite
 * @author     Raj KB <rajkb@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Page extends AbstractDb
{
    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @var GetUtilityPageIdentifiersInterface
     */
    private $getUtilityPageIdentifiers;

    public function __construct(
        Context $context,
        MetadataPool $metadataPool,
        GetUtilityPageIdentifiersInterface $getUtilityPageIdentifiers = null,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->metadataPool = $metadataPool;
        $this->getUtilityPageIdentifiers = $getUtilityPageIdentifiers ?:
            ObjectManager::getInstance()->get(GetUtilityPageIdentifiersInterface::class);
    }

    protected function _construct()
    {
        $this->_init('cms_page', 'page_id');
    }

    public function getConnection()
    {
        return $this->metadataPool->getMetadata(PageInterface::class)->getEntityConnection();
    }

    /**
     * Retrieve cms page collection array
     *
     * @param int $storeId
     * @return array
     */
    public function getCollection($storeId)
    {
        $entityMetadata = $this->metadataPool->getMetadata(PageInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = $this->getConnection()->select()->from(
            ['main_table' => $this->getMainTable()],
            [$this->getIdFieldName(), 'url' => 'identifier', 'title']
        )->join(
            ['store_table' => $this->getTable('cms_page_store')],
            "main_table.{$linkField} = store_table.$linkField",
            []
        )->where(
            'main_table.is_active = 1'
        )->where(
            'main_table.identifier NOT IN (?)',
            $this->getUtilityPageIdentifiers->execute()
        )->where(
            'store_table.store_id IN(?)',
            [0, $storeId]
        );

        $pages = [];
        $query = $this->getConnection()->query($select);
        while ($row = $query->fetch()) {
            $page = $this->_prepareObject($row);
            $pages[$page->getId()] = $page;
        }

        return $pages;
    }

    /**
     * Prepare page object
     *
     * @param array $data
     * @return \Magento\Framework\DataObject
     */
    protected function _prepareObject(array $data)
    {
        $object = new \Magento\Framework\DataObject();
        $object->setId($data[$this->getIdFieldName()]);
        $object->setTitle($data['title']);
        $object->setUrl($data['url']);

        return $object;
    }
}
