<?php 
add_filter('months_dropdown_results', '__return_empty_array'); // remove date filter
add_filter('bulk_actions-edit-cpt_slug', '__return_empty_array'); // remove bulk actions (replace cpt_clug with your cpt slug)