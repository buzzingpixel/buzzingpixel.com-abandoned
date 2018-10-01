#!/bin/bash

################################################################################
# Kills the queue runner process. This script should be run on deploy AFTER
# release activation to make sure the script in the previous deploy is not
# running
################################################################################

BASEDIR=$(dirname "$0");
STORAGE_DIR="${BASEDIR}/storage";
PID_FILE="${STORAGE_DIR}/queueRunnerPid";

if [ -f ${PID_FILE} ]; then
    # PID_FILE exists

    # Get the PID_FILE ID
    PID=$(cat ${PID_FILE});

    # Check for the process ID running
    ps -p ${PID} > /dev/null 2>&1;

    # Did we find a process ID running?
    if [ $? -eq 0 ]; then
        sudo kill ${PID};
    fi
fi
