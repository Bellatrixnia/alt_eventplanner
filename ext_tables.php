<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied!');
}

// NEVER! use namespaces or use statements in this file!

call_user_func(function () {

    // Register frontend plugin.
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'ALT.AltEventplanner',
        'Calendar',
        'Calendar'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'ALT.AltEventplanner',
        'Signup',
        'Signup'
    );
});