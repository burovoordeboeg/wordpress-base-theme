
# WordPress Base theme

--

AANVULLEN MET INFORMATIE OVER HET THEMA


  
# Github
## Repository setup
We maken in basis drie branches aan: develop, staging en production. De master branch die gebruiken we niet. De develop branch stel je in als default-branch. 

**Develop- en feature branches**
De develop branch is de plek waar je nieuw ontwikkelde code op verzameld, zogenaamd: "actief development". In basis werk je je eigen develop branch, bijvoorbeeld `develop/<naam>`.  Stel dat je een stabiele release hebt van een WordPress thema, en je wil daar een extra op ontwikkelen, dan doe je dat in een feature branch, deze branch je ook vanaf de develop branch, en noem je vervolgens naar de naam van de feature, bijvoorbeeld `feature/project-pdf-export`. Op die manier is je naam duidelijk en beschrijvend. 

**Staging-branch**
De staging branch is de branch die gelijk loopt met de staging server. De staging server kan daarmee voorlopen op de productie server en dus ook op de production branch. Je kan releasen naar de staging branch vanuit de develop branch middels het aanmaken van een pull-request in Github. 

**Production-branch**
Voor de production branch geldt hetzelfde als staging. Deze loopt gelijk met de versie van het thema op de production server. Je kan een deployment naar production alleen starten vanaf de staging branch. Zo voorkomen we te snelle releases.

## Branch protection

In Github beveiligen we branches zodat we deze in de juiste volgorde kunnen uitvoeren, zie screenshots voor de branch protection

- [Branch beveiliging: Staging](https://assets.burovoordeboeg.nl/github/branch-staging.png)
- [Branch beveiliging: Production](https://assets.burovoordeboeg.nl/github/branch-production.png)

De branch-beveiliging zorgt ervoor dat je moet mergen middels pull-requests, en in de juiste volgorde. Je released altijd eerst naar staging, en daarna vanaf staging naar production. 

Stel je wil gaan werken aan een feature branch. 

___

# CI/CD workflow in CircleCi

We volgen voor deze geautomatiseerde CI/CD pipeline een git-branching model, uitgaande dat:

- Je een production, staging en develop branch hebt opgezet

- De develop branch ingesteld hebt als 'default branch'

- Je werkt in je eigen branch, of eventueel feature-branches voor het ontwikkelen van extra features, je werkt nooit direct in de production of staging branch

- Je merged features naar de develop branch

- De develop branch merge je vervolgens middels een release naar staging. In de staging branch maak je een versienummer aan

- Zodra de staging omgeving akkoord is, maak je een merge naar de production branch, en ook daar maak je een versienummer aan

  

## CircleCI Setup
CircleCi is middels een context voorzien van de belangrijkste gegevens, zoals de informatie van de server, Packagist token en juiste poortnummers. Echter moet op projectniveau een aantal zaken worden ingesteld. 

Om je CircleCi omgeving op te zetten voer je de volgende stappen uit:

1. Ga naar CircleCi en klik aan de linkerzijde op projects, zoek de juiste repository en klik op "set up project", of klik op "follow" als dit erbij staat (in dat geval zijn onderstaande stappen wellicht overbodig)

2. Klik in het vervolgscherm op "Use existing config" (als je dit scherm niet krijgt, ga naar stap 3), en klik de waarschuwing door "Start building"

3. De lint-workflow loopt nu automatisch.

4. Klik rechtsboven op "Project settings", en ga naar de tab SSH-Keys

5. Klik bij "Additional SSH Keys" op "Add SSH Key".

6. Hostnaam: `s01.burovoordeboeg.nl`, vervolgens zoek je in Dashlane de "Private Server Key voor CircleCi"

7. Voeg een tweede SSH Key toe: hostnaam: `circleci.burovoordeboeg.nl` en zoek in Dashlane naar "Private Bastion Key voor CircleCi"

8. Ga nu naar de Buro voor de Boeg server, en maak daar de user aan. Vergeet niet deze user SSH-access te verlenen.

9. Na het aanmaken van de user op de server ga je naar de optie "SSH Keys", onderaan staat "Paste Authorized Key", plaats daar de inhoud van de Dashlane kaart "Public Server Key voor DirectAdmin"

11. Ga terug naar CircleCi

11. Ga naar de tab "Environment variables"

12. Maak drie variabelen aan:

- `USER` > Hier vul je de DirectAdmin gebruikersnaam in

- `STAGING_PATH` > Dit is het pad van het staging-domein, vanaf de domeinnaam, bijvoorbeeld: test.staging.burovoordeboeg.dev/public_html/content/themes/test/

- `PRODUCTION_PATH` > Dit is het pad van het production-domein, vanaf de domeinnaam, bijvoorbeeld: test.nl/public_html/content/themes/test/

13. Je kunt nu een build triggeren met een merge vanaf develop naar staging



## Builds triggeren

Builds triggeren automatisch, zo triggert:

- Bij elke commit en PR de jsLint en sassLint

- Bij elke PR op de staging branch een staging-deploy

- Bij elke PR op de master branch een master-deploy
