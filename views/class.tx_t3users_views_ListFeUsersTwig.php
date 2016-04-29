<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Rene Nitzsche (dev@dmk-ebusiness.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


tx_rnbase::load('tx_rnbase_view_Base');
tx_rnbase::load('tx_rnbase_util_ListBuilder');


/**
 * Viewclass to show a list of users.
 * Isn't it tiny! ;-)
 */
class tx_t3users_views_ListFeUsersTwig {
	function render($view, &$configurations){
		Twig_Autoloader::register();

		$loader = new Twig_Loader_Filesystem(tx_rnbase_util_Files::getFileAbsFileName($this->pathToTemplates));
		$twig = new Twig_Environment($loader, array(
//				'cache' => PATH_site .'typo3temp/',
		));
		$template = $twig->loadTemplate('userlist.html');

		$viewData =& $configurations->getViewData();
    $users =& $viewData->offsetGet('userlist');
		$result = $template->render(array('users' => $users));
		tx_rnbase_util_Debug::debug($result, __FILE__.':'.__LINE__); // TODO: remove me
		return $result;
	}

  /**
   * Erstellen des Frontend-Outputs
   */
	function createOutput($template, &$viewData, &$configurations, &$formatter){


    // Die ViewData bereitstellen
    $users =& $viewData->offsetGet('userlist');
	  $listBuilder = tx_rnbase::makeInstance('tx_rnbase_util_ListBuilder');

    $out = $listBuilder->render($users,
    								$viewData, $template, 'tx_t3users_util_FeUserMarker',
    								'feuserlist.feuser.', 'FEUSER', $formatter);
    return $out;
  }

	/**
	 * Set the path of the template directory
	 *
	 * You can make use the syntax EXT:myextension/somepath.
	 * It will be evaluated to the absolute path by tx_rnbase_util_Files::getFileAbsFileName()
	 *
	 * @param string path to the directory containing the php templates
	 * @return void
	 * @see intro text of this class above
	 */
	public function setTemplatePath($pathToTemplates) {
		$this->pathToTemplates = $pathToTemplates;
	}
	/**
	 * Set the path of the template file.
	 *
	 * You can make use the syntax EXT:myextension/template.php
	 *
	 * @param string path to the file used as templates
	 * @return void
	 */
	public function setTemplateFile($pathToFile) {
		$this->_pathToFile = $pathToFile;
	}

  /**
   * Returns the template to use.
   * If TemplateFile is set, it is preferred. Otherwise
   * the filename is build from pathToTemplates, the templateName and $extension.
   *
   * @param string name of template
   * @param string file extension to use
   * @return complete filename of template
   */
  protected function getTemplate($templateName, $extension = '.php', $forceAbsPath = 0) {
  	if (strlen($this->_pathToFile) > 0) {
  		return ($forceAbsPath) ? tx_rnbase_util_Files::getFileAbsFileName($this->_pathToFile) : $this->_pathToFile;
  	}
  	$path = $this->pathToTemplates;
  	$path .= substr($path, -1, 1) == '/' ? $templateName : '/' . $templateName;
  	$extLen = strlen($extension);
  	$path .= substr($path, ($extLen * -1), $extLen) == $extension ? '' : $extension;
  	return $path;
  }

}

