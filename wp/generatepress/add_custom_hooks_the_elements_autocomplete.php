<?php
/**
 * This function adds your custom hooks to the elements hook dropdown list, so it is more user friendly to attach elements to them
 * 
 **/

function add_custom_hooks( $hooks ) {
	$custom_hooks = array(
			'custom' => array(
					'group' => esc_attr__( 'Custom Hooks', 'gp-premium' ),
					'hooks' => array(
							'my_custom_hook_1',
							'my_custom_hook_2',
							'my_custom_hook_3',
					),
			),
	);

	$hooks = array_merge( $hooks, $custom_hooks );

	return $hooks;
}

add_filter( 'generate_hooks_list', 'add_custom_hooks' );