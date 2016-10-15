<?php
return array(
    'ctrl' => array(
        'label' => 'title',
        'tstamp' => 'tstamp',
        'title' => 'Termin',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY title',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:alt_eventplanner/Resources/Public/Icons/event.svg',
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
        'title' => array(
            'label' => 'Titel',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'max' => '100',
                'eval' => 'trim,required'
            )
        ),
        'begin' => [
            'label' => 'Beginn',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'max' => '100',
                'eval' => 'trim,required,datetime'
            )
        ],
        'end' => [
            'label' => 'Ende',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'max' => '100',
                'eval' => 'trim,required,datetime'
            )
        ],
        'minimum_volunteers' => [
            'label' => 'Minimale Anzahl Freiwilliger',
            'config' => array(
                'type' => 'radio',
                'items' => array(
                    array('1',1),
                    array('2',2),
                    array('3',3),
                    array('4',4),
                    array('5',5),
                    array('6',6),
                )
            )
        ],
        'sign_ups' => array(
            'label' => 'Anmeldungen',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_alteventplanner_domain_model_signup',
                'foreign_field' => 'event_uid',
                'appearance' => array(
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'useSortable' => true,
                    'enabledControls' => true
                )
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'disable, title, begin, end, minimum_volunteers, sign_ups'),
    )
);