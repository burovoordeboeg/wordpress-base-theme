// import 'magnific-popup';
// import './magnific-popup';

// Import js for componenents
importAll(require.context("../../blocks/", true, /\/scripts\.js$/));

// Import js for pages
function importAll(r) {
  r.keys().forEach(r);
}
