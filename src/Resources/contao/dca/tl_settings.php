<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = 
    str_replace(
        '{frontend_legend}', 
        '{classname_legend},classNames;{frontend_legend}', 
        $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
);


$GLOBALS['TL_DCA']['tl_settings']['fields']['classNames'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames'],
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'columnFields' => [
            
            'classTitle' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['classTitle'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => ['style' => 'width:200px' ],
            ],
            'className' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['className'],
                'inputType' => 'text',
                'eval'      => ['style' => 'width:200px']
            ],
            'showOnArticle' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['showOnArticle'],
                'inputType' => 'checkbox'
            ],
            'showOnElement' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['showOnElement'],
                'inputType' => 'checkbox'
            ],
            'selectElement' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['selectElement'],
                'inputType' => 'select',
                'eval'      => [
                    'style'              => 'width:250px',
                    'includeBlankOption' => true,
                ],
                'options_callback'  => array('tl_settings_own', 'getContentElements') 
            ]

        ],
    ]
];

class tl_settings_own extends tl_settings {
    public function getContentElements()
    {
		$groups = array();
		foreach ($GLOBALS['TL_CTE'] as $k=>$v)
		{
			foreach (array_keys($v) as $kk)
			{
				$groups[$k][] = $kk;
			}
		}
		return $groups;
	}
}