<?php
require_once 'env_loader.php';

if (!defined('EMAIL_API_KEY')) {
    define('EMAIL_API_KEY', env('EMAIL_API_KEY'));
}

if (!defined('EMAIL_API_URL')) {
    define('EMAIL_API_URL', env('EMAIL_API_URL'));
}
?>
