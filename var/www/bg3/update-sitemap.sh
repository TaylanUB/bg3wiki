#!/bin/sh

cd /var/www/bg3 || exit

php w/maintenance/run.php \
	generateSitemap -q \
	--fspath=sitemap \
	--urlpath=sitemap \
	--skip-redirects \
	--compress=no

mv sitemap/sitemap-index-bg3wiki.xml sitemap.xml
