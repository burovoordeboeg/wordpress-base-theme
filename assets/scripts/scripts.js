// Import js for componenents
importAll(require.context('../../templates/wpblocks/', true, /\/scripts\.js$/))

// Import js for pages
function importAll(r) {
    r.keys().forEach(r)
}
