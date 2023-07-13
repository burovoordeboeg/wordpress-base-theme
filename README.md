# THEME NAME

De algemene documentatie voor het Buro voor de Boeg Base Theme staat in [confluence](https://burovoordeboeg.atlassian.net/wiki/spaces/BVDBT/pages/57933825/Base+Theme). Deze readme is bedoelt voor dit specifieke project.

## Theme settings

Voor de deployment is het van belang de volgende settings in te stellen in de style.css van het thema:

```
/*
Theme Name: <<THEME NAME>>
Theme URI: <<THEME DOMAIN>>
Author: Buro voor de Boeg
Author URI: https://www.burovoordeboeg.nl
Description: WordPress theme build for <<CLIENT NAME>>
Version: 0.0.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags:
Text Domain: bvdb
Domain Path: /languages
*/
```

## Development

Na het downloaden/clonen van het basetheme moet je eerst de dependencies installeren. Dit doe je door in de root van het project het volgende commando uit te voeren:

`composer install`
`npm install`

Vervolgens kun je de task runner starten door het volgende commando uit te voeren:

`npm start` of `npm run build`

## Browsersync settings

In de root van het thema staat een bestand genaamd `browsersync-config.example`. Deze dien je ter hernoemen naar `browsersync-config.js` en de instellingen aan te passen naar de juiste instellingen voor het project. De instellingen zijn als volgt:

```
module.exports = {
  proxy: "http://<<LOCAL_URL_HERE>>/",
  files: ["./**/*.css", "./**/*.js", "./**/*.php", "./**/*.twig"],
};
```
