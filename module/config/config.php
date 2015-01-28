<?php
/**
 * Contao Backend Page Nested Menu
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @package   contaoblackforest/contao-backend-page-nested
 * @file      config.php
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   LGPL-3.0+
 * @copyright ContaoBlackforest 2015
 */


/**
 * assets files to combine
 */
$GLOBALS['TL_HOOKS']['getCombinedFile']['contao-backend-page-nested'] = array('\ContaoBlackforest\Backend\Page\Nested', 'combine');
