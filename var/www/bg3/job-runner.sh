#!/bin/sh

MW_INSTALL_PATH=/var/www/bg3/w

RUNJOBS=$MW_INSTALL_PATH/maintenance/runJobs.php

echo Starting job service...

renice +19 $$

# Wait a bit to give other things time to get started
sleep 20

echo Started.

while true
do
	# Job types that need to be run ASAP
	php "$RUNJOBS" --type="enotifNotify"

	php "$RUNJOBS" --wait --maxjobs=20

	sleep 5
done
