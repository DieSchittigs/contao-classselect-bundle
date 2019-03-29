<?php

namespace DieSchittigs\DieSchittigsHelpers;
use Contao\CoreBundle\Exception\PageNotFoundException;
class HelperClass extends \Frontend
{
    public function addClassesToPage($objPage, $objLayout, $objPageRegular){
        if (!is_array($arrCustom = unserialize($objPage->customClass))) return;
        $objPage->cssClass .= ' ' . implode(' ', $arrCustom);
    }

    public function addClassesToArticle($objRow){
        
        $arrCss = unserialize($objRow->cssID);
        
        if (!is_array($arrCustom = unserialize($objRow->customClass))) return;
        $arrCss[1] .= ' ' . implode(' ', $arrCustom);
        $objRow->cssID = serialize($arrCss);
    }

    public function addClassesToElement($objRow, $strBuffer, $objElement){
        if (!is_array($arrCustom = unserialize($objElement->customClass))) return $strBuffer;
        $strBuffer = str_replace('class="ce_', 'class="ce_' . $objElement->type . ' ' . implode(' ', $arrCustom) . ' ', $strBuffer);
        return $strBuffer;
    }
}