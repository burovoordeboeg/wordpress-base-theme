// Import the images to be used
if (import.meta.env.PROD) {
	import.meta.glob('@/images/**/*.{png,jpg,jpeg}', { eager: true });
}

// Import styles
if (import.meta.env.DEV) {
	// In development mode, import the CSS so that Vite can handle it (HMR, etc.)
	import('@/styles/styles.css');
}

// Place other imports or scripts here