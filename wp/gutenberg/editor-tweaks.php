<?php
/**
 * Apuri Gutenberg Editor Tweaks
 * Extends @link https://community.generateblocks.com/t/gb-editor-widths/177/4
 * Adds outlines to blocks for easier navigation
 * Sets minimal paddings and margins
 * Sets full page editor area width
 * Sets outlines always visible when in theming post types like elements, gb styles or gb local templates
 */
function apuri_gutenberg_editor_tweaks() {
	$css = '';
	$css = '.wp-block { max-width: 100% !important; position: relative !important; padding: 3px !important; overflow: visible; word-break: break-all !important; } .wp-block:after { content: ""; position: absolute; top:0; bottom:0; left:0; right:0; outline: 1px dashed transparent !important; } .wp-block:hover:after { outline: 1px dashed var(--wp-admin-theme-color) !important; } .editor-styles-wrapper { font-family:"Work Sans", sans-serif !important; font-size: 70%; padding: 1rem; width: 100% !important; } .block-editor-inner-blocks .gb-inside-container { padding-left: 1rem; } .post-type-gblocks_global_style .wp-block:after, .post-type-gblocks_templates .wp-block:after, .post-type-gp_elements .wp-block:after { content: ""; position: absolute; top:0; bottom:0; left:0; right:0; outline: 1px dashed #ccc !important; } .post-type-gblocks_global_style .wp-block:hover:after, .post-type-gblocks_templates .wp-block:hover:after, .post-type-gp_elements .wp-block:hover:after { outline: 1px dashed var(--wp-admin-theme-color) !important; } .editor-styles-wrapper .gb-button { padding: .5em .75em !important; }';
	wp_add_inline_style( 'wp-block-editor', $css );
}
add_action( 'enqueue_block_editor_assets', 'apuri_gutenberg_editor_tweaks', 99 );