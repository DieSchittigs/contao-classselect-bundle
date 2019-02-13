<?php

namespace DieSchittigs\DieSchittigsHelpers;
use Contao\CoreBundle\Exception\PageNotFoundException;
class HelperClass extends \Frontend
{
    public function addClassesToArticle($objRow){
        
        $arrCss = unserialize($objRow->cssID);
        $arrCss[1] .= ' ' . implode(' ', unserialize($objRow->customClass));
        $objRow->cssID = serialize($arrCss);
    }


    public function addClassesToElement($objRow, $strBuffer, $objElement){
        
        $objElement->cssID = [
            $objElement->cssID[0], 
            $objElement->cssID[1].' ' . implode(' ', unserialize($objElement->customClass))
        ];
        return $objElement->generate();
    }
}