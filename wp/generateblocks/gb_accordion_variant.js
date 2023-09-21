// this file is a part of learning process so this file will be changed as I learn stuff :)
const iconAttributes = {
	iconLocation: 'right',
	columnGap: '0.5em',
	iconSize: 0.8,
	iconPaddingRight: '',
	display: 'flex',
	alignItems: 'center',
	justifyContent: 'space-between',
	sizing: { width: '100%' },
	hasIcon: true,
	icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="1em" height="1em" ariahidden="true" role="img" class="gb-accordion__icon"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" fill="currentColor"></path></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="1em" height="1em" ariahidden="true" role="img" class="gb-accordion__icon-open"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" fill="currentColor"></path></svg>',
};

const template = [ [ 'generateblocks/container',
	{
		variantRole: 'accordion-item',
		accordionItemOpen: true,
		className: 'gb-accordion__item',
	},
	[
		[ 'generateblocks/button',
			Object.assign( {},
				generateBlocksPro?.blockStyles?.button,
				iconAttributes,
				{
					text: 'Accordion title',
					variantRole: 'accordion-toggle',
					buttonType: 'button',
					backgroundColor: '#ffffff',
					textColor: '#000000',
					backgroundColorHover: '#ffffff',
					textColorHover: '#222222',
					backgroundColorCurrent: '#fff',
					textColorCurrent: '#000000',
					alignment: 'left',
					className: 'gb-accordion__toggle',
				}
			),
		],
		[ 'generateblocks/container',
			{
				variantRole: 'accordion-content',
				paddingTop: '20',
				paddingRight: '20',
				paddingBottom: '20',
				paddingLeft: '20',
				marginBottom: '20',
				backgroundColor: '#fafafa',
				className: 'gb-accordion__content',
			},
			[
				[ 'core/paragraph',
					{
						content: 'Accordion content.',
					},
				],
			],
		],
	],
] ];




wp.domReady( () => {
	wp.blocks.unregisterBlockVariation( 'generateblocks/container', 'accordion' ); // removes default accordion
		wp.blocks.registerBlockVariation(
			'generateblocks/container',
			{
				title: 'Thisbit Accordion',
				name: 'thisbit-accordion',
				icon: 'list-view',
				isDefault: true,
				attributes: {
					className: 'is-thisbit-accordion gb-accordion',
        	//borderColor: "contrast",
        	align : 'wide',
					variantRole: 'accordion',
					accordionTransition: 'slide',
					accordionItemOpen: false,
				},
				innerBlocks: template,
				isActive: ( attrs ) => 'accordion' === attrs.variantRole,
			}
		);

		wp.blocks.registerBlockVariation(
			'generateblocks/container',
			{
				title: 'Thisbit Accordion Item',
				name: 'thisbit-accordion-item',
				scope: [ 'block' ],
				isDefault: true,
				attributes: {
					className: 'gb-accordion__item',
					variantRole: 'accordion-item',
					accordionItemOpen: false,
				},
				isActive: ( attrs ) => 'accordion-item' === attrs.variantRole,
			}
		);

		wp.blocks.registerBlockVariation(
			'generateblocks/container',
			{
				title: 'Thisbit Accordion Content',
				name: 'thisbit-accordion-content',
				scope: [ 'block' ],
				isDefault: true,
				attributes: {
					className: 'gb-accordion__content',
					variantRole: 'accordion-content',
				},
				isActive: ( attrs ) => 'accordion-content' === attrs.variantRole,
			}
		);

		wp.blocks.registerBlockVariation(
			'generateblocks/button',
			{
				title: 'Thisbit Accordion Title',
				name: 'thisbit-accordion-title',
				scope: [ 'block' ],
				isDefault: true,
				attributes: {
					className: 'gb-accordion__toggle',
					variantRole: 'accordion-toggle',
					accordionItemOpen: 'false',
				},
				isActive: ( attrs ) => 'accordion-title' === attrs.variantRole,
			}
		);

		wp.blocks.registerBlockVariation(
			'generateblocks/container',
			{
				title: 'Thisbit Accordion Title',
				name: 'thisbit-container-accordion-toggle',
				scope: [ 'block' ],
				attributes: {
					variantRole: 'accordion-toggle',
				},
				isActive: ( attrs ) => 'accordion-toggle' === attrs.variantRole,
			}
		);
	
} );