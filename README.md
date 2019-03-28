![Image](https://camo.githubusercontent.com/232b6e30a642047f3b1de99599e8f14f05198f6d/68747470733a2f2f686162726173746f726167652e6f72672f776562742f79762f74742f612d2f79767474612d36746e6d366170776373346d63736f6774777a626d2e6a706567)

# SEO Meta Tags - Tools for Laravel

With this package you can manage header Meta Tags, CSS and JavaScript tags.

[![Build Status](https://travis-ci.org/butschster/LaravelMetaTags.svg)](https://travis-ci.org/butschster/LaravelMetaTags) [![Latest Stable Version](https://poser.pugx.org/butschster/meta-tags/v/stable)](https://packagist.org/packages/butschster/meta-tags) [![Total Downloads](https://poser.pugx.org/butschster/meta-tags/downloads)](https://packagist.org/packages/butschster/meta-tags) [![License](https://poser.pugx.org/butschster/meta-tags/license)](https://packagist.org/packages/butschster/meta-tags)

## Features
- Manage meta tags, set titles, charset, pagination links, e.t.c.
- Manage styles, scripts in different places of your HTML
- Build styles and scripts into packages and include by their names in Controllers
- Create your own meta tags configuration packages

## Installation and Configuration

From the command line run
```shell
composer require butschster/meta-tags
```

Once Meta Tags is installed you need to register the service provider. Just run artisan command
```shell
php artisan meta-tags:install
```

This command will install MetaTagsServiceProvider and will publish config `config/meta_tags.php`

After running this command, verify that the `App\Providers\MetaTagsServiceProvider` was added to the providers array in your app `config/app.php` configuration file. If it wasn't, you should add it manually. Of course, if your application  does not use the App namespace, you should update the provider class name as needed.
That's it! Next, you may navigate to the `App\Providers\MetaTagsServiceProvider` and configure default settings.

## Usage

Open service provider `App\Providers\MetaTagsServiceProvider` and there you can configure default settings.

#### Service container registration
```php
protected function registerMeta(): void
{
    // Service container initialization
    $this->app->singleton(MetaInterface::class, function () {
    
        // Create meta object
        $meta = new Meta(
            $this->app[ManagerInterface::class]
        );

        // Load default settings from config file
        $config = $this->app['config']['meta_tags.meta'];

        // Title by default
        $meta->setTitle($config['title'])
            // Title segments separator by default
            ->setTitleSeparator($config['separator'])
            
            // Meta description by default
            ->setDescription($config['description'])
            
            // Meta keywords by default
            ->setKeywords($config['keywords'])
            
            // Charset by default
            ->setCharset($config['charset'])
            
            // Favicon by default
            ->setFavicon(asset('favicon.ico'));

        // Viewport meta tag by default
        if ($viewport = $config['viewport']) {
            $meta->setViewport($viewport);
        }

        // Robots meta tag by default
        if ($robots = $config['robots']) {
            $meta->setRobots($robots);
        }

        // Add csrf token everywhere
        if ($config['csrf_token']) {
            $meta->addCsrfToken();
        }

        // Include package
        $meta->includePackages('jquery', 'bootstrap');

        return $meta;
    });
}
```

#### Register packages

```php
protected function packages()
{
   PackageManager::create('jquery', function($package) {
      $package->addScript(
         'jquery.js', 
         'https://code.jquery.com/jquery-3.3.1.min.js', 
         ['defer']
      );
   })->create('bootstrap', function($package) {
      $package->addStyle(
         'bootstrap.css', 
         'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'
      )->AddScript(
         'popper.js', 
         'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'
      )->AddScript(
         'bootstrap.js', 
         'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'
      );
   });
}

```

#### View

Just put this code `{!! Meta::toHtml() !!}` into your HTML and that's all.


```html
<!DOCTYPE html>
<html lang="en">
    <head>
        {!! Meta::toHtml() !!}
    </head>
    <body>
        <div id="app">
            ...        
        </div>
    
        <!-- Footer data -->
        {!! Meta::footer()->toHtml() !!}
    </body>
</html>

```

### Controller
You can use either Facade `\Butschster\Head\Facades` or `\Butschster\Head\Contracts\MetaTags\MetaInterface` in your controller

```php
use Butschster\Head\MetaTags\MetaInterface;

class HomerController extends Controller {

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
           // Will include all tags from calendar package
           ->includePackages('calendar')
           // Will include next, prev, canonical links
           ->setPaginationLinks($news)
           // Will change default favicon
           ->setFavicon(asset('favicon-index.ico'));
    }
}
```


## Meta API

`\Butschster\Head\MetaTags\Meta`
- This class implements `Illuminate\Contracts\Support\Htmlable` interface

### Methods

**Set the meta title**
```php
Meta::setTitle('Laravel');
// <title>Laravel</title>
```

**Prepend title part to default title**
```php
Meta::setTitle('Laravel')
    ->prependTitle('Home page');
// <title>Home page - Laravel</title>
```

**Set the title separator**
```php
Meta::setTitleSeparator('->')
    ->setTitle('Laravel')
    ->prependTitle('Home page');
// <title>Home page -> Laravel</title>
```

**Set the meta description**
```php
Meta::setDescription('Awesome page');
// <meta name="description" content="Awesome page">
```

**Set the meta keywords**
```php
Meta::setKeywords('Awesome keywords');
// <meta name="keywords" content="Awesome keywords">


Meta::setKeywords(['Awesome keyword', 'keyword2']);
// <meta name="keywords" content="Awesome keyword, keyword2">
```

**Set the meta description**
```php
Meta::setRobots('nofollow,noindex');
// <meta name="robots" content="nofollow,noindex">
```

**Set the meta content type**
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

**Specify the character encoding for the HTML document**
```php
Meta::setCharset();
// <meta charset="utf-8">

Meta::setCharset('ISO-8859-1');
// <meta charset="ISO-8859-1">
```

**Set the canonical link**
```php
Meta::setFavicon('http://site.com/favicon.ico');
// <link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico" />

Meta::setFavicon('http://site.com/favicon.png');
// <link rel="icon" type="image/png" href="http://site.com/favicon.png" />

Meta::setFavicon('http://site.com/favicon.gif');
// <link rel="icon" type="image/gif" href="http://site.com/favicon.gif" />

Meta::setFavicon('http://site.com/favicon.svg');
// <link rel="icon" type="image/svg+xml" href="http://site.com/favicon.svg" />

You can pass additional attributes
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

**Add a link to css file**
```php
Meta::addStyle('style.css', 'http://site.com/style.css');
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css" />


// You can change or add attributes
Meta::addStyle('style.css', 'http://site.com/style.css', [
    'media' => 'custom', 'defer', 'async'
]);

// <link media="custom" type="text/css" rel="stylesheet" href="http://site.com/style.css" defer async />
```

**Add a link to script file**
```php
Meta::addScript('script.js', 'http://site.com/script.js');
// <script src="http://site.com/script.js"></script>

// You can change or add attributes
Meta::addScript('script.js', 'http://site.com/script.js', ['async', 'defer', 'id' => 'hj2b3424iu2-dfsfsd']);
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>

// You can placement. By default it's footer
Meta::addScript('script.js', 'http://site.com/script.js', [], [], 'custom_placement');
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>
```

**Add a custom tag**
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
    
    public function getAttributes(): array
    {
        return [];
    }
    
    public function toHtml()
    {
        return '<script type="text/javascript">...</script>'
    }
}

Meta::addTag('facebook.pixel', new FacebookPixelTag('42b3h23-34234'));
// <script type="text/javascript">...</script>
```

**Add a custom meta tag**
```php
Meta::addMeta('author', [
    'content' => 'butschster',
]);
// <meta name="author" content="butschster">
```

**Add the CSRF token tag.**
```php
Meta::addCsrfToken();
// <meta name="csrf-token" content="....">
```

**Remove all meta tags**
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

#### Meta extending
Meta object contains `Macroable` trait and you can extend it! https://unnikked.ga/understanding-the-laravel-macroable-trait-dab051f09172

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
use Butschster\Head\Contracts\MetaTags\MetaInterface;

class HomerController extends Controller {

    protected $meta;
 
    public function __contruct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }
    
    public function show(\App\Page $page)
    {
        $this->meta->registerSeoMetaTagsForPage($page);
    }
}

```

### Meta tags placements

By default, tags place to head placement. You can specify your own placement and use ther all available methods.

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
    {!! Meta::placement('twitter.meta')->toHtml() !!}
    ...
    
    {!! Meta::footer()->toHtml() !!}
</body>
```

## Package API

A package object has the same methods as Meta object and also

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

**Add a link to css file**
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

**Add a link to script file**
```php
$package = new \Butschster\Head\Packages\Package('jquery');

$package->addScript('script.js', 'http://site.com/script.js');
// <script src="http://site.com/script.js"></script>

// You can change or add attributes
$package->addScript('script.js', 'http://site.com/script.js', ['async', 'defer', 'id' => 'hj2b3424iu2-dfsfsd']);
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>

// You can placement. By default it's footer
$package->addScript('script.js', 'http://site.com/script.js', [], [], 'custom_placement');
// <script src="http://site.com/script.js" async defer id="hj2b3424iu2-dfsfsd"></script>

Meta::includePackages('jquery')->placement('custom_placement')->toHtml();
```

## PackageManager API

Package manager provide a store for your packages or presets

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
$tag->placement() // Will return specified placement;

```

**Get attributes**
```php
$tag = new \Butschster\Head\MetaTags\Entities\Tag('link', [
    'rel' => 'favicon',
    'href' => 'http://site.com'
]);

$tag->getAttributes();
// Will return 
[
    'rel' => 'favicon',
    'href' => 'http://site.com'
]
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

**Prepent a new part of title**
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

#### Script
---
`\Butschster\Head\MetaTags\Entities\Script`

This class is responsible for script links generation

```php
$script = new \Butschster\Head\MetaTags\Entities\Script('jquery.js', 'http://site.com/script.js', ['defer', 'async'])

$script->toHtml(); 
// <script src="http://site.com/script.js" defer async></script>

Meta::addTag($script);
```

#### Style
---
`\Butschster\Head\MetaTags\Entities\Style`

This class is responsible for css links generation

```php
$style = new \Butschster\Head\MetaTags\Entities\Style('style.css', 'http://site.com/style.css')

$style->toHtml(); 
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css" />

Meta::addTag($style);
```

#### Favicon
---
`\Butschster\Head\MetaTags\Entities\Favicon`

This class is responsible for favicon link generation