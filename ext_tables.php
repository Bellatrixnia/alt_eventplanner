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
});


// Register backend module for creating events

if (TYPO3_MODE === 'BE') {
    // Module Web > Create Events
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'ALT.AltEventplanner',
        'web',
        'CreateEvent',
        'bottom',
        array(
            // Output at the Backendmodul
            // Name of the Controller => favored Action(s) (more than one has to be comma seperatet)
            'CreateEvent' => 'showForm, submit, saveEvent'
        ),
        array(
            'access' => '',
            'icon' => 'EXT:alt_eventplanner/Resources/Public/Icons/event.svg',
            'labels' => 'LLL:EXT:alt_eventplanner/Resources/Private/Language/locallang_mod.xlf'
        )
    );
}