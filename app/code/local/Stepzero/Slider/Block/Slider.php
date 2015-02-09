<?php
/**
 * Stepzero
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
class Stepzero_Slider_Block_Slider extends Mage_Core_Block_Template
{
	
    protected function _construct()
    {
        $this->addData(array('cache_lifetime' => false));//cache is set to week ( 7 days 36288000)
        $this->addCacheTag(array(
            Mage_Catalog_Model_Product::CACHE_TAG
        ));
    }
	
	
    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $shortCacheId = array(
            'SLIDERS',
			Mage::app()->getStore()->getId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            'template' => $this->getTemplate(),
            'name' => $this->getNameInLayout(),
        );
        $cacheId = $shortCacheId;
        return $cacheId;
    }
	
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSlider()     
     { 
        if (!$this->hasData('slider')) {
            $this->setData('slider', Mage::registry('slider'));
        }
        return $this->getData('slider');
        
    }
	
	public function getLoadedSliderImages( $slideridentifier, $cid='generic_slider' ){
		$storeid = Mage::app()->getStore()->getId();
		
		$collection = Mage::getModel('slider/slider')->getCollection()
						->addFieldToSelect( array( 'slider_id', 'slider_width', 'slider_height', 'slider_duration' ) )
						->join('slider/slider_items','`slider/slider_items`.slideritem_slider = main_table.slider_id')
						->addFieldToFilter('slider_id',$slideridentifier )
						->addFieldToFilter('main_table.status', array('eq'=>1) )
						->addFieldToFilter('`slider/slider_items`.store_id', array(array('like'=>'%' . $storeid . '%')) );
						
						
		$collection->getSelect()->order('slider_sort ASC');

		$sliders = $collection->getData();
		$output = '';
		$first=true;
		$ol = '<ol class="carousel-indicators">';
		$slidto = 0;
		foreach( $sliders as $slider ){
			if($slider['status']){
				$slideritem_links = Mage::getModel('slider/slider_links')
					->getResourceCollection()
					->addSliderLinkFilter( (int)$slider['slideritem_id'] )
					->load()->getData();	
					
				$ol .= '<li data-target="#'.$cid.'" data-slide-to="'.$slidto.'"';
				$slidto++;
				if( $first ) $ol .= ' class="active"';
				$ol .= ' ></li>
				
				';
				
				
				$url = !empty($slider['slider_url'])?'<a href="'.$slider['slider_url'].'" title="'.$slider['slideritem_title'].'">':'';
				$urlend = !empty($slider['slider_url'])?'</a>':'';
				
				$output .= '<div class="item ';
				if( $first ) { $output .= 'active'; $first=false; }
				$output .= '">';
				$output .= $url.'<img data-src="'.$slider['slider_image_path'].'" alt="'.$slider['slideritem_title'].'" />'.$urlend;
				$output .= '<div class="carousel-caption">
								';
				//$output .= $slider['slideritem_description'];
                $output .= '	';
                $output .= '   </div>';
                $output .= '</div>';

			}
		}
		$ol .= '</ol>
		
		';
		
		
		
		if( empty( $output ) ) return false;
		
		
		return  '<div class="carousel-inner">
					' . $output . 
					'</div>';
	}
}