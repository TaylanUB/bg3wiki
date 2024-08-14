<?php
if ( $_SERVER['SERVER_NAME'] === 'dev.bg3.wiki' ) {
	require 'LocalSettings.dev.php';
} else {
	require 'LocalSettings.prod.php';
}
