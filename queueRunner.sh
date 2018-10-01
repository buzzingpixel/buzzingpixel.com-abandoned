#!/bin/bash

################################################################################
# Continuously runs the craft queue until the process is stopped.

# This script checks to see if it is already running so you can safely run it on
# a cron every 60 seconds. If something killed the process, the cron will pick
# it up again
################################################################################

# We don't want this process overlapping #

BASEDIR=$(dirname "$0");
STORAGE_DIR="${BASEDIR}/storage";
PID_FILE="${STORAGE_DIR}/queueRunnerPid";

# Check for existence of PID_FILE
if [ -f ${PID_FILE} ]; then
    # PID_FILE exists

    # Get the PID_FILE ID
    PID=$(cat ${PID_FILE});

    # Check for the process ID running
    ps -p ${PID} > /dev/null 2>&1;

    # Did we find a process ID running?
    if [ $? -eq 0 ]; then
        echo 'Queue is already running';
        exit;
    else
        ## Process not found assume not running

        # Echo out the process ID to the pid file
        echo $$ > ${PID_FILE};

        # Error if we can't create the pid file
        if [ $? -ne 0 ]; then
            echo 'Could not create PID file';
            exit 1;
        fi
    fi
else
    # Echo out the process ID to the pid file
    echo $$ > ${PID_FILE};

    # Error if we can't create the pid file
    if [ $? -ne 0 ]; then
        echo 'Could not create PID file';
        exit 1;
    fi
fi

# Run the queue every second infinitely
while true; do
    php ${BASEDIR}/craft queue/run;
    sleep 1;
done
