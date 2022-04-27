<?php

date_default_timezone_set("Europe/Paris");

define("KB", 1024);
define("MB", 1048576);
define("GB", 1073741824);
define("TB", 1099511627776);
define("MAXIMUM_SIZE", 1*MB);
define("MAXIMUM_SIZE_STRING", (string)(round(MAXIMUM_SIZE / MB, 2)) . "MB");