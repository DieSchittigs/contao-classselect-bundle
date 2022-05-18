<?php
use DieSchittigs\DieSchittigsHelpers\ClassesModel;

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

        $objClasses = ClassesModel::findByShowOnPage(1);
        
        if($objClasses === null) return;

        $arrReturn = [];
        while($objClasses->next()) {
            $arrReturn[$objClasses->id] = $objClasses->name.' [' . $objClasses->cssClass . ']';
        }

        return $arrReturn;
    }
}
