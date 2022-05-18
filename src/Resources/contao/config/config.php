<?php

/**
 * Contao ClassSelect Modules Set
 *
 * Copyright (c) 2017 Die Schittigs
 *
 * @license LGPL-3.0+
 */
use DieSchittigs\DieSchittigsHelpers\ClassesModel;

if (TL_MODE=="BE") {
    $GLOBALS['TL_CSS'][] = 'bundles/contaohelper/backend.css';
}

$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_classes';

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

$GLOBALS['TL_MODELS']['tl_classes'] = ClassesModel::class;
