<?php
require_once 'utils.php';

session_start();
session_destroy();
res("success", 200, 'Loggout');
