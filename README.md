# SEO Meta Tags - Tools for Laravel

With this package you can manage header Meta Tags, CSS and JavaScript tags.

[![Build Status](https://travis-ci.org/butschster/LaravelMetaTags.svg)](https://travis-ci.org/butschster/LaravelMetaTags)

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
You can use either Facade `\Butschster\Head\Facades` or `\Butschster\Head\MetaTags\MetaInterface` in your controller

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


### Meta API

#### Methods


```php
// Set the meta title
Meta::setTitle('Laravel');
// <title>Laravel</title>
```

```php
Prepend title part to default title

Meta::setTitle('Laravel')
    ->prependTitle('Home page');
// <title>Home page - Laravel</title>
```

```php
Set the title separator

Meta::setTitleSeparator('->')
    ->setTitle('Laravel')
    ->prependTitle('Home page');
// <title>Home page -> Laravel</title>
```

```php
Set the meta description

Meta::setDescription('Awesome page');
// <meta name="description" content="Awesome page">
```

```php
Set the meta keywords

Meta::setKeywords('Awesome keywords');
// <meta name="keywords" content="Awesome keywords">


Meta::setKeywords(['Awesome keyword', 'keyword2']);
// <meta name="keywords" content="Awesome keyword, keyword2">
```

```php
Set the meta description

Meta::setRobots('nofollow,noindex');
// <meta name="robots" content="nofollow,noindex">
```

```php
Set the meta content type

Meta::setContentType('text/html');
// <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

Meta::setContentType('text/html', 'ISO-8859-1');
// <meta http-equiv="Content-Type" content="text/html; ISO-8859-1">
```

```php
Set the viewport

Meta::setViewport('width=device-width, initial-scale=1');
// <meta name="viewport" content="width=device-width, initial-scale=1">
```

```php
Set the prev href

Meta::setPrevHref('http://site.com/prev');
// <link rel="prev" href="http://site.com/prev" />
```

```php
Set the next href

Meta::setNextHref('http://site.com/next');
// <link rel="next" href="http://site.com/next" />
```

```php
Set the canonical link

Meta::setCanonical('http://site.com');
// <link rel="canonical" href="http://site.com" />
```

```php
Set canonical link, prev and next from paginator object

$news = \App\News::paginate();

Meta::setPaginationLinks($news);

// <link rel="prev" href="http://site.com/prev" />
// <link rel="next" href="http://site.com/next" />
// <link rel="canonical" href="http://site.com" />
```

```php
Set a hreflang link

Meta::setHrefLang('en', http://site.com/en');
Meta::setHrefLang('ru', http://site.com/ru');

// <link rel="alternate" hreflang="en" href="http://site.com/en" />
// <link rel="alternate" hreflang="ru" href="http://site.com/ru" />
```

```php
Specify the character encoding for the HTML document

Meta::setCharset();
// <meta charset="utf-8">

Meta::setCharset('ISO-8859-1');
// <meta charset="ISO-8859-1">
```

```php
Set the canonical link

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

```php
Set a custom link tag

Meta::addLink('apple-touch-icon-precomposed', [
    'href' => 'http://site.com',
    'id' => 'id:213'
]);
// <link rel="apple-touch-icon-precomposed" href="http://site.com" id="id:213" />
```

```php
Set a custom tag

class FacebookPixelTag implements \Butschster\Head\MetaTags\TagInterface {

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

```php
Set a custom meta tag

Meta::addMeta('author', [
    'content' => 'butschster',
]);
// <meta name="author" content="butschster">
```

```php
Add the CSRF token tag.

Meta::addCsrfToken();
// <meta name="csrf-token" content="....">
```

```php
Remove all meta tags

Meta::reset();
```

```php
Include required packages

Meta::includePackages('jquery', 'vuejs');
Meta::includePackages(['jquery', 'vuejs']);

Will load registered packages with names jquery and vuejs and append tags from there to Meta
```

```php
Register a new package and register all tags from this package

Meta::setTitle('Current title');

$package = new \Butschster\Head\Packages\Package('custom_package');
$package->setTitle('New title');

// Will replace "Current title" to "New title" after package registration
Meta::registerPackage($package);
```

#### Meta extending
Meta object contains `Macroable` trait and you can extend it! https://unnikked.ga/understanding-the-laravel-macroable-trait-dab051f09172

For example
```php
//Service Provider
Meta::macro('registerSeoMetaTagsForPage', function (\App\Page $page) {
    $this
        ->prependTitle($page->title)
        ->setKeywords($page->meta_keywords)
        ->setDescription($page->meta_description);
 
});

// Controller
use Butschster\Head\MetaTags\MetaInterface;

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

#### Meta tags placements

By default tags place to head placement. You can specify your own placement and use ther all available methods.

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

### Package API

A package object has the same methods as Meta object and also


```php
Create a new package and register it in PackageManager

$package = new \Butschster\Head\Packages\Package('jquery');
PackageManager::register($package);

// or
PackageManager::create('jquery', function($package) {
    ...
});
```

```php
Get the name of the package

$package = new \Butschster\Head\Packages\Package('jquery');

$package->getName(); // jquery
```

```php
Set a link to css file

$package = new \Butschster\Head\Packages\Package('jquery');

$package->addStyle('style.css', 'http://site.com/style.css');
// <link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css" />


// You can change or add attributes
$package->addStyle('style.css', 'http://site.com/style.css', [
    'media' => 'custom', 'defer', 'async'
]);

// <link media="custom" type="text/css" rel="stylesheet" href="http://site.com/style.css" defer async />
```

```php
Set a link to script file

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

### PackageManager API

Package manager provide a store for your packages or presets


```php
Create a new package

PackageManager::create('jquery', function($package) {
    ...
});
```

```php
Register a new package

$package = new \Butschster\Head\Packages\Package('jquery');

PackageManager::register($package);
```

```php
Get all registered packages

PackageManager::getPackages(): array;
```

```php
Get registered package by name

PackageManager::create('jquery', function($package) {
    ...
});

PackageManager::getPackage('jquery'); // Will return the registered pacakge or null;
```