<?php

use cri2net\email\Email;

$conf = require(__DIR__ . '/email.conf.php');
$email = new Email($conf);
$email->sendEmailByCron();
