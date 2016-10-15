<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied!');
}

// NEVER! use namespaces or use statements in this file!

call_user_func(function () {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ALT.AltEventplanner',
        'Calendar',
        [
            'Calendar' => 'show, signup',
        ]
    );

});