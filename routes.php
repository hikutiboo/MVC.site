<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

return (function(){
    $intGT0 = '[1-9]+\d*';
    $text = '[0-9aA-zZ_-]+';

    return [
        [
            'regex' => '/^$/',
            'controller' => 'Messages\Index'
        ],
        [
            'regex' => '/^messages\/?$/',
            'controller' => 'Messages\Index'
        ],
        [
            'regex' => '/^messages\/add\/?$/',
            'controller' => 'Messages\Add'
        ],
        [
            'regex' => '/^accounts\/register\/?$/',
            'controller' => 'Accounts\Register'
        ]
    ];
})();