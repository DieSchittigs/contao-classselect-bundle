<?php

/**
 * Contao ClassSelect Modules Set
 *
 * Copyright (c) 2017 Die Schittigs
 *
 * @license LGPL-3.0+
 */


$GLOBALS['TL_HOOKS']['getArticle'][] = array('DieSchittigs\\DieSchittigsHelpers\\HelperClass', 'addClassesToArticle');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('DieSchittigs\\DieSchittigsHelpers\\HelperClass', 'addClassesToElement');