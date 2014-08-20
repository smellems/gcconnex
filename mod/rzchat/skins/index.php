<?php
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */
setlocale(LC_ALL, 'EN_US');
header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
header("Content-Type: application/x-shockwave-flash");

readfile("default.swf");
