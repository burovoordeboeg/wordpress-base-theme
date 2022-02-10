# CircleCI Setup
CircleCi is middels een context voorzien van de belangrijkste gegevens, zoals de informatie van de server, Packagist token en juiste poortnummers. Echter moet op projectniveau een aantal zaken worden ingesteld. 

Om je CircleCi omgeving op te zetten voer je de volgende stappen uit:

1. Ga naar CircleCi en klik aan de linkerzijde op projects, zoek de juiste repository en klik op "set up project", of klik op "follow" als dit erbij staat (in dat geval zijn onderstaande stappen wellicht overbodig)
2. Klik in het vervolgscherm op "Use existing config" (als je dit scherm niet krijgt, ga naar stap 3), en klik de waarschuwing door "Start building"
3. De lint-workflow loopt nu automatisch.
4. Klik rechtsboven op "Project settings", en ga naar de tab SSH-Keys
5. Controleer in het config.yml bestand de `SERVER_IP` waarde. Deploy je naar s01 dan kan je deze variabele laten staan. Deploy je naar s02 dan gebruik je `SERVER_IP_S02` en vervang je alle `SERVER_IP` variabelen. 
6. Klik bij "Additional SSH Keys" op "Add SSH Key".
7. Hostnaam: `s01.burovoordeboeg.nl` of `s02.burovoordeboeg.nl` vervolgens zoek je in Dashlane de "Private Server Key voor CircleCi"
8. Ga nu naar de Buro voor de Boeg server, en maak daar de user aan. Vergeet niet deze user SSH-access te verlenen.
9. Na het aanmaken van de user op de server ga je naar de optie "SSH Keys", onderaan staat "Paste Authorized Key", plaats daar de inhoud van de Dashlane kaart "Public Server Key voor DirectAdmin"
10. Ga terug naar CircleCi
11. Ga naar de tab "Environment variables"
12. Maak de volgende variabelen aan:

| Variable | Example value | Description |
| :-- | :-- | :-- |
| `USER` | test | Hier vul je de gebruikersnaam in van de gebruiker op de server |
| `STAGING_PATH` | `test.staging.burovoordeboeg.dev/public_html/content/themes/test/` | Dit is het pad van het staging-domein, vanaf de domeinnaam |
| `PRODUCTION_PATH` | `test.nl/public_html/content/themes/test/` | Dit is het pad van het production-domein, vanaf de domeinnaam |


## Builds triggeren

Builds triggeren automatisch, zo triggert:

* Bij elke commit en PR de jsLint en sassLint
* Bij elke PR op release branches
