<?php

namespace Manugentoo\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\UrlInterface;
use Manugentoo\Testimonials\Api\Data\TestimonialInterface;
use Manugentoo\Testimonials\Model\Testimonials;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;


/**
 * Class Uploader
 * @package Manugentoo\Testimonials\Controller\Adminhtml\Manage
 * @author Manu Gentoo <manugentoo@gmail.com>
 */
class Uploader extends \Magento\Backend\App\Action
{

	/**
	 * @var Filesystem
	 */
	protected $fileSystem;
	/**
	 * @var RequestInterface
	 */
	protected $request;
	/**
	 * @var ScopeConfigInterface
	 */
	protected $scopeConfig;
	/**
	 * @var AdapterFactory
	 */
	protected $adapterFactory;
	/**
	 * @var UploaderFactory
	 */
	protected $uploaderFactory;
	/**
	 * @var LoggerInterface
	 */
	protected $logger;
	/**
	 * @var RawFactory
	 */
	protected $resultRawFactory;
	/**
	 * @var StoreManagerInterface
	 */
	protected $storeManager;

	/**
	 * Uploader constructor.
	 * @param Action\Context $context
	 * @param RawFactory $resultRawFactory
	 * @param StoreManagerInterface $storeManager
	 * @param Filesystem $fileSystem
	 * @param UploaderFactory $uploaderFactory
	 * @param RequestInterface $request
	 * @param ScopeConfigInterface $scopeConfig
	 * @param AdapterFactory $adapterFactory
	 * @param LoggerInterface $logger
	 */
	public function __construct(
		Action\Context $context,
		RawFactory $resultRawFactory,
		StoreManagerInterface $storeManager,
		Filesystem $fileSystem,
		UploaderFactory $uploaderFactory,
		RequestInterface $request,
		ScopeConfigInterface $scopeConfig,
		AdapterFactory $adapterFactory,
		LoggerInterface $logger
	) {
		parent::__construct($context);
		$this->fileSystem = $fileSystem;
		$this->request = $request;
		$this->scopeConfig = $scopeConfig;
		$this->adapterFactory = $adapterFactory;
		$this->uploaderFactory = $uploaderFactory;
		$this->logger = $logger;
		$this->resultRawFactory = $resultRawFactory;
		$this->storeManager = $storeManager;
	}

	/**
	 * @return ResponseInterface|Raw|ResultInterface
	 */
	public function execute()
	{
		try {
			$uploaderFactory = $this->uploaderFactory->create(['fileId' => 'company_image']);
			$uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
			$uploaderFactory->setAllowRenameFiles(true);
			$uploaderFactory->setFilesDispersion(true);
			$mediaDirectory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
			$destinationPath = $mediaDirectory->getAbsolutePath(
				Testimonials::IMAGE_UPLOAD_DIR
			);
			$result = $uploaderFactory->save($destinationPath);

			unset($result['tmp_name']);
			unset($result['path']);

			$result['url'] = $this->getBaseMediaUrl() . TestimonialInterface::UPLOAD_DIR . $result['file'];
			$result['url'] = $this->cleanImagePath($result['url']);
		} catch (\Exception $e) {
			$result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
		}

		/** @var Raw $response */
		$response = $this->resultRawFactory->create();
		$response->setHeader('Content-type', 'text/plain');
		$response->setContents(json_encode($result));
		return $response;
	}

	/**
	 * @return mixed
	 * @throws NoSuchEntityException
	 */
	private function getBaseMediaUrl()
	{
		return $this->storeManager->getStore()->getBaseUrl(
			UrlInterface::URL_TYPE_MEDIA
		);
	}

	/**
	 * @param $file
	 * @return string
	 */
	private function cleanImagePath($file)
	{
		return ltrim(str_replace('\\', '/', $file), '/');
	}
}