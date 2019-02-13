<?php

namespace DieSchittigs\DieSchittigsHelpers;
use Contao\CoreBundle\Exception\PageNotFoundException;
class HelperClass extends \Frontend
{
    public function addClassesToArticle($objRow){
        
        $arrCss = unserialize($objRow->cssID);
        
        if (!is_array($arrCustom = unserialize($objRow->customClass))) return;
        $arrCss[1] .= ' ' . implode(' ', $arrCustom);
        $objRow->cssID = serialize($arrCss);
    }


    public function addClassesToElement($objRow, $strBuffer, $objElement){
        
        if (!is_array($arrCustom = unserialize($objElement->customClass))) return;

        $objElement->cssID = [
            $objElement->cssID[0], 
            $objElement->cssID[1].' ' . implode(' ', $arrCustom)
        ];
        return $objElement->generate();
    }
}