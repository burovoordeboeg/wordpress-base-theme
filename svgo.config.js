module.exports = {
    multipass: true,
    js2svg: {
        indent: 4, // string with spaces or number of spaces. 4 by default
        pretty: true, // boolean, false by default
    },
    plugins: [
        {
            name: 'preset-default',
        },
        {
            name: 'mergePaths',
            params: {
                force: true,
                leadingZero: true,
            },
        },
        {
            name: 'removeAttributesBySelector',
            params: {
                selector: 'svg',
                attributes: ['xml:space', 'id'],
            },
        },
        {
            name: 'sortAttrs',
        },
        {
            name: 'removeAttrs',
            params: {
                attrs: ['data-*', 'data.*'],
            },
        },
        {
            name: 'convertColors',
            params: {
                currentColor: true,
            },
        },
        {
            name: 'removeDimensions',
        },
        {
            name: 'convertStyleToAttrs',
            params: {
                keepImportant: true,
            },
        },
    ],
};
