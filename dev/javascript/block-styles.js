console.log('ik kom uit de blockstyles');

wp.domReady(() => {
	wp.blocks.registerBlockStyle(
		'core/button', {
		name: 'cta',
		label: 'CTA'
	}
	);
	wp.blocks.registerBlockStyle(
		'core/button', {
		name: 'link',
		label: 'Link'
	}
	);
	wp.blocks.registerBlockStyle(
		'core/paragraph', {
		name: 'lead',
		label: 'Lead'
	}
	);

	wp.blocks.registerBlockStyle(
		'core/spacer', {
		name: 'small',
		label: 'Small'
	}
	);

	wp.blocks.unregisterBlockStyle(
		'core/button', ['outline', 'fill']
	);
	wp.blocks.unregisterBlockStyle(
		'core/image', ['rounded']
	);

	// wp.blocks.unregisterBlockType('core/embed');
	wp.blocks.unregisterBlockVariation('core/embed', 'twitter');
});