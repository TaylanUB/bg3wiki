#!/bin/bash

set -e

MW_PATH=/var/www/bg3/w

if [ "$(pwd)" != "$MW_PATH" ]
then
	echo "Run this from: $MW_PATH"
	exit 1
fi

wsudo() {
	sudo -u www-data "$@"
}

wgit() {
	wsudo git "$@"
}

echo
echo
echo ========================
echo == Pre-fetching repos ==
echo ========================
echo
echo
echo 'MediaWiki Core & Submodules'
echo

wgit fetch --recurse-submodules

echo
echo 'MediaWiki Extensions'
echo

for d in extensions/*/.git/
do (
	cd "$d/.."
	printf 'Extension: %s\n' "$(basename "$PWD")"

	wgit fetch
) done

echo
echo
echo ===============================
echo == Starting MediaWiki update ==
echo ===============================
echo
echo

wgit merge --ff-only
wgit submodule update --recursive

echo
echo 'Running composer update'
echo

rm vendor/.git
wsudo composer update --no-dev

echo
echo 'Running update maintenance script'
echo

wsudo php maintenance/update.php --quick

echo
echo 'PHP opcache reset'
echo

curl http://localhost/php-control?opcache_reset

echo
echo
echo ===========================
echo == MediaWiki update done ==
echo ==  Updating extensions  ==
echo ===========================
echo
echo

for d in extensions/*/.git/
do (
	cd "$d/.."
	printf 'Extension: %s\n' "$(basename "$PWD")"

	if [ "$(wgit branch --show-current)" = "" ]
	then
		echo "Detached HEAD; nothing to do."
	else
		wgit merge --ff-only

		if [ -e composer.json ]
		then
			echo
			echo 'Running composer update'
			echo

			wsudo composer update --no-dev
		fi
	fi

	echo
) done

echo
echo 'Running update maintenance script'
echo

# In case an extension requires it
wsudo php maintenance/update.php --quick

echo
echo 'PHP opcache reset'
echo

curl http://localhost/php-control?opcache_reset

echo
echo
echo ==============
echo == All done ==
echo ==============
echo
echo 'Third-party skins not updated automatically.'
echo 'Update complex skins like Citizen manually, and test thoroughly!'
echo
