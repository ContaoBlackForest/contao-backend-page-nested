<?php
/**
 * Contao Backend Page Nested Menu
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @package   contaoblackforest/contao-backend-page-nested
 * @file      tl_page.php
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   LGPL-3.0+
 * @copyright ContaoBlackforest 2015
 */


/**
 * nested menu to tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['config']['label'] = \ContaoBlackforest\Backend\Page\Nested::addNestedPage($GLOBALS['TL_DCA']['tl_page']['config']['label']);
