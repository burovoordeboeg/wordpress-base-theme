
// Import js for componenents
importAll(require.context('../../templates/blocks/', true, /\/scripts\.js$/))

// Import js for pages
function importAll(r) {
    r.keys().forEach(r)
}
