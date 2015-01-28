<?php
/**
 * Contao Backend Page Nested Menu
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @package   contaoblackforest/contao-backend-page-nested
 * @file      Nested.php
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   LGPL-3.0+
 * @copyright ContaoBlackforest 2015
 */


namespace ContaoBlackforest\Backend\Page;

/**
 * Class Nested
 *
 * @package ContaoBlackforest\Backend\Page
 */
class Nested
{

	/**
	 * static cache var
	 *
	 * @var $pages
	 */
	protected static $pages;


	/**
	 * @param $string the original from tl_page
	 *
	 * @return string nested pages
	 */
	public static function addNestedPage($string)
	{
		static::getPages();

		$template = static::compile($string);

		return $template;
	}


	/**
	 * get all pages and cached by static::$pages
	 */
	protected static function getPages()
	{
		$result = \PageModel::findAll();

		if ($result) {
			while ($result->next()) {
				$buffer = $result->current();

				$trail = \PageModel::findBy('pid', $buffer->id);

				if ($trail) {
					$bufferTrail = array();

					while ($trail->next()) {
						$bufferTrail[$trail->sorting] = $trail->current();
					}

					$sort = array_keys($bufferTrail);
					array_multisort($sort);

					$arr = array();
					foreach ($sort as $v) {
						$arr[$v] = $bufferTrail[$v];
					}
					$buffer->__set('trail', $arr);
				}

				static::$pages[$result->pid][$result->sorting] = $buffer;
			}

			static::sortPages();
		}
	}


	/**
	 * sort pages by sorting
	 */
	protected static function sortPages()
	{
		if (count(static::$pages)) {
			foreach (static::$pages as $k => $v) {
				$sort = array_keys(static::$pages[$k]);
				array_multisort($sort);

				$buffer = array();
				foreach ($sort as $vv) {
					$buffer[$vv] = $v[$vv];
				}

				static::$pages[$k] = $buffer;
			}

			static::$pages = static::$pages[0];
		}
	}


	/**
	 * @param $string from tl_page
	 *
	 * @return string rendered template
	 */
	protected static function compile($string)
	{
		return static::render($string, static::$pages);
	}


	/**
	 * rendered the template
	 *
	 * @param     $string from tl_page
	 * @param     $pages  array of pages
	 * @param int $level  level for the menu
	 *
	 * @return string template
	 */
	protected function render($string, $pages, $level = 0)
	{
		$level++;

		if (!count($pages) && $level === 1) {
			return $string;
		}

		foreach ($pages as $key => $page) {
			$image                     = \Controller::getPageStatusIcon((object) $page);
			$pages[$key]->status_image = \Image::getHtml($image);

			if (count($page->trail)) {
				$pages[$key]->sub_pages = static::render($string, $page->trail, $level);
			}
		}

		$template = new \TwigTemplate('backend/nested_pages', 'html5');

		$data = array(
			'lang'   => $GLOBALS['TL_LANG'],
			'level'  => $level,
			'pages'  => $pages,
			'string' => $string,
			'do' => \Input::get('do')
		);

		return $template->parse($data);
	}


	/**
	 * add assets to the backend page
	 *
	 * @param $content
	 * @param $strKey
	 * @param $strMode
	 * @param $arrFile
	 *
	 * @return string
	 */
	public function combine($content, $strKey, $strMode, $arrFile)
	{
		if (TL_MODE === 'BE' && $strMode === '.css') {
			if (file_exists(TL_ROOT . '/assets/contaoblackforest/contao-backend-page-nested/css/style.min.css')) {
				$file    = new \File('assets/contaoblackforest/contao-backend-page-nested/css/style.css');
				$content = $content . "\n" . $file->getContent();

				unset($GLOBALS['TL_HOOKS']['getCombinedFile']['contao-backend-page-nested']);
			}
		}

		return $content;
	}
} 