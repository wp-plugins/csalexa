<?php


if (defined(WP_UNINSTALL_PLUGIN )) {
    delete_option('csalexa_verification_code');
}

?>