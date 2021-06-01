<?php

namespace Butschster\Head\Contracts\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Concerns\ManageMetaTags;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\TagsCollection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

interface MetaInterface extends Htmlable, PlacementsInterface, Arrayable
{
    /**
     * Set meta information from object
     *
     * @param object $object
     * @return $this
     */
    public function setMetaFrom($object);

    /**
     * Set the meta title
     *
     * While the title tag doesn’t start with "meta," it is in the header and contains information that's very
     * important to SEO. You should always have a unique title tag on every page that describes the page.
     *
     * Optimal title length. Google typically displays the first 50–60 characters of a title tag. If you keep your
     * titles under 60 characters, our research suggests that you can expect about 90% of your titles to display
     * properly.
     *
     * @param string $title
     * @param int|null $maxLength
     *
     * @return $this
     */
    public function setTitle(string $title, int $maxLength = null);

    /**
     * Prepend title part to default title
     *
     * @param string $text
     *
     * @return $this
     */
    public function prependTitle(string $text);

    /**
     * Set the title separator
     *
     * @param string $separator
     *
     * @return $this
     */
    public function setTitleSeparator(string $separator);

    /**
     * Set the meta description
     *
     * The infamous meta description tag is used for one major purpose: to describe the page to searchers as they
     * read through the SERPs. This tag doesn't influence ranking, but it's very important regardless. It's the ad
     * copy that will determine if users click on your result. Keep it within 160 characters, and write it to catch
     * the user's attention. Sell the page — get them to click on the result. Here's a great article on meta
     * descriptions that goes into more detail.
     *
     * @param string $description
     * @param int|null $maxLength
     *
     * @return $this
     */
    public function setDescription(string $description, ?int $maxLength = null);

    /**
     * Get the meta description
     *
     * @return TagInterface|null
     */
    public function getDescription(): ?TagInterface;

    /**
     * Set the meta keywords
     *
     * @param string|array $keywords
     * @param int|null $maxLength
     *
     * @return $this
     */
    public function setKeywords($keywords, ?int $maxLength = null);

    /**
     * Get the meta keywords
     *
     * @return TagInterface|null
     */
    public function getKeywords(): ?TagInterface;

    /**
     * Set the meta robots
     *
     * One huge misconception is that you have to have a robots meta tag. Let's make this clear: In terms of indexing
     * and link following, if you don't specify a meta robots tag, they read that as index,follow. It's only if
     * you want to change one of those two commands that you need to add meta robots. Therefore, if you want to noindex
     * but follow the links on the page, you would add the following tag with only the noindex, as the follow is
     * implied. Only change what you want to be different from the norm.
     *
     * @param string $behavior
     *
     * @return $this
     */
    public function setRobots(string $behavior);

    /**
     * Get the meta robots
     *
     * @return TagInterface|null
     */
    public function getRobots(): ?TagInterface;

    /**
     * Set the meta content type
     *
     * This tag is necessary to declare your character set for the page and should be present on every page. Leaving
     * this out could impact how your page renders in the browser. A few options are listed below, but your web
     * designer should know what's best for your site.
     *
     * @param string $type
     * @param string $charset
     * @return $this
     */
    public function setContentType(string $type, string $charset = 'utf-8');

    /**
     * Get Meta content type
     *
     * @return TagInterface|null
     */
    public function getContentType(): ?TagInterface;

    /**
     * Set the viewport
     *
     * In this mobile world, you should be specifying the viewport. If you don’t, you run the risk of having a
     * poor mobile experience
     *
     * @param string $viewport
     *
     * @return $this
     */
    public function setViewport(string $viewport);

    /**
     * Get Viewport
     *
     * @return TagInterface|null
     */
    public function getViewport(): ?TagInterface;

    /**
     * Set the prev link tag
     *
     * The rel="next" and rel="prev" link attributes are used to indicate the relations between a sequence of pages
     * to search engines.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setPrevHref(string $url);

    /**
     * Get the prev link tag
     *
     * @return TagInterface|null
     */
    public function getPrevHref(): ?TagInterface;

    /**
     * Set the next link tag
     *
     * The rel="next" and rel="prev" link attributes are used to indicate the relations between a sequence of pages
     * to search engines.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setNextHref(string $url);

    /**
     * Get the next link tag
     *
     * @return TagInterface|null
     */
    public function getNextHref(): ?TagInterface;

    /**
     * Set the canonical link
     *
     * @param string $url
     *
     * @return $this
     */
    public function setCanonical(string $url);

    /**
     * Get the canonical link tag
     *
     * @return TagInterface|null
     */
    public function getCanonical(): ?TagInterface;

    /**
     * Set canonical link, prev and next from paginator object
     *
     * @param Paginator $paginator
     *
     * @return $this
     */
    public function setPaginationLinks(Paginator $paginator);

    /**
     * Set a hreflang link
     *
     * If you've got a website that's available in multiple languages, you want search engines to show your content
     * to the right audiences. In order to help search engines do so, you should use the hreflang attribute to indicate
     * the language that content is in, and optionally also what region it's meant for.
     *
     * @param string $lang
     * @param string $url
     *
     * @return $this
     */
    public function setHrefLang(string $lang, string $url);

    /**
     * Get the hreflang link tag
     *
     * @param string $lang
     *
     * @return TagInterface|null
     */
    public function getHrefLang(string $lang): ?TagInterface;

    /**
     * @param GeoMetaInformationInterface $geo
     *
     * @return $this
     */
    public function setGeo(GeoMetaInformationInterface $geo);

    /**
     * Specify the character encoding for the HTML document
     *
     * @param string $charset
     *
     * @return $this
     */
    public function setCharset(string $charset = 'utf-8');

    /**
     * Get the character encoding tag
     *
     * @return TagInterface|null
     */
    public function getCharset(): ?TagInterface;

    /**
     * Add a favicon tag
     *
     * @param string $href
     * @param array $attributes
     *
     * @return $this
     */
    public function setFavicon(string $href, array $attributes = []);

    /**
     * Add webmaster tag.
     *
     * @param string $service Supported services [google, yandex, pinterest, alexa, bing]
     * @param string $content
     *
     * @return $this
     */
    public function addWebmaster(string $service, string $content);

    /**
     * Create a custom link tag
     *
     * @param string $name
     * @param array $attributes
     *
     * @return $this
     */
    public function addLink(string $name, array $attributes);

    /**
     * Create a custom meta tag
     *
     * @param string $name
     * @param array $attributes
     * @param bool $checkNameAttribute
     *
     * @return $this
     */
    public function addMeta(string $name, array $attributes, bool $checkNameAttribute = true);

    /**
     * Add a custom tag
     *
     * @param string $name
     * @param TagInterface $tag
     * @param string|null $placement
     *
     * @return $this
     */
    public function addTag(string $name, TagInterface $tag, ?string $placement = null);

    /**
     * Register tags from collection
     *
     * @param TagsCollection $tags
     * @param string|null $placement
     *
     * @return $this
     */
    public function registerTags(TagsCollection $tags, ?string $placement = null);

    /**
     * Get the tag by name
     *
     * @param string $name
     * @return TagInterface|null
     */
    public function getTag(string $name): ?TagInterface;

    /**
     * Remove tag by name
     *
     * @param string $name
     *
     * @return $this
     */
    public function removeTag(string $name);

    /**
     * Set a link to css file
     *
     * @param string $name
     * @param string $src
     * @param array $attributes
     *
     * @return $this
     */
    public function addStyle(string $name, string $src, array $attributes = []);

    /**
     * Set a link to script file
     *
     * @param string $name
     * @param string $src
     * @param array $attributes
     * @param string $placement
     *
     * @return $this
     */
    public function addScript(string $name, string $src, array $attributes = [], string $placement = Meta::PLACEMENT_FOOTER);

    /**
     * Add the CSRF token tag.
     *
     * @return $this
     */
    public function addCsrfToken();

    /**
     * Remove all tags
     *
     * @return $this
     */
    public function reset();

    /**
     * Get head meta tags placement bag
     *
     * @return PlacementInterface
     */
    public function head(): PlacementInterface;

    /**
     * Get footer meta tags placement bag
     *
     * @return PlacementInterface
     */
    public function footer(): PlacementInterface;

    /**
     * Include required packages
     *
     * @param array|string $packages
     *
     * @return $this
     */
    public function includePackages($packages);

    /**
     * Register a new package and register all tags from this package
     *
     * @param PackageInterface $package
     *
     * @return $this
     */
    public function registerPackage(PackageInterface $package);

    /**
     * Replace package with a new one with the same name
     * @param PackageInterface $package
     *
     * @return $this
     */
    public function replacePackage(PackageInterface $package);

    /**
     * Remove package by name
     * @param string $name
     *
     * @return $this
     */
    public function removePackage(string $name);

    /**
     * Find package by name
     * @param string $name Package name
     * @return PackageInterface|null
     */
    public function getPackage(string $name): ?PackageInterface;
}
