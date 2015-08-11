<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_t3users_hooks_processDatamap.php:tx_t3users_hooks_processDatamap';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getMainFieldsClass'][] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_t3users_hooks_getMainFields.php:tx_t3users_hooks_getMainFields';

// Anpassung tslib_feuserauth
if (class_exists('ux_tslib_feuserauth')) {
	$reflector = new ReflectionClass("ux_tslib_feuserauth");
	// Exception werfen wenn bisherige XClass nicht die von t3users ist
	if (strpos($reflector->getFileName(), $_EXTKEY . '/xclasses/class.ux_tslib_feuserauth.php') === FALSE) {
		throw new LogicException(
			'There allready exists an ux_tslib_feuserauth XCLASS in the path ' .
			$reflector->getFileName() . ' !' .
			' Remove the other XCLASS or or the user record won\'t be filled with the beforelastlogin column'
		);
	}
}
require_once t3lib_extMgm::extPath($_EXTKEY, 'xclasses/class.ux_tslib_feuserauth.php');
tx_rnbase::load('tx_rnbase_util_TYPO3');
if (tx_rnbase_util_TYPO3::isTYPO60OrHigher()) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\Authentication\\FrontendUserAuthentication'] = array(
			'className' => 'ux_tslib_feuserauth'
	);
} else {
	$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['tslib/class.tslib_feuserauth.php'] =
		t3lib_extMgm::extPath($_EXTKEY).'xclasses/class.ux_tslib_feuserauth.php';
}

$tempPath = t3lib_extMgm::extPath('t3users');
require_once($tempPath.'services/ext_localconf.php');
?>
