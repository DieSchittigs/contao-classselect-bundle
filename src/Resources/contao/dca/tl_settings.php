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
                'inputType' => 'text',
                'eval'      => ['mandatory' => true, 'style' => 'width:200px' ],
            ],
            'className' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['className'],
                'inputType' => 'text',
                // Also does not work 'save_callback' => ['tl_settings_helper', 'checkClassname'],
                'eval'      => ['mandatory' => true, 'style' => 'width:200px']
            ],
            'showOnPage' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['showOnPage'],
                'inputType' => 'checkbox'
            ],
            'showOnArticle' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['showOnArticle'],
                'inputType' => 'checkbox'
            ],
            'showOnElement' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['showOnElement'],
                'inputType' => 'checkbox'
            ],
            /* Multicolumnwizard is Beta ... 
            'selectElement' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_settings']['classNames']['selectElement'],
                'inputType' => 'select',
                'default'   => 'all',
                'eval'      => [
                    'style'              => 'width:250px',
                    'chosen'             => true,
                    'multiple'           => true
                ],
                'options_callback'  => ['tl_settings_helper', 'getContentElements'],
                'reference' => &$GLOBALS['TL_LANG']['CTE'],
            ]*/
        ]
    ]
];

class tl_settings_helper extends tl_settings {
    public function getContentElements()
    {
		$groups = ['all'=> $GLOBALS['TL_LANG']['tl_settings']['classNames']['selectElement']['all']];
		foreach ($GLOBALS['TL_CTE'] as $k=>$v)
		{
			foreach (array_keys($v) as $kk)
			{
				$groups[$k][] = $kk;
			}
		}
		return $groups;
    }
    
    public function checkClassname($varValue, Contao\DataContainer $dc){

        //Make alphanumeric (removes all other characters)
        $varValue = preg_replace("/[^a-z0-9_\s-]/", "", $varValue);
        //Clean up multiple dashes or whitespaces
        $varValue = preg_replace("/[\s-]+/", " ", $varValue);
        //Convert whitespaces and underscore to dash
        $varValue = preg_replace("/[\s_]/", "-", $varValue);
        //First character must not be integer
        if(is_int(substr($varValue, 0, 1))) return "int-" . $varValue;

        return $varValue;
    }
}