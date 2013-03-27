<?php

class AccesLevel {

    protected $_accessLevels = array(
        '~' => array(
            'mode' => 'q',
        ),
        '&' => array(
            'mode' => 'a',
        ),
        '@' => array(
            'mode' => 'o',
        ),
        '%' => array(
            'mode' => 'h',
        ),
        '+' => array(
            'mode' => 'v',
        ),
    );

}