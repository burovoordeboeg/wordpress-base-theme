// This will load all js files from our blocks and inject it in our scripts.js.
function requireAll(r) { r.keys().forEach(r); }
requireAll(require.context('../../views/blocks/', true, /.js$/));
