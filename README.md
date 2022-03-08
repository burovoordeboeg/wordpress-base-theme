
# WordPress Base theme

--

AANVULLEN MET INFORMATIE OVER HET THEMA


# Tailwind config
Er wordt gebruik gemaakt van een Tailwind. Om componenten en secties te herkennen maken we gebruik van data attributen. Deze zijn als volgt:
- Voor secties (zoals headers en navigatie): `data-section-id="NAAM"`
- Voor componenten (zoals buttons, titels, headings, etc.): `data-component-id="NAAM"`
- Voor Gutenberg blokken: `data-block-id="{{ blockname }}"`

Zo maken we beter onderscheid tussen secties, componenten en blokken en blijft de HTML in de Twig-files leesbaar.

## New setup notes & links

* [https://dev.to/antonmelnyk/how-to-configure-webpack-from-scratch-for-a-basic-website-46a5](https://dev.to/antonmelnyk/how-to-configure-webpack-from-scratch-for-a-basic-website-46a5)
* [https://stackoverflow.com/questions/69147962/file-loader-creating-2-images-and-linking-the-wrong-one](https://stackoverflow.com/questions/69147962/file-loader-creating-2-images-and-linking-the-wrong-one)
* [https://webpack.js.org/guides/asset-modules/](https://webpack.js.org/guides/asset-modules/)

## New setup with webpack

De setup maakt gebruik van webpack. We gebruiken tailwind (v3) en schrijven css ipv scss. Door het gebruik van postcss en postcss nesting kunnen we de css schrijven zoals je dat met Sass gewend bent.

