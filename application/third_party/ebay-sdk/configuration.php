<?php
/**
 * Configuration settings used by all of the examples.
 *
 * Specify your eBay application keys in the appropriate places.
 *
 * Be careful not to commit this file into an SCM repository.
 * You risk exposing your eBay application keys to more people than intended.
 */

// devId,appId,certId define in constants.php

return [
    'sandbox' => [
        'credentials' => [
            'devId' => devId,
            'appId' => appId,
            'certId' => certId,
        ],
        'ruName' => ruName
    ],
    'production' => [
        'credentials' => [
            'devId' => devId,
            'appId' => appId,
            'certId' => certId,
        ],
        'ruName' => 'http://ebay.local/'
    ]
];