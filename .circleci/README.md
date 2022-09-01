# CircleCI Setup

CircleCi is middels een context voorzien van de belangrijkste gegevens, zoals de informatie van de server, Packagist token en juiste poortnummers. Echter moet op projectniveau een aantal zaken worden ingesteld. 

## Setting up the CircleCi project

Om je CircleCi omgeving op te zetten voer je de volgende stappen uit:

1. Ga naar CircleCi en klik aan de linkerzijde op projects, zoek de juiste repository en klik op "set up project", of klik op "follow" als dit erbij staat (in dat geval zijn onderstaande stappen wellicht overbodig)
2. Klik in het vervolgscherm op "Use existing config" en koppelt de master branch

## Project settings

Het project heeft een aantal settings nodig om te kunnen deployen. Hiervoor klik je rechtsboven op "Project settings".

### Environment variables

1. Ga naar de tab "Environment variables"
2. Maak de volgende variabelen aan:

| Variable | Type | Description | Example value | 
| :-- | :-- | :-- | :-- |
| `USER` | string | Gebruikersnaam op de server | bvdb |
| `DOMAIN_TEST` | string | Domein voor de testomgeving | bvdb.test.domein.dev |
| `DOMAIN_ACCEPTANCE` | string | Domein voor de acceptatie omgeving | bvdb.accept.domein.dev |
| `DOMAIN_PRODUCTION` | string | Domein voor de live omgeving | burovoordeboeg.nl |
| `SERVER_PATH` | string | Pad op de server vanaf de root <u>zonder eerste slash</u> | public_html/content/themes/bvdb/ |

### SSH-Keys

1. Ga naar de tab SSH-Keys
2. Controleer in het config.yml bestand de `SERVER_IP` waarde. Deploy je naar s01 dan gebruik je `SERVER_IP_S01`. Deploy je naar s02 dan gebruik je `SERVER_IP_S02`.
3. Klik bij "Additional SSH Keys" op "Add SSH Key".
4. Hostnaam: `s01.burovoordeboeg.nl` of `s02.burovoordeboeg.nl` vervolgens zoek je in Dashlane de "Private Server Key voor CircleCi"
5. Ga nu naar de Buro voor de Boeg server, en maak daar de user aan. Vergeet niet deze user SSH-access te verlenen.
6. Na het aanmaken van de user op de server ga je naar de optie "SSH Keys", onderaan staat "Paste Authorized Key", plaats daar de inhoud van de Dashlane kaart "Public Server Key voor DirectAdmin"

## Builds triggeren volgens gitflow

De builds triggeren volgens gitflow op basis van tagging en releases. Er zijn drie workflows gedefinieërd:

### 1. Feature deployment

De feature deployment triggert op élke commit naar de develop-branch. Deze deployed vervolgens altijd naar de test-omgeving. Een commit naar de develop-branch is altijd een pull-request, er kan (en mag) niet direct een commit naar de develop branch gemaakt worden maar moet altijd vanuit een feature worden gemerged.

Features kunnen gestart worden vanuit de git flow. 

### 2. Release deployment

Een release is een geversioneerde deploy. Dit is een release (of pre-release) die naar een publieke omgeving mag worden gedeployed en rolt dus automatisch uit naar acceptatie. Voor deploy naar productie is een handmatige goedkeuring binnen CircleCi nodig. 

### 3. Hotfix deployment

Het moet te allen tijde nodig zijn om een hotfix te releasen. Door een tag aan te maken op de master branch die de prefix `hotfix-` gebruikt - gevolgd door een logische naam - zal de hotfix automatisch gereleased worden naar alle drie de omgevingen. 

## Gitflow

Deze nieuwe deployment pipeline maakt gebruik van de mogelijkheden die de Gitflow biedt. Gitflow komt voort uit een [branching model](https://nvie.com/posts/a-successful-git-branching-model/) (of strategy) die uitgaat van releases. In basis is er een develop branch vanwaaruit features worden gestart. Vanuit develop wordt er middels Pull Requests gewerkt aan een nieuwe release. Als er voldoende features zijn verzameld wordt er een release gemaakt op basis van een tag. Deze tags vormen de basis voor een deploy. 

Gitflow ondersteuning is ingebakken in [Tower](https://www.git-tower.com/p/refer-a-friend/R-MGXJNS3PP3) maar kan ook via de CLI worden uitgevoerd. Hier is een homebrew package voor beschikbaar, die installeer je middels het volgende commando: `brew install git-flow`. 

### Starting a feature

Omdat je niet rechtstreeks naar de develop branch kan pushen start je altijd een feature vanuit Gitflow met het volgende commando: `git flow feature start <name>`, waarbij `<name>` wordt vervangen door de naam van je feature. Er wordt een losse branch aangemaakt waarin je werkt. Als je klaar bent met je feature code sluit je deze middels `git flow feature finish <name>` waarbij je vanzelfsprekend dezelfde naam gebruikt. De feature wordt vervolgens geautomatiseerd <u>lokaal</u> gemerged met develop, daarna is het wel nodig develop nog los te pushen. Door deze push wordt de feature automatisch gedeployed naar de testomgeving. 

### Starting a hotfix

Net als een feature maak je een hotfix aan door gebruik te maken van een Gitflow commando: `git flow hotfix start hotfix-<name>`. Belangrijk bij een hotfix is dat deze altijd start met `hotfix-` als name, want dit wordt namelijk ook de tag die gebruikt wordt bij de push nadat je de hotfix finished. De tag wordt dan bijvoorbeeld `hotfix-navigation-close`. Omdat de tag start met `hotfix-` zal de build naar alle omgevingen (test, acceptatie én productie) automatisch worden getriggered. 
