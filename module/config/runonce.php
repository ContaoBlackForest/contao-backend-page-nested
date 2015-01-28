<?php
/**
 * Contao Backend Page Nested Menu
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @package   contaoblackforest/contao-backend-page-nested
 * @file      runonce.php
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   LGPL-3.0+
 * @copyright ContaoBlackforest 2015
 */


/**
 * Class testonce
 */
class runonce
{

	/**
	 * run once
	 */
	public function run()
	{
		foreach (array('assets/js', 'assets/css') as $dir)
		{
			// Purge the folder
			$objFolder = new \Folder($dir);
			$objFolder->purge();
		}
	}
}


$runOnce = new runonce();
$runOnce->run();
