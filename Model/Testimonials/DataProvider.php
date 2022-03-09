<?php
namespace Manugentoo\Testimonials\Model\Testimonials;

use Manugentoo\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class DataProvider
 * @package Manugentoo\ProductCompatibility\Model\Item
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{

    const BASE_IMAGE_PATH = "infiniti/testimonials/images";

    /**
     * @var
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var
     */
    protected $loadedData;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param Filesystem $filesystem
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getTestimonialId()] = $item->getData();
            // retrieve image
            if ($item->getCompanyImage()) {
                // replace icon to your custom field name
                $company_image['company_image'][0]['name'] = $item->getCompanyImage();
                $company_image['company_image'][0]['url'] = $this->getMediaUrl() .$item->getCompanyImage();
                $company_image['company_image'][0]['file'] = $item->getCompanyImage();

                $imageFile = $this->getMediaPath() . $item->getCompanyImage();
                if(file_exists($imageFile)) {
                    $company_image['company_image'][0]['size'] = filesize($imageFile);
                    $imageInfo = getimagesize($imageFile);
                    $company_image['company_image'][0]['type'] = $imageInfo['mime'];
                }

                $fullData = $this->loadedData;
                $this->loadedData[$item->getTestimonialId()] = array_merge($fullData[$item->getTestimonialId()], $company_image);
            }

        }

        /** @var Used in save action $data */
        $data = $this->dataPersistor->get('Manugentoo_testimonials');
        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[$item->getId()] = $item->getData();
            $this->dataPersistor->clear('Manugentoo_testimonials');
        }

        return $this->loadedData;
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . self::BASE_IMAGE_PATH;

    }

    /**
     * @return string
     */
    public function getMediaPath() {
        return $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()  . self::BASE_IMAGE_PATH;
    }
}
