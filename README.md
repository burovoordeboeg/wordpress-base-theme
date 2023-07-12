# WordPress Base theme

--
Het BvdB Base Theme is ons Wordpress thema dat we gebruiken als starttheme bij de ontwikkeling van nieuwe projecten. Dit thema is volledig maatwerk en maakt gebruik van o.a.

-   Twig voor templating ([https://twig.symfony.com/](https://twig.symfony.com/))
-   Tailwind.css als css framework ([https://tailwindcss.com/](https://tailwindcss.com/))
-   ACF Gutenbergblocks voor het opzetten van Wordpress Blocks ([https://www.advancedcustomfields.com/resources/blocks/](https://www.advancedcustomfields.com/resources/blocks/))
-   Webpack (middels Laravel Mix) als development tool ([https://laravel-mix.com/]())

# Instalatie

Voor de instalatie van het Base Theme volg je de volgende stappen, hierbij ga ik uit van het gebruik van Local By Flywheel, echter zijn de stappen in o.a. Docker grotendeels gelijk.

-   Maak een nieuwe website aan in Local By Flywheel. Gebruik hierbij **Apache** als webserver en **PHP 8.1.9** als PHP versie.
-   Ga naar onze [Github](https://github.com/burovoordeboeg/wordpress-base-theme) en maak een nieuwe repositorie aan op basis van dit template.
-   Clone de nieuwe repositorie in je Wordpress themes folder `app/public/wp-content/themes/`
-   Open het theme in VSC en in de terminal run je de volgde scripts: `composer install && npm install && npm run build`
-   Binnen Wordpress kun je het thema nu activeren en starten met de development van het project met `npm start`. Hiermee run je de development scripts welke de code compiled en watched.

## Tailwind/Twig config

Er wordt gebruik gemaakt van een Tailwind. Om componenten en secties te herkennen maken we gebruik van data attributen. Deze zijn als volgt:

-   Voor secties (zoals headers en navigatie): `data-section-id="NAAM"`
-   Voor componenten (zoals buttons, titels, headings, etc.): `data-component-id="NAAM"`
-   Voor Gutenberg blokken: `data-block-id="{{ blockname }}"`

Zo maken we beter onderscheid tussen secties, componenten en blokken en blijft de HTML in de Twig-files leesbaar.

## Twig Include, Extends, Use, Macro and Embed

There are various types of inheritance and code reuse in Twig:

### Include

**Main Goal:** Code Reuse

**Use Case:** Using header.twig & footer.twig inside base.twig.

**header.twig**

```
<nav>
   <div>Homepage</div>
   <div>About</div>
</nav>
```

**footer.twig**

```
<footer>
   <div>Copyright</div>
</footer>
```

**base.twig**

```
{% include 'header.html.twig' %}
<main>{% block main %}{% endblock %}</main>
{% include 'footer.html.twig' %}
```

### Extends

**Main Goal:** Vertical Reuse

**Use Case:** Extending base.twig inside homepage.twig & about.twig.

**base.twig**

```
{% include 'header.twig' %}
<main>{% block main %}{% endblock %}</main>
{% include 'footer.html.twig' %}
```

**homepage.twig**

```
{% extends 'base.twig' %}

{% block main %}
<p>Homepage</p>
{% endblock %}
```

**about.twig**

```
{% extends 'base.twig' %}

{% block main %}
<p>About page</p>
{% endblock %}
```

### Use

**Main Goal:** Horizontal Reuse

**Use Case:** sidebar.twig in single.product.twig & single.service.twig.

**sidebar.twig**

```
{% block sidebar %}<aside>This is sidebar</aside>{% endblock %}
```

**single.product.html.twig**

```
{% extends 'product.layout.twig' %}

{% use 'sidebar.twig' %}

{% block main %}<main>Product page</main>{% endblock %}
```

**single.service.twig**

```
{% extends 'service.layout.twig' %}

{% use 'sidebar.twig' %}

{% block main %}<main>Service page</main>{% endblock %}
```

**Notes:**

1. It's like macros, but for blocks.
1. The use tag only imports a template if it does not extend another template, if it does not define macros, and if the body is empty.

-

### Macro

**Main Goal:** Reusable Markup with Variables

**Use Case:** A function which gets some variables and outputs some markup.

**form.twig**

```
{% macro input(name, value, type) %}
    <input type="{{ type|default('text') }}" name="{{ name }}" value="{{ value|e }}" }}" />
{% endmacro %}
```

**profile.service.twig**

```
{% import "form.html.twig" as form %}

<form action="/login" method="post">
    <div>{{ form.input('username') }}</div>
    <div>{{ form.input('password') }}</div>
    <div>{{ form.input('submit', 'Submit', 'submit') }}</div>
</form>
```

### Embed

**Main Goal:** Block Overriding

**Use Case:** Embedding pagination.twig in product.table.twig & service.table.twig.

**pagination.twig**

```
<div id="pagination">
    <div>{% block first %}{% endblock %}</div>
    {% for i in (min + 1)..(max - 1) %}
        <div>{{ i }}</div>
    {% endfor %}
    <div>{% block last %}{% endblock %}</div>
</div>
```

**product.table.twig**

```
{% set min, max = 1, products.itemPerPage %}

{% embed 'pagination.html.twig' %}
    {% block first %}First Product Page{% endblock %}
    {% block last %}Last Product Page{% endblock %}
{% endembed %}
```

**service.table.twig**

```
{% set min, max = 1, services.itemPerPage %}

{% embed 'pagination.html.twig' %}
    {% block first %}First Service Page{% endblock %}
    {% block last %}Last Service Page{% endblock %}
{% endembed %}
```

Please note that embedded file (`pagination.twig`) has access to the current context (`min, max variables`).

Also you may pass extra variables to the embedded file:

**pagination.twig**

```
<p>{{ count }} items</p>
<div>
    <div>{% block first %}{% endblock %}</div>
    {% for i in (min + 1)..(max - 1) %}
        <div>{{ i }}</div>
    {% endfor %}
    <div>{% block last %}{% endblock %}</div>
</div>
```

**product.table.twig**

```
{% set min, max = 1, products|length %}

{% embed 'pagination.html.twig' with {'count': products|length } %}
    {% block first %}First Product Page{% endblock %}
    {% block last %}Last Product Page{% endblock %}
{% endembed %}
```

**Note:**

It has the functionality of both `Use` & `Include` together.

## .htaccess voor productie images

Add these lines to load media files from production server if they don't exist locally

```
<IfModule mod_rewrite.c>
  RewriteEngine on
  RewriteBase /
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^content/uploads/(.*)$ https://remotesite.com/content/uploads/$1 [NC,L]
</IfModule>
```
