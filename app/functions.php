<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Create value-object \Magento\Framework\Phrase
 *
 * @return \Magento\Framework\Phrase
 */
function __()
{
    $argc = func_get_args();

    $text = array_shift($argc);
    if (!empty($argc) && is_array($argc[0])) {
        $argc = $argc[0];
    }

    return new \Magento\Framework\Phrase($text, $argc);
}

function __debug()
{
    $argc = func_get_args();
    if(is_array($argc[0])){
        echo (json_encode($argc[0], JSON_PRETTY_PRINT));
        header('Content-Type: application/json');
        exit;
    }

    print_r($argc[0]);
    exit;
}
