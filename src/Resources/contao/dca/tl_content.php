<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['wrapperStart'] = '{type_legend},type,headline;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wrapperStop'] = '{type_legend},type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

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

// Automatically add a wrapper stop element
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = ['tl_content_helper','generateWrapperStop'];

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

    public function generateWrapperStop(DataContainer $dc)
    {
        if($dc->activeRecord->type != "wrapperStart") return;
        if(!empty($dc->activeRecord->tstamp)) return;

        $model = new \ContentModel();
        $model->type = 'wrapperStop';
        $model->ptable = $dc->activeRecord->ptable;
        $model->pid = $dc->activeRecord->pid;
        $model->tstamp = Date::floorToMinute();
        $model->sorting = $dc->activeRecord->sorting * 2;

        $model->save();
    }
}