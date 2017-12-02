<?php
/**
 * Настройки для работы почты. Ключи соответсвуют ключам в phpmailer
 */
return [
    'folder'      => PROTECTED_DIR . '/email_templates',
    'lang'        => 'ru',

    'Username'    => 'info@example.com',
    'ReturnPath'  => 'info@example.com',
    'Password'    => '123',
    'SMTPSecure'  => 'tls',
    'Host'        => 'smtp.gmail.com',
    'Port'        => 25,
    'SMTPAuth'    => true,
    'Mailer'      => 'smtp',
    'From'        => 'info@example.com',
    'FromName'    => 'My Site',
    // 'SMTPDebug'   => 3,
    'Debugoutput' => function($str, $level) {
        error_log($str . "\r\n", 3, PROTECTED_DIR . '/logs/_smtp.log');
    },
];
