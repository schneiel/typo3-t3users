<?php
tx_rnbase_util_Extensions::addPiFlexFormValue('tx_t3users_main', 'FILE:EXT:t3users/Configuration/Flexform/flexform_main.xml');

tx_rnbase_util_Extensions::addPlugin(array('LLL:EXT:t3users/locallang_db.xml:plugin.t3users.label','tx_t3users_main'), 'list_type', 't3users');
tx_rnbase_util_Extensions::addStaticFile('t3users', 'static/ts/', 'FE User Management');
