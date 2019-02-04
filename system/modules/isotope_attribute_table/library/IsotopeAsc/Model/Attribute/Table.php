<?php

/**
 * Isotope Attribute Table
 *
 * Copyright (C) 2019 Andrew Stevens Consulting
 *
 * @package    asconsulting/isotope_attribute_table
 * @link       https://andrewstevens.consulting
 */
 
 

namespace IsotopeAsc\Model\Attribute;

use Isotope\Interfaces\IsotopeAttribute;
use Isotope\Interfaces\IsotopeProduct;
use Isotope\Model\Attribute;


/**
 * Attribute to provide an audio/video player in the product details
 *
 * @copyright  Isotope eCommerce Workgroup 2009-2014
 * @author     Christoph Wiechert <cw@4wardmedia.de>
 */
class Table extends Attribute implements IsotopeAttribute
{


    public function saveToDCA(array &$arrData)
    {
        parent::saveToDCA($arrData);

        $arrData['fields'][$this->field_name]['fieldType'] = 'tableWizard';
        $arrData['fields'][$this->field_name]['eval'] = array('allowHtml'=>true, 'doNotSaveEmpty'=>true, 'style'=>'width:142px;height:66px');
		$arrData['fields'][$this->field_name]['sql'] = "mediumtext NULL";
		
    }


    /**
     * Return class name for the backend widget or false if none should be available
     * @return    string
     */
    public function getBackendWidget()
    {
        return $GLOBALS['BE_FFL']['tableWizard'];
    }


    /**
     * Generate media attribute
     *
     * @param \Isotope\Interfaces\IsotopeProduct $objProduct
     * @param array $arrOptions
     * @return string
     */
    public function generate(IsotopeProduct $objProduct, array $arrOptions = array())
    {
	
		$varValue = $objProduct->{$this->field_name};
		$arrTemp = deserialize($varValue);
		if (!is_array($arrTemp) || empty($arrTemp) || $arrTemp === array(array(""))){
			return '';
		}
		
		$objModel = NEW \ContentModel;
		$objContentTable = NEW \ContentTable($objModel);
		$objContentTable->tableitems = $varValue;
		return $objContentTable->generate();

    }
}
