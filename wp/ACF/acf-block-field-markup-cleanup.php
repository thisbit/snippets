<?php
/** 
* ACF Block with markup cleanup on a field
*/

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

<footer id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr( 'york-' . $className ); ?>">
	    <?php if( get_field('york_references_single') ): ?>
		<div class="york-references__inner">
			<div class="york-references__header">
				<h2 class="york-references__headline">References</h2>
				<div class=york-references__line></div>
			</div>
	    	<?php 
				$field = get_field( 'york_references_single' );
				$formatted_field = strip_tags( $field, array( 'p', 'a', 'i' ) );
				echo $formatted_field;
	    	?>
		</div>
		<?php else: ?>
		<p class="please-add-some-references">Please add some references.</p>
		<?php endif; ?>
</footer>

<?php