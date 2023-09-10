<?php

namespace Butschster\Head\Contracts\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\TagsCollection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

interface MetaInterface extends Htmlable, PlacementsInterface, Arrayable
{
    /**
     * Set meta information from object
     */
    public function setMetaFrom(object $object): self;

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
     * @param positive-int|null $maxLength
     */
    public function setTitle(string $title, int $maxLength = null): self;

    /**
     * Prepend title part to default title
     */
    public function prependTitle(string $text): self;

    /**
     * Set the title separator
     */
    public function setTitleSeparator(string $separator): self;

    /**
     * Set the meta description
     *
     * The infamous meta description tag is used for one major purpose: to describe the page to searchers as they
     * read through the SERPs. This tag doesn't influence ranking, but it's very important regardless. It's the ad
     * copy that will determine if users click on your result. Keep it within 160 characters, and write it to catch
     * the user's attention. Sell the page — get them to click on the result. Here's a great article on meta
     * descriptions that goes into more detail.
     *
     * @param positive-int|null $maxLength
     */
    public function setDescription(string $description, ?int $maxLength = null): self;

    /**
     * Get the meta description
     */
    public function getDescription(): ?TagInterface;

    /**
     * Set the meta keywords
     *
     * @param string|array $keywords
     * @param positive-int|null $maxLength
     */
    public function setKeywords($keywords, ?int $maxLength = null): self;

    /**
     * Get the meta keywords
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
     */
    public function setRobots(string $behavior): self;

    /**
     * Get the meta robots
     */
    public function getRobots(): ?TagInterface;

    /**
     * Set the meta content type
     *
     * This tag is necessary to declare your character set for the page and should be present on every page. Leaving
     * this out could impact how your page renders in the browser. A few options are listed below, but your web
     * designer should know what's best for your site.
     */
    public function setContentType(string $type, string $charset = 'utf-8'): self;

    /**
     * Get Meta content type
     */
    public function getContentType(): ?TagInterface;

    /**
     * Set the viewport
     *
     * In this mobile world, you should be specifying the viewport. If you don’t, you run the risk of having a
     * poor mobile experience
     */
    public function setViewport(string $viewport): self;

    /**
     * Get Viewport
     */
    public function getViewport(): ?TagInterface;

    /**
     * Set the prev link tag
     *
     * The rel="next" and rel="prev" link attributes are used to indicate the relations between a sequence of pages
     * to search engines.
     */
    public function setPrevHref(string $url): self;

    /**
     * Get the prev link tag
     */
    public function getPrevHref(): ?TagInterface;

    /**
     * Set the next link tag
     *
     * The rel="next" and rel="prev" link attributes are used to indicate the relations between a sequence of pages
     * to search engines.
     */
    public function setNextHref(string $url): self;

    /**
     * Get the next link tag
     */
    public function getNextHref(): ?TagInterface;

    /**
     * Set the canonical link
     */
    public function setCanonical(string $url): self;

    /**
     * Get the canonical link tag
     */
    public function getCanonical(): ?TagInterface;

    /**
     * Set canonical link, prev and next from paginator object
     */
    public function setPaginationLinks(Paginator $paginator): self;

    /**
     * Set a hreflang link
     *
     * If you've got a website that's available in multiple languages, you want search engines to show your content
     * to the right audiences. In order to help search engines do so, you should use the hreflang attribute to indicate
     * the language that content is in, and optionally also what region it's meant for.
     */
    public function setHrefLang(string $lang, string $url): self;

    /**
     * Get the hreflang link tag
     */
    public function getHrefLang(string $lang): ?TagInterface;

    public function setGeo(GeoMetaInformationInterface $geo): self;

    /**
     * Specify the character encoding for the HTML document
     */
    public function setCharset(string $charset = 'utf-8'): self;

    /**
     * Get the character encoding tag
     */
    public function getCharset(): ?TagInterface;

    /**
     * Add a favicon tag
     */
    public function setFavicon(string $href, array $attributes = []): self;

    /**
     * Add webmaster tag.
     *
     * @param string $service Supported services [google, yandex, pinterest, alexa, bing]
     */
    public function addWebmaster(string $service, string $content): self;

    /**
     * Create a custom link tag
     */
    public function addLink(string $name, array $attributes): self;

    /**
     * Create a custom meta tag
     */
    public function addMeta(string $name, array $attributes, bool $checkNameAttribute = true): self;

    /**
     * Add a custom tag
     */
    public function addTag(string $name, TagInterface $tag, ?string $placement = null): self;

    /**
     * Register tags from collection
     */
    public function registerTags(TagsCollection $tags, ?string $placement = null): self;

    /**
     * Get the tag by name
     */
    public function getTag(string $name): ?TagInterface;

    /**
     * Remove tag by name
     */
    public function removeTag(string $name): self;

    /**
     * Set a link to css file
     */
    public function addStyle(string $name, string $src, array $attributes = []): self;

    /**
     * Set a link to script file
     */
    public function addScript(string $name, string $src, array $attributes = [], string $placement = Meta::PLACEMENT_FOOTER): self;

    /**
     * Add the CSRF token tag.
     */
    public function addCsrfToken(): self;

    /**
     * Remove all tags
     */
    public function reset(): self;

    /**
     * Get head meta tags placement bag
     */
    public function head(): PlacementInterface;

    /**
     * Get footer meta tags placement bag
     */
    public function footer(): PlacementInterface;

    /**
     * Include required packages
     */
    public function includePackages($packages): self;

    /**
     * Register a new package and register all tags from this package
     */
    public function registerPackage(PackageInterface $package): self;

    /**
     * Replace package with a new one with the same name
     */
    public function replacePackage(PackageInterface $package): self;

    /**
     * Remove package by name
     */
    public function removePackage(string $name): self;

    /**
     * Find package by name
     */
    public function getPackage(string $name): ?PackageInterface;
}
