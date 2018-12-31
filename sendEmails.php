<?php

require dirname(__FILE__) .'/vendor/autoload.php';

// adding an external config file
require dirname(__FILE__) .'/config.php';

require dirname(__FILE__) .'/data/generated-conf/config.php';

echo dirname(__FILE__).'/html/email-content.php';

\app\utils\Mail::sendPostListToSubscribers();
