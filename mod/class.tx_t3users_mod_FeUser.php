<?php
/**
 * @package tx_t3users
 * @subpackage tx_t3users_mod
 *
 *  Copyright notice
 *
 *  (c) 2011 DMK E-BUSINESS GmbH <dev@dmk-ebusiness.de>
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
 */

/**
 * benötigte Klassen einbinden
 */


tx_rnbase::load('tx_rnbase_mod_ExtendedModFunc');

/**
 * Backend Modul für Formulare
 *
 * @package tx_t3users
 * @subpackage tx_t3users_mod
 */
class tx_t3users_mod_FeUser extends tx_rnbase_mod_ExtendedModFunc
{

    /**
     * Method getFuncId
     *
     * @return string
     */
    public function getFuncId()
    {
        return 'feuser';
    }

    /**
     * Liefert die Einträge für das Tab-Menü.
     * return array
     */
    protected function getSubMenuItems()
    {
        $menuItems = array();
        $menuItems[] = tx_rnbase::makeInstance('tx_t3users_mod_handler_ManageFeUser');

        return $menuItems;
    }

    /**
     * @param string $selStr
     * @return bool
     */
    protected function makeSubSelectors(&$selStr)
    {
        return false;
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/t3users/mod/class.tx_t3users_mod_FeUser.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/t3users/mod/class.tx_t3users_mod_FeUser.php']);
}
