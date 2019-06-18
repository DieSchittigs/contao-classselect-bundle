<?php

$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace(
    '{expert_legend:hide}',
    '{design_legend},customClass;{expert_legend:hide}',
    $GLOBALS['TL_DCA']['tl_article']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_article']['fields']['customClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_article']['customClass'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => ['tl_article_helper', 'getClasses'],
    'eval'                    => array('tl_class'=>'w50', 'multiple' => true, 'chosen' => true),
    'sql'                     => "blob NULL"
];


class tl_article_helper extends tl_article
{
    public function getClasses()
    {
        $arrValues = unserialize($GLOBALS['TL_CONFIG']['classNames']);
        if(!is_array($arrValues)) return;

        $arrReturn = [];
        foreach($arrValues as $class) {
            if(!$class['showOnArticle']) continue;
            $arrReturn[$class['className']] = $class['classTitle'].' [' . $class['className'] . ']';
            
        }

        return $arrReturn;
    }
}
