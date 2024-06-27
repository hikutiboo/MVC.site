<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

return (function () {
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
            'regex' => '/^messages\/censorship\/?$/',
            'controller' => 'Messages\Censorship'
        ],
        [
            'regex' => '/^accounts\/register\/?$/',
            'controller' => 'Accounts\Register'
        ],
        [
            'regex' => '/^accounts\/login\/?$/',
            'controller' => 'Accounts\Login'
        ],
        [
            'regex' => '/^accounts\/logout\/?$/',
            'controller' => 'Accounts\Logout'
        ],
        [
            'regex' => '/^accounts\/recover\/?$/',
            'controller' => 'Accounts\Recover'
        ],
        [
            'regex' => '/^terminal\/?$/',
            'controller' => 'Terminal\Terminal'
        ],
        [
            'regex' => '/^contacts\/?$/',
            'controller' => 'Contacts\Contacts'
        ],
        [
            'regex' => '/^messages\/edit\/?$/',
            'controller' => 'Messages\Edit'
        ]
    ];
})();