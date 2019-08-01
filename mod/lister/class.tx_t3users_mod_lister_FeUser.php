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

tx_rnbase::load('Tx_Rnbase_Backend_Lister_AbstractLister');

/**
 * Hilfsklassen um nach Landkreisen im BE zu suchen
 *
 * @package tx_t3users
 * @subpackage tx_t3users_mod
 */
class tx_t3users_mod_lister_FeUser extends Tx_Rnbase_Backend_Lister_AbstractLister
{
    /** @var array */
    private $options;

    /** @var tx_t3users_mod_util_Selector */
    private $selector;

    /**
     * Liefert die Funktions-Id
     */
    public function getSearcherId()
    {
        return 'feuser';
    }

    /**
     * Liefert den Service.
     *
     * @return tx_t3users_srv_Base
     */
    protected function getService()
    {
        return tx_t3users_util_ServiceRegistry::getFeUserService();
    }


    /**
     * Returns the repository
     *
     * @return Tx_Rnbase_Domain_Repository_InterfaceSearch
     */
    protected function getRepository()
    {
        return $this->getService();
    }

    /**
     * Returns the complete search form
     * @return  string
     */
    protected function addMoreFields(&$data, &$options)
    {
        $this->options['pid'] = $this->getModule()->getPid();
        if (isset($this->options['pid'])) {
            $options['pid'] = $this->options['pid'];
        }
        $selector = $this->getSelector();

        $out = $this->buildFilterTable($data);

        return $out;
    }


    /**
     * Der Selector wird erst erzeugt, wenn er benötigt wird
     *
     * @return  tx_t3users_mod_util_Selector
     */
    protected function getSelector()
    {
        if (!$this->selector) {
            $this->selector = tx_rnbase::makeInstance('tx_t3users_mod_util_Selector');
            $this->selector->init($this->getModule());
        }

        return $this->selector;
    }

    /**
     * (non-PHPdoc)
     * @see tx_t3users_mod_searcher_abstractBase::getSearchColumns()
     */
    protected function getSearchColumns()
    {
        return array('FEUSER.uid', 'FEUSER.username', 'FEUSER.first_name',
                'FEUSER.last_name', 'FEUSER.email', 'FEUSER.address',
                'FEUSER.zip', 'FEUSER.company', 'FEUSER.www',
                'FEUSER.telephone', 'FEUSER.city');
    }

    /**
     * Liefert die Spalten für den Decorator.
     * @param array $columns
     *
     * @return array
     */
    protected function addDecoratorColumns(
        array &$columns
    ) {
        $sTableAlias = 'FEUSER.';
        $decorator = $this->getDecorator();
        $columns['uid'] = array(
            'title' => '',
            'decorator' => $decorator,
            'sortable' => $sTableAlias
        );
        $columns['actions'] = array(
            'title' => 'label_tableheader_actions',
            'decorator' => $decorator,
        );
        $columns['username'] = array(
            'title' => 'label_tableheader_username',
            'decorator' => $decorator,
            'sortable' => $sTableAlias
        );
        $columns['first_name'] = array(
            'title' => 'label_tableheader_firstname',
            'decorator' => $decorator,
            'sortable' => $sTableAlias
        );
        $columns['last_name'] = array(
            'title' => 'label_tableheader_lastname',
            'decorator' => $decorator,
            'sortable' => $sTableAlias
        );
        $columns['usergroup'] = array(
            'title' => 'label_tableheader_usergroup',
            'decorator' => $decorator
        );

        return $columns;
    }

    /**
     *
     * @return tx_rnbase_mod_IDecorator
     */
    protected function getDecoratorClass()
    {
        return 'tx_t3users_mod_decorator_FeUser';
    }

    /**
     * Kann von der Kindklasse überschrieben werden, um weitere Filter zu setzen.
     *
     * @param   array   $fields
     * @param   array   $options
     */
    protected function prepareFieldsAndOptions(array &$fields, array &$options)
    {
        parent::prepareFieldsAndOptions($fields, $options);

        if ($this->options['pid']) {
            $fields['FEUSER.pid'][OP_EQ_INT] = $this->options['pid'];
        }

        // mehr Filter per Hook
        tx_rnbase_util_Misc::callHook(
            't3users',
            'mod_feuser_addFieldsAndOptions',
            array(
                'fields' => &$fields,
                'options' => &$options,
                'filter' => $this->getFilter(),
            ),
            $this
        );
    }

    /**
     * Liefert die Daten für das Basis-Suchformular damit
     * das Html gebaut werden kann
     *
     * @return array
     */
    protected function getSearchFormData()
    {
        $data = parent::getSearchFormData();
        // mehr Filter per Hook
        tx_rnbase_util_Misc::callHook(
            't3users',
            'mod_feuser_addSearchFormData',
            array(
                'data' => &$data,
                'module' => $this->getModule(),
                'filter' => $this->getFilter(),
            ),
            $this
        );

        return $data;
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/t3users/mod/lister/class.tx_t3users_mod_lister_FeUser.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/t3users/mod/lister/class.tx_t3users_mod_lister_FeUser.php']);
}
