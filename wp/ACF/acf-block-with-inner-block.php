<?php
/**
 * Block Template For References in Articles
 * Custom made for York C20 website
 */

require_once( YORK_BLOCKS_PATH . 'inc/no-direct.php' ); 
// Create id attribute allowing for custom "anchor" value.


$id = 'references-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'references';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>

<footer id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( 'york-' . $className ); ?>">
	<label>References</label>
	<div class="york-references__inner">
    	<InnerBlocks />
	</div>
</footer>