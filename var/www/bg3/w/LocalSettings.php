<?php
require "/var/www/bg3/.secrets.php";

$devSite = (($_COOKIE['bg3wiki_dev'] ?? '') === $devModePwd);

if ( $devSite ) {
	require 'LocalSettings.dev.php';
} else {
	require 'LocalSettings.prod.php';
}
