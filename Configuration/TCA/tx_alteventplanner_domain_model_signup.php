<?php
return array(
    'ctrl' => array(
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'title' => 'SignUp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY uid',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:alt_eventplanner/Resources/Public/Icons/volunteer.svg',
    ),
    'interface' => array(
        'showRecordFieldList' => 'title'
    ),
    'columns' => array(
        'hidden' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.disable',
            'config' => array(
                'type' => 'check'
            )
        ),
        'frontenduser_uid' => array(
            'label' => 'Nutzer',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => '1',
                'maxitems' => '1',
                'minitems' => '1',
                'show_thumbs' => '1',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            ]
        ),
        'event_uid' => [
            'label' => 'Event',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_alteventplanner_domain_model_event',
                'size' => '1',
                'maxitems' => '1',
                'minitems' => '1',
                'show_thumbs' => '1',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            ]
        ],
        'signup_type' => [
            'label' => 'Art der Anmeldung',
            'config' => array(
                'type' => 'radio',
                'items' => array(
                    array('Ja, ich helfe auf jeden Fall',1),
                    array('Wenn Hilfe gebraucht wird, ruft mich bitte an',2),
                    array('Nein, ich helfe auf keinen Fall',3),
                )
            )
        ],
    ),
    'types' => array(
        '0' => array('showitem' => 'frontenduser_uid, event_uid, signup_type'),
    )
);