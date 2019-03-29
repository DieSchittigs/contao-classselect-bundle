<?php

$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace(
    '{expert_legend:hide}',
    '{design_legend},customClass;{expert_legend:hide}',
    $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['customClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['customClass'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => ['tl_page_helper', 'getClasses'],
    'eval'                    => array('tl_class'=>'w50', 'multiple' => true, 'chosen' => true),
    'sql'                     => "blob NULL"
];


class tl_page_helper extends tl_page
{
    public function getClasses()
    {
        $arrValues = unserialize($GLOBALS['TL_CONFIG']['classNames']);
        if(!is_array($arrValues)) return;

        $arrReturn = [];
        foreach($arrValues as $class) {
            if(!$class['showOnPage']) continue;
            $arrReturn[$class['className']] = $class['classTitle'].' [.' . $class['className'] . ']';
            
        }

        return $arrReturn;
    }
}