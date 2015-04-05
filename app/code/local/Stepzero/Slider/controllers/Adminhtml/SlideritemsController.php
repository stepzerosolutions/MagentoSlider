<?php
/** * Stepzero
 *
 * NOTICE OF LICENSE
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Stepzero
 * @package     Stepzero_Slider
 * @copyright   Copyright (c) 2014 Stepzero. (http://www.stepzero.solutions)
 * @license     http://www.stepzero.solutions/magento/licenses/Stepzero_Slider
 */
class Stepzero_Slider_Adminhtml_SlideritemsController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('cms')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider Items Manager'), Mage::helper('adminhtml')->__('Slider Items Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		Mage::getSingleton('adminhtml/session')->setFormData( array() );
		$this->_initAction()->renderLayout();
	}
	
	public function listAction(){
		Mage::getSingleton('adminhtml/session')->setFormData( array() );
		$this->_title('Slider Items');
		$this->_initAction()
			->renderLayout();
	}
	
 
	public function newAction() {
		$this->_forward('edit');
	}
	
	
	public function editAction() {

	$this->loadLayout();
	$this->getLayout()->getBlock('head')
		->setCanLoadExtJs(true)
		->setCanLoadTinyMce(true)
		->addItem('js','tiny_mce/tiny_mce.js')
		->addItem('js','mage/adminhtml/wysiwyg/tiny_mce/setup.js')
		->addJs('mage/adminhtml/browser.js')
		->addJs('prototype/window.js')
		->addJs('lib/flex.js')
		->addJs('mage/adminhtml/flexuploader.js')
		->addItem('js_css','prototype/windows/themes/default.css')
		->addItem('js_css','prototype/windows/themes/magento.css');


		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('slider/slider_items')->load($id);

		if ($model->getSlideritem_id() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('slideritems_data', $model);

			$this->_setActiveMenu('cms');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider Manager'), Mage::helper('adminhtml')->__('Slider Items Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider News'), Mage::helper('adminhtml')->__('Slider News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
			
			
			
			$this->renderLayout();
			if ($this->getRequest()->getParam('back')) {
				$this->_redirect('*/*/edit', array('id' => $model->getSlideritem_id()));
				return;
			}
			return;
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slider')->__('Slider does not exist'));
			$this->_redirect('*/*/');
		}
	}
	

	public function saveAction() {
		if(isset($data['stores'])) {
			if(in_array('0',$data['stores'])){
				$data['store_id'] = '0';
			}
			else{
				$data['store_id'] = implode(",", $data['stores']);
			}
		   unset($data['stores']);
		}


		$imgurl = '';
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);

					// We set media as the upload dir
					$path = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'slider' . DS;
					$result = $uploader->save($path , $_FILES['filename']['name'] );
					//Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)
					$imgurl  = '/slider/'. $_FILES['filename']['name'];
					
				} catch (Exception $e) {
		      		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('web')->__('Image file is not uploaded. '. $e));
		        }
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
	  			
			if( $data = $this->getRequest()->getPost() ){
				Mage::getSingleton('adminhtml/session')->setFormData( $data );
				$model = Mage::getModel('slider/slider_items');
				$id = $this->getRequest()->getParam('id');
				try{
					if( $id ){
						$model->load( $id );
					}
					if( !empty($imgurl) ) { 
						$data['slider_image_path']=$imgurl;
					} else {
						$data['slider_image_path']=$data['slideritem_image_manual'];
					}
					
					if( isset($data['stores']) ) {
						if( in_array('0', $data['stores']) ){
							$data['store_id'] = '0';
						} else {
							$data['store_id'] = join(",", $data['stores']);
						}
						unset($data['stores']);
					}


					$model->addData($data);
					$model->save();
					$slideritem_id = $model->getSlideritem_id();
					$delete_links = $this->getRequest()->getParam('delete');
					foreach($delete_links as $key => $value ){
						$collection = Mage::getModel('slider/slider_links');
						$collection->load( $value );
						$collection->setId($value)
						->delete();
					}
					$slider_links = $this->getRequest()->getParam('linkcontent');
					if($slider_links){
						$sliderlinktitle = $this->getRequest()->getParam('sliderlinktitle');
						$positionx = $this->getRequest()->getParam('positionx');
						$positiony = $this->getRequest()->getParam('positiony');
						$linkcontent = $this->getRequest()->getParam('linkcontent');
						foreach($slider_links as $key => $value ){
							  $collection = Mage::getModel('slider/slider_links');
							  $collection->setSliderlink_item( $slideritem_id  );
							  $collection->setSliderlink_title( $sliderlinktitle[$key] );
							  $collection->setSliderlink_x( $positionx[$key] );
							  $collection->setSliderlink_y( $positiony[$key] );
							  $collection->setSliderlink_content( $linkcontent[$key] );
							  $collection->save();
						}
					}
					
					$edit_slider_links = $this->getRequest()->getParam('linkcontent_edit');
					if($edit_slider_links){
						$sliderlinktitle = $this->getRequest()->getParam('sliderlinktitle_edit');
						$positionx = $this->getRequest()->getParam('positionx_edit');
						$positiony = $this->getRequest()->getParam('positiony_edit');
						$linkcontent = $this->getRequest()->getParam('linkcontent_edit');
						foreach($edit_slider_links as $key => $value ){
							  $collection = Mage::getModel('slider/slider_links')->load($key);
							  $collection->setSliderlink_item( $slideritem_id  );
							  $collection->setSliderlink_title( $sliderlinktitle[$key] );
							  $collection->setSliderlink_x( $positionx[$key] );
							  $collection->setSliderlink_y( $positiony[$key] );
							  $collection->setSliderlink_content( $linkcontent[$key] );
							  $collection->save();
						}
					}
					
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('slider')->__('Slider item was successfully saved'));
					Mage::getSingleton('adminhtml/session')->setFormData(false);
					
					if ($this->getRequest()->getParam('back')) {
						$this->_redirect('*/*/edit', array('id' => $slideritem_id));
						return;
					}
					if ($this->getRequest()->getParam('save_and_continue')) {
						$this->_redirect('*/*/edit', array('id' => $slideritem_id));
						return;
					}
					$this->_redirect('*/*/');
					return;
				} catch (Exception $e) {
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
					Mage::getSingleton('adminhtml/session')->setFormData($data);
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
					return;
				}
			}
			

        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slider')->__('Unable to find slider item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$id = $this->getRequest()->getParam('id');
				$model = Mage::getModel('slider/slider_items');
				$model->load( $id );
				$image = $model->getData() ; 
				if( !empty( $image['slider_image_path'] )){
					$path = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) ;
				    if(file_exists($path . $image['slider_image_path'])) unlink( $path . $image['slider_image_path'] );
				}
				$model->setId( $id )
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Slider item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
	
    public function massDeleteAction() {
        $slitemIds = $this->getRequest()->getParam('slideritem');
        if(!is_array($slitemIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s) to delete'));
        } else {
            try {
                foreach ($slitemIds as $slitemid) {
                    $web = Mage::getModel('slider/slider_items')->load($slitemid);
                    $web->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($slitemIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $sliderIds = $this->getRequest()->getParam('slideritem');
        if(!is_array($webIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($slitemIds as $slitemid) {
                    $web = Mage::getSingleton('slider/slider_items')
                        ->load($slitemid)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($slitemIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
