<?php

namespace Butschster\Head\MetaTags;

use Illuminate\Contracts\Support\Htmlable;

interface MetaInterface extends Htmlable
{
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
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Set the title separator
     *
     * @param string $separator
     * @return $this
     */
    public function setTitleSeparator(string $separator);

    /**
     * Sets the meta description
     *
     * The infamous meta description tag is used for one major purpose: to describe the page to searchers as they
     * read through the SERPs. This tag doesn't influence ranking, but it's very important regardless. It's the ad
     * copy that will determine if users click on your result. Keep it within 160 characters, and write it to catch
     * the user's attention. Sell the page — get them to click on the result. Here's a great article on meta
     * descriptions that goes into more detail.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Set the meta keywords
     *
     * @param string|array $keywords
     * @return $this
     */
    public function setKeywords($keywords);

    /**
     * Get the meta keywords
     *
     * @return Tag|null
     */
    public function getKeywords(): ?Tag;

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
     * @return $this
     */
    public function setRobots(string $behavior);

    /**
     * Get the meta robots
     *
     * @return Tag|null
     */
    public function getRobots(): ?Tag;

    /**
     * Set Meta content type
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
     * @return Tag|null
     */
    public function getContentType(): ?Tag;

    /**
     * Set Viewport
     *
     * In this mobile world, you should be specifying the viewport. If you don’t, you run the risk of having a
     * poor mobile experience
     *
     * @param string $viewport
     * @return $this
     */
    public function setViewport(string $viewport);

    /**
     * Get Viewport
     *
     * @return Tag|null
     */
    public function getViewport(): ?Tag;

    /**
     * The rel="next" and rel="prev" link attributes are used to indicate the relations between a sequence of pages
     * to search engines.
     *
     * @param string $url
     * @return $this
     */
    public function setPrevHref(string $url);

    /**
     * Get the prev tag
     *
     * @return Tag|null
     */
    public function getPrevHref(): ?Tag;

    /**
     * Get the prev tag
     *
     * @return Tag|null
     */
    public function getNextHref(): ?Tag;

    /**
     * The rel="next" and rel="prev" link attributes are used to indicate the relations between a sequence of pages
     * to search engines.
     *
     * @param string $url
     * @return $this
     */
    public function setNextHref(string $url);

    /**
     * @param GeoMetaInformationInterface $geo
     * @return $this
     */
    public function setGeo(GeoMetaInformationInterface $geo);

    /**
     * Create a custom meta tag
     *
     * @param string $name
     * @param array $attributes
     * @param bool $checkNameAttribute
     * @return $this
     */
    public function addMeta(string $name, array $attributes, bool $checkNameAttribute = true);

    /**
     * Get the meta tag by name
     *
     * @param string $name
     * @return Tag|null
     */
    public function getMeta(string $name): ?Tag;
}