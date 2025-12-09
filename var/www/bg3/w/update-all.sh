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

core=
ext=
fetch=
merge=
while [ $# -gt 0 ]
do
	case $1 in
		(--core)
			core=yes
			;;
		(--ext)
			ext=yes
			;;
		(--fetch)
			fetch=yes
			;;
		(--merge)
			merge=yes
			;;
		(*)
			echo >&2 "Unknown flag: $1"
			exit 1
	esac
	shift
done

if [ -z "$core" ] && [ -z "$ext" ]
then
	echo >&2 "Select at least one of --core or --ext for upgrading."
	exit 1
fi

if [ -z "$fetch" ] && [ -z "$merge" ]
then
	echo >&2 "Select at least one of --fetch or --merge as the action."
	exit 1
fi

if [ "$fetch" ]
then
	echo
	echo
	echo ==============
	echo == Fetching ==
	echo ==============
	echo
	if [ "$core" ]
	then
		echo
		echo '== MediaWiki Core & Submodules =='
		echo

		wgit fetch -p --recurse-submodules
	fi

	if [ "$ext" ]
	then
		echo
		echo '== MediaWiki Extensions =='
		echo

		for d in extensions/*/.git/
		do
		(
			cd "$d/.."
			printf 'Extension: %s\n' "$(basename "$PWD")"

			wgit fetch -p
		)
		done
	fi
fi

if ! [ "$merge" ]
then
	echo
	echo 'Done fetching; not merging.'
	echo
	exit
fi

echo
echo
echo =============
echo == Merging ==
echo =============
echo
echo

if [ "$core" ]
then
	echo
	echo '== MediaWiki Core & Submodules =='
	echo

	rm vendor/.git

	wgit merge --ff-only
	wgit submodule update --recursive

	echo
	echo 'Running composer update'
	echo

	wsudo composer update --no-dev

	echo
	echo 'Running update maintenance script'
	echo

	wsudo php maintenance/update.php --quick

	echo
	echo 'PHP opcache reset'
	echo

	curl http://localhost/php-control?opcache_reset
fi

if ! [ "$ext" ]
then
	echo
	echo 'Done; not updating extensions.'
	echo
	exit
fi

echo
echo
echo == MediaWiki Extensions ==
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
