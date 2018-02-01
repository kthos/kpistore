<?php
return [
    'name' => 'Klongthom Hospital KPI',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:d/m/Y H:i:s',
            'timeFormat' => 'php:H;i:s',
            'timeZone' => 'Asia/Bangkok',        
        ],

    ],
    
    /**NONT**/
    
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            //'enableUnconfirmedLogin' => false,
            //'confirmWithin' => 21600,
            //'cost' => 12,
            //'admins' => ['admin']
            'modelMap' => [
                'RegistrationForm' => 'common\models\RegistrationForm',
            ]
        ],
    ],
    
];
