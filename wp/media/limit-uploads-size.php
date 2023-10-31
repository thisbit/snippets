<?php 
// can be added in plugins or theme
add_filter( 'upload_size_limit', 'wpse_228300_change_upload_size' ); 
function wpse_228300_change_upload_size()
{
    return 1000 * 1024;
}
