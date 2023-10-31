// Remove formatting options for image block
wp.domReady(() => {
	wp.blocks.unregisterBlockStyle('core/image', 'rounded');
	wp.blocks.unregisterBlockStyle('core/image', 'default');
} );

// Whitelist on specific embed block variations
// Thanks Ty Baily (https://www.linkedin.com/in/tylerb24890)
const { getBlockVariations, unregisterBlockVariation } = wp.blocks;

wp.domReady(() => {
	const allowedEmbedBlocks = ['vimeo', 'youtube', 'twitter', 'soundcloud']; // Only these are allowed

	getBlockVariations('core/embed').forEach(function (blockVariation) {
		if (allowedEmbedBlocks.indexOf(blockVariation.name) === -1) {
			unregisterBlockVariation('core/embed', blockVariation.name);
		}
	});
});