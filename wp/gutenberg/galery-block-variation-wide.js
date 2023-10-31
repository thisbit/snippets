wp.domReady( () => {
	wp.blocks.registerBlockVariation(
		'core/gallery',
		{
			isDefault: true,
			attributes: {
					align: 'wide'
				},
			}
	);
}