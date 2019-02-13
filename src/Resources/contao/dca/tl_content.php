<?php

foreach($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key => &$val) {
    if ($key == '__selector__' OR $key == 'default') continue;
    $val = str_replace('{expert_legend:hide}','{design_legend},customClass;{expert_legend:hide}', $val);
}

$GLOBALS['TL_DCA']['tl_content']['fields']['customClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['customClass'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => ['tl_content_helper', 'getClasses'],
    'eval'                    => array('tl_class'=>'w50', 'multiple' => true, 'chosen' => true),
    'sql'                     => "blob NULL"
];



class tl_content_helper extends tl_content
{
    public function getClasses()
    {
        $arrValues = unserialize($GLOBALS['TL_CONFIG']['classNames']);
        if(!is_array($arrValues)) return;

        $arrReturn = [];
        foreach($arrValues as $class) {
            if(!$class['showOnElement']) continue;
            
            $arrReturn[$class['className']] = $class['classTitle'].' [.' . $class['className'] . ']';
            
        }

        return $arrReturn;
    }
}