// Import js for componenents
importAll(require.context('../../templates/wp-blocks/', true, /\/scripts\.js$/))

// Import js for pages
function importAll(r) {
    r.keys().forEach(r)
}
