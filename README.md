# THEME NAME

De algemene documentatie voor het Buro voor de Boeg Base Theme staat in ClickUp. Deze readme is bedoelt voor dit specifieke project.

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

Je moet vervolgens eerst de build-folder genereren, dat doe je door het commando `npm run build` te draaien. Op een lokale ontwikkelomgeving moet je Hot Module Replacement gebruiken, dat doe je door standaard naast je server ook Vite te draaien via het commando `npm run dev`. 