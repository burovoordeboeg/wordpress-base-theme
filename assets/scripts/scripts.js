
// Import js for componenents

// import 'magnific-popup';
// import './magnific-popup';


importAll(require.context('../../templates/blocks/', true, /\/scripts\.js$/))


// Import js for pages
function importAll(r) {
    r.keys().forEach(r)
}
