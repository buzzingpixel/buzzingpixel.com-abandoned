// Make sure FAB is defined
window.FAB = window.FAB || {};

function runMain(F) {
    'use strict';

    if (! window.jQuery ||
        ! F.controller ||
        ! F.model
    ) {
        setTimeout(function() {
            runMain(F);
        }, 10);
        return;
    }

    // run code here
}

runMain(window.FAB);
