<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\GeoMetaInformationInterface;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Head\MetaTags\Entities\Script;
use Butschster\Head\MetaTags\Entities\Style;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\Entities\Title;
use Butschster\Head\Packages\Manager;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Traits\Macroable;

class Meta implements MetaInterface
{
    use Macroable;

    const PLACEMENT_HEAD   = 'head';
    const PLACEMENT_FOOTER = 'footer';

    /**
     * @var PlacementsBag
     */
    protected $placements;

    /**
     * @var array
     */
    private $packages = [];

    /**
     * @var Manager
     */
    private $packageManager;

    /**
     * @param Manager $packageManager
     */
    public function __construct(Manager $packageManager)
    {
        $this->placements = new PlacementsBag();
        $this->packageManager = $packageManager;
    }

    /**
     * @inheritdoc
     */
    public function setTitle(string $title)
    {
        $this->getTitle()->setTitle($this->cleanString($title));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTitleSeparator(string $separator)
    {
        $this->getTitle()->setSeparator($separator);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prependTitle(string $text)
    {
        $title = $this->getTitle();

        if ($title) {
            $title->prepend($this->cleanString($text));
        } else {
            $this->setTitle($text);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): ?Title
    {
        $title = $this->getMeta('title');

        if (!$title) {
            $this->addTag('title', $title = new Title());
        }

        return $title;
    }

    /**
     * @inheritdoc
     */
    public function setDescription(string $description)
    {
        return $this->addMeta('description', [
            'content' => $this->cleanString($description),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): ?TagInterface
    {
        return $this->getMeta('description');
    }

    /**
     * @inheritdoc
     */
    public function setKeywords($keywords)
    {
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }

        $keywords = array_map(function ($keyword) {
            return $this->cleanString($keyword);
        }, $keywords);

        return $this->addMeta('keywords', [
            'content' => implode(', ', $keywords),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getKeywords(): ?TagInterface
    {
        return $this->getMeta('keywords');
    }

    /**
     * @inheritdoc
     */
    public function setRobots(string $behavior)
    {
        return $this->addMeta('robots', [
            'content' => $this->cleanString($behavior),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getRobots(): ?TagInterface
    {
        return $this->getMeta('robots');
    }

    /**
     * @inheritdoc
     */
    public function setContentType(string $type, string $charset = 'utf-8')
    {
        return $this->addMeta('content_type', [
            'http-equiv' => 'Content-Type',
            'content' => $this->cleanString($type . '; charset=' . $charset),
        ], false);
    }

    /**
     * @inheritdoc
     */
    public function getContentType(): ?TagInterface
    {
        return $this->getMeta('content_type');
    }

    /**
     * @inheritdoc
     */
    public function setViewport(string $viewport)
    {
        return $this->addMeta('viewport', [
            'content' => $this->cleanString($viewport),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getViewport(): ?TagInterface
    {
        return $this->getMeta('viewport');
    }

    /**
     * @inheritdoc
     */
    public function setPrevHref(string $url)
    {
        return $this->addLink('prev_href', [
            'rel' => 'prev',
            'href' => $this->cleanString($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getPrevHref(): ?TagInterface
    {
        return $this->getMeta('prev_href');
    }

    /**
     * @inheritdoc
     */
    public function getNextHref(): ?TagInterface
    {
        return $this->getMeta('next_href');
    }

    /**
     * @inheritdoc
     */
    public function setNextHref(string $url)
    {
        return $this->addLink('next_href', [
            'rel' => 'next',
            'href' => $this->cleanString($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function setCanonical(string $url)
    {
        return $this->addLink('canonical', [
            'href' => $this->cleanString($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getCanonical(): ?TagInterface
    {
        return $this->getMeta('canonical');
    }

    /**
     * Set canonical link, prev and next from paginator object
     *
     * @param Paginator $paginator
     *
     * @return $this
     */
    public function setPaginationLinks(Paginator $paginator)
    {
        $this->setCanonical($paginator->url($paginator->currentPage()));

        $this->setNextHref($paginator->nextPageUrl());
        $this->setPrevHref($paginator->previousPageUrl());

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setGeo(GeoMetaInformationInterface $geo)
    {
        $this->addMeta('geo.position', [
            'content' => $this->cleanString($geo->latitude() . '; ' . $geo->longitude()),
        ]);

        if ($placename = $geo->placename()) {
            $this->addMeta('geo.placename', [
                'content' => $placename,
            ]);
        }

        if ($pregion = $geo->region()) {
            $this->addMeta('geo.region', [
                'content' => $pregion,
            ]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHrefLang(string $lang, string $url)
    {
        return $this->addLink('alternate_' . $lang, [
            'rel' => 'alternate',
            'hreflang' => $this->cleanString($lang),
            'href' => $this->cleanString($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getHrefLang(string $lang): ?TagInterface
    {
        return $this->getMeta('alternate_' . $lang);
    }

    /**
     * @inheritdoc
     */
    public function setCharset(string $charset = 'utf-8')
    {
        return $this->addMeta('charset', [
            'charset' => $charset,
        ], false);
    }

    /**
     * @inheritdoc
     */
    public function getCharset(): ?TagInterface
    {
        return $this->getMeta('charset');
    }

    /**
     * @inheritdoc
     */
    public function setFavicon(string $href, array $attributes = [])
    {
        return $this->addTag('favicon', new Favicon($href, $attributes));
    }

    /**
     * @inheritdoc
     */
    public function addLink(string $name, array $attributes)
    {
        if (!isset($attributes['rel'])) {
            $attributes = array_merge(['rel' => $name], $attributes);
        }

        return $this->addTag($name, new Tag('link', $attributes, true));
    }

    /**
     * Add a custom tag
     *
     * @param string $name
     * @param TagInterface $tag
     *
     * @return $this
     */
    public function addTag(string $name, TagInterface $tag)
    {
        $this->placements->getBag($tag->placement())->put($name, $tag);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addMeta(string $name, array $attributes, bool $checkNameAttribute = true)
    {
        if ($checkNameAttribute && !isset($attributes['name'])) {
            $attributes = array_merge(['name' => $name], $attributes);
        }

        return $this->addTag($name, new Tag('meta', $attributes));
    }

    /**
     * @inheritdoc
     */
    public function getMeta(string $name): ?TagInterface
    {
        return $this->head()->get($name);
    }

    /**
     * @inheritdoc
     */
    public function removeMeta(string $name): void
    {
        $this->head()->forget($name);
    }

    /**
     * @inheritdoc
     */
    public function addStyle(string $name, string $src, array $attributes = [], array $dependency = [])
    {
        $this->addTag(
            $name,
            new Style($name, $src, $attributes, $dependency)
        );

        return $this;
    }

    /**
     * Set a link to script file
     *
     * @param string $name
     * @param string $src
     * @param array $attributes
     * @param array $dependency Required packages
     * @param string $placement
     *
     * @return $this
     */
    public function addScript(string $name, string $src, array $attributes = [], array $dependency = [], string $placement = Meta::PLACEMENT_FOOTER)
    {
        $this->addTag(
            $name,
            new Script($name, $src, $attributes, $dependency, $placement)
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addCsrfToken()
    {
        return $this->addMeta('csrf-token', [
            'content' => Session::token(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function reset(): void
    {
        $this->head()->reset();
    }

    /**
     * Remove HTML tags
     *
     * @param string $string
     *
     * @return string
     */
    protected function cleanString(string $string): string
    {
        return e(strip_tags($string));
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {
        return $this->head()->toHtml();
    }

    /**
     * @inheritdoc
     */
    public function head(): PlacementInterface
    {
        return $this->placement(static::PLACEMENT_HEAD);
    }

    /**
     * @inheritdoc
     */
    public function footer(): PlacementInterface
    {
        return $this->placement(static::PLACEMENT_FOOTER);
    }

    /**
     * @inheritdoc
     */
    public function placement(string $name): PlacementInterface
    {
        return $this->placements->getBag($name);
    }

    /**
     * @inheritdoc
     */
    public function getPlacements(): array
    {
        return $this->placements->all();
    }

    /**
     * @inheritdoc
     */
    public function registerPackage(PackageInterface $package)
    {
        foreach ($package->getPlacements() as $key => $placement) {
            foreach ($placement as $name => $tag) {
                $this->placement($key)->put(
                    $package->getName() . '.' . $name, $tag
                );
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function includePackages($packages)
    {
        $packages = is_array($packages) ? $packages : func_get_args();

        foreach ($packages as $package) {
            if ($package = $this->packageManager->getPackage($package)) {
                $this->registerPackage($package);
            }
        }

        return $this;
    }
}