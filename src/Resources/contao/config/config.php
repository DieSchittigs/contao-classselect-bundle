<?php

/**
 * Contao ClassSelect Modules Set
 *
 * Copyright (c) 2017 Die Schittigs
 *
 * @license LGPL-3.0+
 */

if (TL_MODE=="BE") {
    $GLOBALS['TL_CSS'][] = 'bundles/contaohelper/backend.css';
}



// Own Wrapper
$GLOBALS['TL_CTE']['wrapper'] = [
    'wrapperStart' => 'DieSchittigs\DieSchittigsHelpers\ContentWrapperStart',
    'wrapperStop' => 'DieSchittigs\DieSchittigsHelpers\ContentWrapperStop'
];

$GLOBALS['TL_WRAPPERS']['start'][] = 'wrapperStart';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'wrapperStop';

// CSS class replacement
$GLOBALS['TL_HOOKS']['generatePage'][] = array('DieSchittigs\\DieSchittigsHelpers\\HelperClass', 'addClassesToPage');
$GLOBALS['TL_HOOKS']['getArticle'][] = array('DieSchittigs\\DieSchittigsHelpers\\HelperClass', 'addClassesToArticle');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('DieSchittigs\\DieSchittigsHelpers\\HelperClass', 'addClassesToElement');
