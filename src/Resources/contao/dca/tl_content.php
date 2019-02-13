<?php

foreach($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key => &$val) {
    if ($key == '__selector__' OR $key == 'default') continue;
    $val .= ';{autoitem_legend},hideOnItem';
}

$GLOBALS['TL_DCA']['tl_content']['fields']['hideOnItem'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hideOnItem'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('','no_item','only_item'),
    'eval'                    => array('tl_class'=>'w50'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_content']['hideOnItemOptions'],
    'sql'                     => "varchar(32) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['list']['operations']['autoitem'] = [
    'label'               => &$GLOBALS['TL_LANG']['tl_content']['hideOnItem'],
    'icon'                => 'always.svg',
    'button_callback'     => array('tl_content_autoitem', 'autoitemIcon')
];

class tl_content_autoitem extends tl_content
{
	public function autoitemIcon($row, $href, $label, $title, $icon, $attributes)
	{
        #return "icon";
        return $row['hideOnItem'];
        #return Image::getHtml('vendor/public/'.$row['hideOnItem'].'.png', $label);
    }
}