console.log('Hi')

// Import blocks scripts
import './blocks';

// Import alphine js
// Alphine js is new, lightweight, JavaScript framework thats really
// usefull for simple state management
import './alphine';

// Import swiper js
// Swiper.js is a Modern Mobile Touch Slider
import './swiper';

// Import styles
import '../css/styles.css';
import '../css/editor-styles.css';

// wp.domReady(() => {
// 	// find blocks styles
// 	wp.blocks.getBlockTypes().forEach((block) => {
// 		if (_.isArray(block['styles'])) {
// 			console.log(block.name, _.pluck(block['styles'], 'name'));
// 		}
// 	});
// });

console.log(wp);

wp.domReady(() => {
	wp.blocks.unregisterBlockStyle('core/quote', 'large');
});