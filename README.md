![Image](https://camo.githubusercontent.com/232b6e30a642047f3b1de99599e8f14f05198f6d/68747470733a2f2f686162726173746f726167652e6f72672f776562742f79762f74742f612d2f79767474612d36746e6d366170776373346d63736f6774777a626d2e6a706567)

# The most powerful and extendable tools for managing SEO Meta Tags in your Laravel project

Laravel SEO Meta Tags is a beautiful tools for Laravel applications. Of course, the primary feature of this package is the ability to manage your header meta tags, CSS, JavaScript and other type of tags. It provides a simple and flexible API to manage search engine optimization (SEO) tags in your application.

[![Build Status](https://travis-ci.org/butschster/LaravelMetaTags.svg)](https://travis-ci.org/butschster/LaravelMetaTags) [![Latest Stable Version](https://poser.pugx.org/butschster/meta-tags/v/stable)](https://packagist.org/packages/butschster/meta-tags) [![Total Downloads](https://poser.pugx.org/butschster/meta-tags/downloads)](https://packagist.org/packages/butschster/meta-tags) [![License](https://poser.pugx.org/butschster/meta-tags/license)](https://packagist.org/packages/butschster/meta-tags)

## Features
- Manage meta tags, set titles, charset, pagination links, e.t.c.
- Manage styles, scripts in different places of your HTML
- Create custom tags
- Open Graph & Twitter Cards are supported.
- Google Analytics tracking code is supported.
- Yandex Metrika tracking code is supported with code builder.
- Webmaster tools site verifier tags are supported.
- Group tags, styles and scripts into packages and include by their names everywhere
- Well documented
- Well tested

### Requirements
- Laravel 5.6 to 7.x
- PHP 7.1 and above

## Installation and Configuration

From the command line run
```shell
composer require butschster/meta-tags
```

Once Meta Tags is installed you need to register the service provider. Just run artisan command
```shell
php artisan meta-tags:install
```

This command will install MetaTagsServiceProvider and will publish config `config/meta_tags.php`. In this config you can specify default title, keywords, description and other meta tags and its will be put into your HTML.

After running this command, verify that the `App\Providers\MetaTagsServiceProvider` was added to the providers array in your app `config/app.php` configuration file. If it wasn't, you should add it manually. Of course, if your application  does not use the App namespace, you should update the provider class name as needed.

That's it!

## Usage

### Controller
You can use either Facade `\Butschster\Head\Facades\Meta` or `\Butschster\Head\Contracts\MetaTags\MetaInterface` in your controller

```php
use Butschster\Head\MetaTags\MetaInterface;

class HomeController extends Controller {

    protected $meta;
 
    public function __contruct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }
    
    public function index()
    {
        $news = News::paginate();
        
        // Prepend title part to the default title
        $this->meta
        
            // Will render "Home page - Default Title"
           ->prependTitle('Home page')
           
           // Will include next, prev, canonical links
           ->setPaginationLinks($news)
           
           // Will change default favicon
           ->setFavicon('/favicon-index.ico')
    }
}

// Or you can use the facade

use Butschster\Head\Facades\Meta;

class HomeController extends Controller {
    public function index()
    {
        $news = News::paginate();
        
        Meta::prependTitle('Home page')
            ->setPaginationLinks($news)
            ->setFavicon('favicon-index.ico');
    }
}
```

#### View

Just put this code `{!! Meta::toHtml() !!}` into your HTML and that's all.
> you can use either `{!! Meta::toHtml() !!}` or `@meta_tags`

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        {!! Meta::toHtml() !!}
    </head>
    ...
</html>
```

### Placements
If you want to use meta tags not only in header, you can specify placements in your templates. Use `Meta::footer()->toHtml()` or `Meta::placement('placement')->toHtml()` or `@meta_tags('placement')`

```html
<body>
    ...
    {!! Meta::placement('middle_of_the_page')->toHtml() !!}
    ...
    {!! Meta::footer()->toHtml() !!}
</body>
```

### Packages
If you want to avoid code duplication you can group your tags, assets, e.t.c. to a package with specific name.

You can register a new package in the Service provider `\App\Providers\MetaTagsServiceProvider`

```php
namespace App\Providers;

use Butschster\Head\Facades\PackageManager;
use Butschster\Head\Packages\Package;
use Illuminate\Support\ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider {

    ...
    
    protected function packages()
    {
       PackageManager::create('jquery', function(Package $package) {
          $package->addScript(
             'jquery.js', 
             'https://code.jquery.com/jquery-3.3.1.min.js', 
             ['defer']
          );
       });
       
       PackageManager::create('calendar', function(Package $package) {
          $package->requires('jquery');
          $package->addScript(
             'fullcalendar.js', 
             'https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.0.1/main.min.js', 
             ['defer']
          )->addScript(
             'fullcalendar.locales.js', 
             'https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.0.1/locales-all.min.js', 
             ['defer']
          )->addStyle(
             'fullcalendar.css', 
             'https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.0.1/main.min.css'
          );
       });
    }

    ...
}
```

And then if you need specific packages in one of controllers you can include them by package name:

```php
use Butschster\Head\Facades\Meta;

class EventsController extends Controller {

    public function show(Event $event)
    {
        // Will include all tags from calendar package
        Meta::includePackages(['calendar', ...]);
    }
}
```

Or you can set packages, that can be included on every pages in `config/meta_tags.php`
```php
...
'packages' => [
    'jquery', 'calendar', ...
],
...
```

That's all! It's very easy.

> P.S. You can also use all methods, that are in Meta class.

# API

## Meta

`\Butschster\Head\MetaTags\Meta`
- This class implements `Illuminate\Contracts\Support\Htmlable` interface

### Methods

**Set the main part of meta title**
```php
Meta::setTitle('Laravel');
// <title>Laravel</title>

// You can specify max length. (By default it gets from config.)
Meta::setTitle('Laravel', 4);
// <title>Lara...</title>
```

**Prepend title part to main title**
```php
Meta::setTitle('Laravel')
    ->prependTitle('Home page');
// <title>Home page - Laravel</title>
```

**Set the title separator**
> By default it gets from config
```php
Meta::setTitleSeparator('->')
    ->setTitle('Laravel')
    ->prependTitle('Home page');
// <title>Home page -> Laravel</title>
```

**Set the description**
```php
Meta::setDescription('Awesome page');
// <meta name="description" content="Awesome page">

// You can specify max length. (By default it gets from config.)
Meta::setDescription('Awesome page', 7);
// <meta name="description" content="Awesome...">
```

**Set the keywords**
```php
Meta::setKeywords('Awesome keywords');
// <meta name="keywords" content="Awesome keywords">


Meta::setKeywords(['Awesome keyword', 'keyword2']);
// <meta name="keywords" content="Awesome keyword, keyword2">

// You can specify max length. (By default it gets from config.)
Meta::setKeywords(['keyword', 'keyword2'], 10);
// <meta name="keywords" content="keyword, key...">
```

**Set the robots**
```php
Meta::setRobots('nofollow,noindex');
// <meta name="robots" content="nofollow,noindex">
```

**Set the content type**
```php
Meta::setContentType('text/html');
// <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

Meta::setContentType('text/html', 'ISO-8859-1');
// <meta http-equiv="Content-Type" content="text/html; ISO-8859-1">
```

**Set the viewport**
```php
Meta::setViewport('width=device-width, initial-scale=1');
// <meta name="viewport" content="width=device-width, initial-scale=1">
```

**Add webmaster tags** You can add multiple tags
```php
use Butschster\Head\MetaTags\Entities\Webmaster;

// Supported services [google, yandex, pinterest, alexa, bing]
Meta::addWebmaster(Webmaster::GOOGLE, 'f+e-Ww4=[Pp4wyEPLdVx4LxTsQ');
// <meta name="google-site-verification" content="f+e-Ww4=[Pp4wyEPLdVx4LxTsQ">

Meta::addWebmaster('yandex', 'f+e-Ww4=[Pp4wyEPLdVx4LxTsQ');
// <meta name="yandex-verification" content="f+e-Ww4=[Pp4wyEPLdVx4LxTsQ">

Meta::addWebmaster('bing', 'f+e-Ww4=[Pp4wyEPLdVx4LxTsQ');
// <meta name="msvalidate.01" content="f+e-Ww4=[Pp4wyEPLdVx4LxTsQ">

Meta::addWebmaster('alexa', 'f+e-Ww4=[Pp4wyEPLdVx4LxTsQ');
// <meta name="alexaVerifyID" content="f+e-Ww4=[Pp4wyEPLdVx4LxTsQ">

Meta::addWebmaster(Webmaster::PINTEREST, 'f+e-Ww4=[Pp4wyEPLdVx4LxTsQ');
// <meta name="p:domain_verify" content="f+e-Ww4=[Pp4wyEPLdVx4LxTsQ">
```

**Set the prev href**
```php
Meta::setPrevHref('http://site.com/prev');
// <link rel="prev" href="http://site.com/prev" />
```

**Set the next href**
```php
Meta::setNextHref('http://site.com/next');
// <link rel="next" href="http://site.com/next" />
```

**Set the canonical link**
```php
Meta::setCanonical('http://site.com');
// <link rel="canonical" href="http://site.com" />
```

**Set canonical link, prev and next from paginator object**
```php
$news = \App\News::paginate();

Meta::setPaginationLinks($news);

// <link rel="prev" href="http://site.com/prev" />
// <link rel="next" href="http://site.com/next" />
// <link rel="canonical" href="http://site.com" />
```

**Add a hreflang link**
```php
Meta::setHrefLang('en', http://site.com/en');
Meta::setHrefLang('ru', http://site.com/ru');

// <link rel="alternate" hreflang="en" href="http://site.com/en" />
// <link rel="alternate" hreflang="ru" href="http://site.com/ru" />
```

**Set the character encoding for the HTML document**
```php
Meta::setCharset();
// <meta charset="utf-8">

Meta::setCharset('ISO-8859-1');
// <meta charset="ISO-8859-1">
```

**Set the favicon**
```php
Meta::setFavicon('http://site.com/favicon.ico');
// <link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico" />

Meta::setFavicon('http://site.com/favicon.png');
// <link rel="icon" type="image/png" href="http://site.com/favicon.png" />

Meta::setFavicon('http://site.com/favicon.gif');
// <link rel="icon" type="image/gif" href="http://site.com/favicon.gif" />

Meta::setFavicon('http://site.com/favicon.svg');
// <link rel="icon" type="image/svg+xml" href="http://site.com/favicon.svg" />

//You can set additional attributes
Meta::setFavicon('http://site.com/favicon.svg', ['sizes' => '16x16', 'type' => 'custom_type']);
// <link rel="icon" type="custom_type" href="http://site.com/favicon.svg" sizes="16x16" />
```

**Add a custom link tag**
```php
Meta::addLink('apple-touch-icon-precomposed', [
    'href' => 'http://site.com',
    'id' => 'id:213'
]);
// <link rel="apple-touch-icon-precomposed" href="http://site.com" id="id:213" />
```

**Add a link to a css file**
```php
Meta::addStyle('style.css', 'http://site.com/style.css');
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css" />


// You can override or add attributes
Meta::addStyle('style.css', 'http://site.com/style.css', [
    'media' => 'custom', 'defer', 'async'
]);

// <link media="custom" type="text/css" rel="stylesheet" href="http://site.com/style.css" defer async />
```

**Add a link to a script file**
```php
Meta::addScript('script.js', 'http://site.com/script.js');
// <script src="http://site.com/script.js"></script>

// You can override or add attributes
Meta::addScript('script.js', 'http://site.com/script.js', ['async', 'defer', 'id' => 'hj2b3424iu2-dfsfsd']);
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>

// You can specify placement. By default, for scripts it's footer
Meta::addScript('script.js', 'http://site.com/script.js', [], 'custom_placement');
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>
```

**Register a custom tag**
Our package has a lot of ways of extending. One of them is creating new tags. You are able to create a new class and share it with friends or with the laravel community. You can also create a new pull request if you think that your awesome tag is really useful.

```php
class FacebookPixelTag implements \Butschster\Head\Contracts\MetaTags\Entities\TagInterface {

    public function __construct(string $id)
    {
        ...
    }
   
    public function placement(): string
    {
        return 'footer'
    }
    
    public function toHtml()
    {
        return '<script type="text/javascript">...</script>'
    }
}

Meta::addTag('facebook.pixel', new FacebookPixelTag('42b3h23-34234'));
// <script type="text/javascript">...</script>
```

**Register tags from TagsCollection**
```php
$tags = new \Butschster\Head\MetaTags\TagsCollection([
    ...
]);
Meta::registerTags($tags);

// You can specify the placement 
Meta::registerTags($tags, 'footer');
```

**Get a tag by name**
```php
Meta::getTag('author');
```

**Remove a tag by name**
```php
Meta::removeTag('author');
```

**Add a meta tag**
```php
Meta::addMeta('author', [
    'content' => 'butschster',
]);
// <meta name="author" content="butschster">
```

**Add the CSRF-token tag**
```php
Meta::addCsrfToken();
// <meta name="csrf-token" content="....">
```

**Remove all tags**
```php
Meta::reset();
```

**Include required packages**
```php
Meta::includePackages('jquery', 'vuejs');
Meta::includePackages(['jquery', 'vuejs']);

Will load registered packages with names jquery and vuejs and append tags from there to Meta
```

**Register a new package and register all tags from this package**
```php
Meta::setTitle('Current title');

$package = new \Butschster\Head\Packages\Package('custom_package');
$package->setTitle('New title');

// Will replace "Current title" to "New title" after package registration
Meta::registerPackage($package);
```

#### Using meta interfaces
A package has different interfaces which help you set meta tags from your objects

**Seo tags**
```php
namespace App;
use Butschster\Head\Contracts\MetaTags\SeoMetaTagsInterface;
use Butschster\Head\Contracts\MetaTags\RobotsTagsInterface;

class Page extends Model implements SeoMetaTagsInterface, RobotsTagsInterface {

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getRobots(): ?string
    {
        return 'noindex, nofollow';
    }
}

// Controller
use Butschster\Head\Facades\Meta;

class PageController extends Controller {

    public function show(\App\Page $page)
    {
        Meta::setMetaFrom($page);
    }
}
```


#### Meta extending
Meta object contains `Macroable` trait and you can extend it! 

**For example**
```php
//Service Provider
Meta::macro('registerSeoMetaTagsForPage', function (\App\Page $page) {
    $this
        ->prependTitle($page->title)
        ->setKeywords($page->meta_keywords)
        ->setDescription($page->meta_description);
 
});

// Controller
use Butschster\Head\Facades\Meta;

class PageController extends Controller {

    public function show(\App\Page $page)
    {
        Meta::registerSeoMetaTagsForPage($page);
    }
}
```

> *A little bit infirmation about macroable trait https://unnikked.ga/understanding-the-laravel-macroable-trait-dab051f09172*

### Meta tags placements

By default, tags place to head placement. You can specify your own placement and use their all available methods.

```php

Meta::placement('twitter.meta')
    ->addMeta('twitter:card', [
        'content' => 'summary_large_image',
    ])
    ->includePackages('twitter')

// There is the method for footer placement
Meta::footer()->...
    
// View
<body>
    ...
    @meta_tags('twitter.meta')
    ...
    
    @meta_tags('footer')
</body>
```

## Package

A package object has the same methods as Meta object. You can use it for extending and creating custom tags sets.

`\Butschster\Head\Packages\Package`
- This class extend `Butschster\Head\MetaTags\Meta` class
- This class implements `Illuminate\Contracts\Support\Htmlable` interface

**Create a new package and register it in PackageManager**
```php
$package = new \Butschster\Head\Packages\Package('jquery');
PackageManager::register($package);

// or
PackageManager::create('jquery', function($package) {
    ...
});
```

**Get the name of the package**
```php
$package = new \Butschster\Head\Packages\Package('jquery');

$package->getName(); // jquery
```

**Add a link to a css file**
```php
$package = new \Butschster\Head\Packages\Package('jquery');

$package->addStyle('style.css', 'http://site.com/style.css');
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css" />


// You can change or add attributes
$package->addStyle('style.css', 'http://site.com/style.css', [
    'media' => 'custom', 'defer', 'async'
]);

// <link media="custom" type="text/css" rel="stylesheet" href="http://site.com/style.css" defer async />
```

**Add a link to a script file**
```php
$package = new \Butschster\Head\Packages\Package('jquery');

$package->addScript('script.js', 'http://site.com/script.js');
// <script src="http://site.com/script.js"></script>

// You can change or add attributes
$package->addScript('script.js', 'http://site.com/script.js', ['async', 'defer', 'id' => 'hj2b3424iu2-dfsfsd']);
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>

// You can placement. By default it's footer
$package->addScript('script.js', 'http://site.com/script.js', [], 'custom_placement');
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>

Meta::includePackages('jquery')->placement('custom_placement')->toHtml();
```


### Available packages
---

#### OpenGraphPackage
`Butschster\Head\Packages\Entities\OpenGraphPackage`

You can use this package for managing OpenGraph meta tags

```php
$og = new Butschster\Head\Packages\Entities\OpenGraphPackage('some_name');

$og->setType('website')
   ->setSiteName('My awesome site')
   ->setTitle('Post title');
   
// You can render itself

$og->toHtml();
// <meta name="og:type" content="website">
// <meta name="og:site_name" content="My awesome site">
// <meta name="og:title" content="Post title">

// Or just register this package in Meta class and it will be rendered automatically
Meta::registerPackage($og);
```

**setType** Set the type of your object, e.g., "video.movie".
```php
$og->setType('website');
// <meta name="og:type" content="website">
```

**setTitle** Set the title of your object as it should appear within the graph, e.g., "The Rock".
```php
$og->setTitle('Post title');
// <meta name="og:title" content="Post title">
```

**setDescription** Set the description
```php
$og->setDescription('View the album on Flickr.');
// <meta name="og:description" content="View the album on Flickr.">
```

**setSiteName** Set the site name
```php
$og->setSiteName('My awesome site');
// <meta name="og:site_name" content="My awesome site">
```

**setUrl** Set the canonical URL of your object that will be used as its permanent ID in the graph.
```php
$og->setUrl('https://site.com');
// <meta name="og:url" content="https://site.com">
```

**setLocale** Set the locale these tags are marked up in. Of the format language_TERRITORY
```php
$og->setLocale('en_US');
// <meta name="og:locale" content="en_US">
```

**addAlternateLocale**
```php
$og->addAlternateLocale('en_US', 'ru_RU');
// <meta name="og:locale:alternate" content="en_US">
// <meta name="og:locale:alternate" content="ru_RU">
```

**addImage** Add an image URL which should represent your object within the graph.
```php
$og->addImage('http://site.com');
// <meta name="og:image" content="http://site.com">

// You can pass properties
$og->addImage('http://site.com', [
    'secure_url' => 'https://site.com',
    'type' => 'image/png'
]);

// <meta name="og:image" content="http://site.com">
// <meta name="og:image:secure_url" content="https://site.com">
// <meta name="og:image:type" content="image/png">
```

**addVideo** Add an image URL which should represent your object within the graph.
```php
$og->addVideo('http://site.com');
// <meta name="og:video" content="http://site.com">

// You can pass properties
$og->addVideo('http://site.com', [
    'secure_url' => 'https://site.com',
    'type' => 'application/x-shockwave-flash'
]);

// <meta name="og:video" content="http://site.com">
// <meta name="og:video:secure_url" content="https://site.com">
// <meta name="og:video:type" content="application/x-shockwave-flash">
```

#### TwitterCardPackage
`Butschster\Head\Packages\Entities\TwitterCardPackage`

You can use this package for managing Twitter card meta tags

```php
$card = new Butschster\Head\Packages\Entities\TwitterCardPackage('some_name');

$card->setType('summary')
   ->setSite('@username')
   ->setTitle('Post title');
   
// You can render itself

$card->toHtml();
// <meta name="twitter:card" content="summary">
// <meta name="twitter:site" content="@username">
// <meta name="twitter:title" content="Post title">

// Or just register this package in Meta class and it will be rendered automatically
Meta::registerPackage($card);
```

**setType** Set the type of the card: [summary](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary), [summary_large_image](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary-card-with-large-image), [player](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/player-card), [app](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/app-card)
```php
$card->setType('summary');
// <meta name="twitter:card" content="summary">
```

**setSite** Set the @username for the website used in the card footer.
```php
$card->setSite('@username');
// <meta name="twitter:site" content="@username">
```

**setCreator** Set the @username for the content creator / author.
```php
$card->setCreator('@username');
// <meta name="twitter:creator" content="@username">
```

**setTitle** Set the title
```php
$card->setTitle('Post title');
// <meta name="twitter:title" content="Post title">
```

**setDescription** Set the description
```php
$card->setDescription('View the album on Flickr.');
// <meta name="twitter:title" content="View the album on Flickr.">
```

**setImage** Set an image for cards that are of type `summary` or `summary_large_image`
```php
$card->setImage('https://site.com');
// <meta name="twitter:image" content="https://site.com">
```

**setVideo** Set a video to cards that are of type `player`
```php
$card->setVideo('https://site.com/video.mp4', ['width' => 1920, 'height' => 1280]);
// <meta name="twitter:player" content="https://site.com/video.mp4">
// <meta name="twitter:player:width" content="1920">
// <meta name="twitter:player:height" content="1280">
```

**addMeta** Set a custom meta tag
```php
$card->addMeta('image:alt', 'Picture of Pavel Buchnev');
// <meta name="twitter:image:alt" content="Picture of Pavel Buchnev">
```


## PackageManager API

Package manager provide a store for your packages or presets. You can get them by name.

**Create a new package**
```php
PackageManager::create('jquery', function($package) {
    ...
});
```

**Register a new package**
```php
$package = new \Butschster\Head\Packages\Package('jquery');

PackageManager::register($package);
```

**Get all registered packages**
```php
PackageManager::getPackages(): array;
```

**Get registered package by name**
```php
PackageManager::create('jquery', function($package) {
    ...
});

PackageManager::getPackage('jquery'); 
// Will return the registered pacakge or null;
```

### Dependencies

A package can have dependencies. 
```php
PackageManager::create('jquery', function($package) {
    $package->addScript('jquery.js', 'http://site.com/jquery.min.js');
});

PackageManager::create('bootstrap4', function($package) {
    $package->requires('jquery');
    $package->addScript('bootstrap4.js', 'http://site.com/bootstrap4.min.js');
    $package->addStyle('bootstrap4.css', 'http://site.com/bootstrap4.min.css');
});

Meta::includePackages('bootstrap4'); 
// Will load jquery package also
// Head
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/bootstrap4.min.css" />

// Footer
// <script src="http://site.com/jquery.min.js"></script>
// <script src="http://site.com/bootstrap4.min.js"></script>
```


## Helper classes

### Tag
---
`\Butschster\Head\MetaTags\Entities\Tag`

**Create a new tag**
```php
$tag = new \Butschster\Head\MetaTags\Entities\Tag('meta', [
    'name' => 'author',
    'content' => 'butschster'
]);

$tag->toHtml();
// <meta name="author" content="butschster">

// Closed tag
$tag = new \Butschster\Head\MetaTags\Entities\Tag('link', [
    'rel' => 'favicon',
    'href' => 'http://site.com'
], true);

$tag->toHtml();
// <link rel="favicon" href="http://site.com" />
```

**Set the placement**
```php
$tag = new \Butschster\Head\MetaTags\Entities\Tag(...);
$tag->setPlacement('footer');
```

**Get the placement**
```php
$tag = new \Butschster\Head\MetaTags\Entities\Tag(...);
$tag->getPlacement() // Will return specified placement;
```

### Title
---
`\Butschster\Head\MetaTags\Entities\Title`

This class is responsible for title generation

**Set the default part of the title**
```php
$title = new \Butschster\Head\MetaTags\Entities\Title();

$title->setTitle('Laravel');

$title->toHtml(); // <title>Laravel</title>
```

**Prepend a new part of title**
```php
$title = new \Butschster\Head\MetaTags\Entities\Title();

$title->setTitle('Laravel');
$title->prepend('Index page');

$title->toHtml(); // <title>Index page | Laravel</title>
```

**Change default title parts separator**
```php
$title = new \Butschster\Head\MetaTags\Entities\Title();

$title->setTitle('Laravel');
$title->prepend('Index page');
$title->setSeparator('-');

$title->toHtml(); // <title>Index page - Laravel</title>
```

**Specify max length** *(default length is 255)*
```php
$title = new \Butschster\Head\MetaTags\Entities\Title('Lorem Ipsum is simply dummy text of the printing and typesetting');

$title->setMaxLength(20);

$title->toHtml(); // <title>Lorem Ipsum is simpl...</title>
```


### Description
---
`\Butschster\Head\MetaTags\Entities\Description`


#### Script
---
`\Butschster\Head\MetaTags\Entities\Script`

This class is responsible for script links generation

```php
use Butschster\Head\MetaTags\Entities\Script;

$script = new Script('jquery.js', 'http://site.com/script.js', ['defer', 'async']);

$script->toHtml(); 
// <script src="http://site.com/script.js" defer async></script>

Meta::addTag($script);
```

#### Style
---
`\Butschster\Head\MetaTags\Entities\Style`

This class is responsible for css links generation

```php
use Butschster\Head\MetaTags\Entities\Style;

$style = new Style('style.css', 'http://site.com/style.css');

$style->toHtml(); 
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css" />

Meta::addTag($style);
```

#### Favicon
---
`\Butschster\Head\MetaTags\Entities\Favicon`

This class is responsible for favicon link generation


#### Comment
---
`\Butschster\Head\MetaTags\Entities\Comment`

This class is a wrapper for tags, that allows to add comments to your tags

```php
use Butschster\Head\MetaTags\Entities\Comment;
use Butschster\Head\MetaTags\Entities\Favicon;

$favicon = new Favicon('http://site.com/favicon.ico');
$comment = new Comment($favicon, 'Favicon');

Meta::addTag('favicon', $comment);

// Will render
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico" />
<!-- /Favicon -->
```


#### Conditional comment
---
`\Butschster\Head\MetaTags\Entities\ConditionalComment`

This class is a wrapper for tags, that allows to add conditional comments to your tags

```php
use Butschster\Head\MetaTags\Entities\ConditionalComment;
use Butschster\Head\MetaTags\Entities\Favicon;

$favicon = new Favicon('http://site.com/favicon.ico');
$comment = new ConditionalComment($favicon, 'IE 6');

Meta::addTag('favicon', $comment);
<!--[if IE 6]>
<link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico" />
<![endif]-->
```
#### Google Analytics
---
> Has header placement!

```php
use Butschster\Head\MetaTags\Entities\GoogleAnalytics;
$script = new GoogleAnalytics('UA-12345678-1');

Meta::addTag('google.analytics', $script);
```
Will return 

```html
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-12345678-1', 'auto');
    ga('send', 'pageview');
</script>
```
#### Google TagManager
---
> Has header placement!

```php
use Butschster\Head\MetaTags\Entities\GoogleTagManager;
$script = new GoogleTagManager('UA-12345678-1');

Meta::addTag('google.tagmanager', $script);
```
Will return 

```html
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-12345678-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-12345678-1');
</script>
```

#### Yandex Metrika
---
> Has footer placement!

```php
use \Butschster\Head\MetaTags\Entities\YandexMetrika;
$script = new YandexMetrika('20925319');

Meta::addTag('yandex.metrika', $script);
```
Will return 

```html
<script type="text/javascript">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(20925319, "init", {clickmap:true,trackLinks:true,accurateTrackBounce:true,webvisor:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/20925319" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
```

**Change clickmap setting**
```php
$script = new YandexMetrika('20925319');

$script->clickmap(bool);
```

**Change webvisor setting**
```php
$script = new YandexMetrika('20925319');

$script->webvisor(bool);
```

**Change trackLinks setting**
```php
$script = new YandexMetrika('20925319');

$script->trackLinks(bool);
```

**Change accurateTrackBounce setting**
```php
$script = new YandexMetrika('20925319');

$script->accurateTrackBounce(bool);
```

**Change trackHash setting**
```php
$script = new YandexMetrika('20925319');

$script->trackHash(bool);
```

**Change eCommerce setting**
```php
$script = new YandexMetrika('20925319');

$script->eCommerce(string $containerName);
```

**Use alternate CDN**
```php
$script = new YandexMetrika('20925319');

$script->useCDN();
```

**Disable noscript tag**
```php
$script = new YandexMetrika('20925319');

$script->disableNoScript();
```

#### Javascript variables
---

```php
use \Butschster\Head\MetaTags\Entities\JavascriptVariables;

$variables = new JavascriptVariables([
    'string' => 'Hello world',
    'number' => 4815162342,
    'bool' => true,
    'nullable' => null
]);

// you can put new variable
$variables->put('array', ['jquery', 'vuejs']);

Meta::addTag('variables', $variables);
```

Will return 
```html
<script>
window.array = ["jquery","vuejs"];
window.string = 'Hello world';
window.number = 4815162342;
window.bool = true;
window.nullable = null;
</script>
```

You can change namespace

```php
use \Butschster\Head\MetaTags\Entities\JavascriptVariables;

$variables = new JavascriptVariables([
    'string' => 'Hello world',
    'number' => 4815162342,
], 'custom');
```

Will return
```html
<script>
window.custom = window.custom || {};
custom.string = 'Hello world';
custom.number = 4815162342;
</script>
```

# Use cases

### Multiple favicons

You can use your own package for that. 

At first create your package in the MetaTagsServiceProvider `App\Providers\MetaTagsServiceProvider`
```php
namespace App\Providers;

use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Head\MetaTags\Entities\ConditionalComment;
use Butschster\Head\Facades\PackageManager;
use Butschster\Head\Packages\Package;

class MetaTagsServiceProvider extends ServiceProvider {

    ...
    
    protected function packages()
    {
        PackageManager::create('favicons', function(Package $package) {
            $sizes = ['16x16', '32x32', '64x64'];
    
            foreach ($sizes as $size) {
                $package->addTag(
                    'favicon.'.$size, 
                    new Favicon('http://site.com/favicon-'.$size.'.png', [
                        'sizes' => $size
                    ])
                );
            }
    
            $package->addTag('favicon.ie', new ConditionalComment(
                new Favicon('http://site.com/favicon-ie.png'), 'IE gt 6'
            ));
        });
    }
    
    ...
}
```

And then append this package into `packages` section in `config/meta_tags.php`:

```php
...
'packages' => [
    'favicons'
],
...
```

And the every page you will see in the head seaction something like that:

```html
<head>
    ...
    <title>...</title>
    <link rel="icon" type="image/png" href="http://site.com/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="http://site.com/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="http://site.com/favicon-64x64.png" sizes="64x64" />
    <!--[if IE gt 6]>
    <link rel="icon" type="image/png" href="http://site.com/favicon-ie.png" />
    <![endif]-->
    ...
</head>
```

# Extending

If you want to extend Meta class you can do it in the `App\Providers\MetaTagsServiceProvider`. Just override `registerMeta` method.

```php
namespace App\Providers;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\Packages\ManagerInterface;

class MetaTagsServiceProvider {

    ...

    protected function registerMeta(): void
    {
        $this->app->singleton(MetaInterface::class, function () {
            $meta = new Meta(
                $this->app[ManagerInterface::class],
                $this->app['config']
            );
    
    
            // It just an imagination, you can automatically 
            // add favicon if it exists
            if (file_exists(public_path('favicon.ico'))) {
                $meta->setFavicon('/favicon.ico');
            }
    
            $meta->includePackages('fonts', 'assets');
            
            // This method gets default values from config and creates tags
            // If you don't want to use default values just remove it.
            $meta->initialize();
    
            return $meta;
        });
    }

    ...
}
```
