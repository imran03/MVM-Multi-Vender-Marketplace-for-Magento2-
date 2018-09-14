<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 27/8/18
 * Time: 1:07 PM
 */

namespace Codilar\Seller\Block\Product;
use Magento\Catalog\Model\Category;
use \Magento\Catalog\Model\Indexer\Category\Flat\State ;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use \Codilar\CustomLogin\Helper\Vendor;
use Magento\Framework\DB\Helper as FrameworkDbHelper;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Add extends \Magento\Framework\View\Element\Template
{
    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    /**
     * @var CollectionFactory
     */
    protected $categoryCollectionFactory;
    /**
     * @var FrameworkDbHelper
     */
    protected $frameworkDbHelper;

    protected $formKey;
    protected $_scopeConfig;
    protected $_urlBuilder;
    protected $_productFactory;
    protected $request;
    protected $_product;
    protected $_stockItemRepository;
    protected $_helperData;


    public function __construct(
        Vendor $helperData,
        FrameworkDbHelper $frameworkDbHelper,
        CollectionFactory $categoryCollectionFactory,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        Category $category,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    )
    {
        $this->frameworkDbHelper = $frameworkDbHelper;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        $this->_helperData = $helperData;
        $this->request = $request;
        $this->_product = $productFactory;
        $this->_productRepository = $productRepository;
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryRepository = $categoryRepository;
        $this->_objectManager = $objectManager;
        $this->formKey = $context->getFormKey();
        $this->_stockItemRepository = $stockItemRepository;
        $this->_category = $category;
        parent::__construct($context, $data);

    }

    /**
     * Get form action URL for POST booking request
     *
     * @return string
     *
     */
    public function getProductData()
    {
        // use
        //$this->request->getParams(); // all params
        $id= $this->request->getParam('param');
        $product = $this->_product->create()->load($id);
        return $product;

    }

    public function getFormAction()
    {
        return $this->getUrl ('seller/product/save');

    }

//    public function getStockItem()
//    {
//        $id= $this->request->getParam('param');
//        return $this->_stockItemRepository->get($id);
//    }
    public function getStoreCategories()
    {
        return $this->_categoryHelper->getStoreCategories();
    }




    public function getChildCategories($categoryId)
    {

        $_category = $this->_categoryFactory->create();

        $category = $_category->load($categoryId);

        //Get category collection
        $collection = $category->getCollection()
            ->addIsActiveFilter()
            ->addOrderField('name')
            ->addIdFilter($category->getChildren());
        return $collection;
    }

    public function getCategoriesTree($filter = null)
    {
        $helper = $this->_helperData;
        if (!$helper->getAllowedCategoryIds()) {
            $categoryTree = $this->getCacheModel()->load('seller_category_tree_' . $filter);
            if ($categoryTree) {
                return json_encode(unserialize($categoryTree));
            }
        }
        $storeId = $this->_helperData->getCustomerId();
        $categoryCollection = $this->categoryCollectionFactory->create();
        if ($filter !== null) {
            $categoryCollection->addAttributeToFilter(
                'name',
                ['like' => $this->frameworkDbHelper->addLikeEscape($filter, ['position' => 'any'])]
            );
        }

        if ($helper->getAllowedCategoryIds()) {
            $allowedCategoryIds = explode(',', trim($helper->getAllowedCategoryIds()));
            $categoryCollection->addAttributeToSelect('path')
                ->addAttributeToFilter('entity_id', ['in' => $allowedCategoryIds])
                ->setStoreId($storeId);
        } else {
            $categoryCollection->addAttributeToSelect('path')
                ->addAttributeToFilter('entity_id', ['neq' => Category::TREE_ROOT_ID])
                ->setStoreId($storeId);
        }
        $shownCategoriesIds = [];

        /** @var \Magento\Catalog\Model\Category $category */
        foreach ($categoryCollection as $category) {
            foreach (explode('/', $category['path']) as $parentId) {
                $shownCategoriesIds[$parentId] = 1;
            }
        }

        /* @var $collection \Magento\Catalog\Model\ResourceModel\Category\Collection */
        $collection = $this->categoryCollectionFactory->create();

        $collection->addAttributeToFilter('entity_id', ['in' => array_keys($shownCategoriesIds)])
            ->addAttributeToSelect(['name', 'is_active', 'parent_id']);

        $sellerCategory = [
            Category::TREE_ROOT_ID => [
                'value' => Category::TREE_ROOT_ID,
                'optgroup' => null,
            ],
        ];

        foreach ($collection as $category) {
            $catId = $category->getId();
            $catParentId = $category->getParentId();
            foreach ([$catId, $catParentId] as $categoryId) {
                if (!isset($sellerCategory[$categoryId])) {
                    $sellerCategory[$categoryId] = ['value' => $categoryId];
                }
            }

            $sellerCategory[$catId]['is_active'] = $category->getIsActive();
            $sellerCategory[$catId]['label'] = $category->getName();
            $sellerCategory[$catParentId]['optgroup'][] = &$sellerCategory[$catId];
        }
        if (!$helper->getAllowedCategoryIds()) {
            $this->getCacheModel()->save(
                serialize($sellerCategory[Category::TREE_ROOT_ID]['optgroup']),
                'seller_category_tree_' . $filter,
                [
                    Category::CACHE_TAG,
                    \Magento\Framework\App\Cache\Type\Block::CACHE_TAG
                ]
            );
        }
        return json_encode($sellerCategory[Category::TREE_ROOT_ID]['optgroup']);
    }

}