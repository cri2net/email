<?php

use cri2net\email\Email;

$conf = require(__DIR__ . '/email.conf.php');
$mail = new Email($conf);

$mail->send(
    ['user@example.com', "Dear User"],
    'Example Subject',
    '', // raw_content
    'restore_password', // template
    [
        // replaces
        'username' => "Dear User",
        'email'    => "user@example.com",
        'href'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    ]
);

