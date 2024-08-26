#!/bin/bash

set -e

if [ "$(pwd)" != /var/www/bg3/w ]
then
	echo 'Run this from: /var/www/bg3/w'
	exit 1
fi

wsudo() {
	sudo -u www-data "$@"
}

echo
echo
echo ========================
echo == Pre-fetching repos ==
echo ========================
echo
echo

echo 'MediaWiki core & submodules'
wsudo git fetch --recurse-submodules

for e in extensions/*/.git/
do
	d=${e%/.git/}
	printf '%s\n' "$d"

	cd "$d"

	wsudo git fetch

	cd "$OLDPWD"
done

echo
echo
echo ===============================
echo == Starting MediaWiki update ==
echo ===============================
echo
echo

wsudo git pull --recurse-submodules

rm vendor/.git
wsudo composer update --no-dev

wsudo php maintenance/update.php --quick

curl http://localhost/php-control?opcache_reset

echo
echo
echo ===========================
echo == MediaWiki update done ==
echo ==  Updating extensions  ==
echo ===========================
echo
echo

for e in extensions/*/.git/
do
	d=${e%/.git/}
	printf '\n%s\n\n' "$d"

	cd "$d"

	wsudo git pull

	if [ -e composer.json ]
	then
		wsudo composer update --no-dev
	fi

	cd "$OLDPWD"
done

# In case an extension requires it
wsudo php maintenance/update.php --quick

curl http://localhost/php-control?opcache_reset

echo
echo
echo ======================
echo == All updates done ==
echo ======================
echo
echo