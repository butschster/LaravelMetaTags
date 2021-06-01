<?php
declare(strict_types=1);

namespace Butschster\Head\Hydrator;

use Butschster\Head\Contracts\Hydrator;
use Butschster\Head\Contracts\MetaTags\MetaInterface;

class VueMetaHydrator implements Hydrator
{
    /**
     * @var VueMetaResource
     */
    private $resource;

    /**
     * @var string
     */
    private $idKey;

    public function __construct(string $idKey = 'hid')
    {
        $this->idKey = $idKey;
        $this->resource = new VueMetaResource();
    }

    public function hydrate(MetaInterface $meta): array
    {
        $array = $meta->head()->toArray();

        foreach ($array as $item) {
            $this->format($item);
        }

        return $this->resource->toArray();
    }

    private function format(array $item)
    {
        if (!isset($item['tag'])) {
            return;
        }

        $tag = $item['tag'];
        unset($item['tag'], $item['type']);

        switch ($tag) {
            case 'title':
                return $this->formatTitle($item);
            case 'meta':
                return $this->formatMeta($item);
            case 'link':
                return $this->formatLink($item);
            case 'script':
                return $this->formatScript($item);
        }
    }

    private function formatTitle(array $item)
    {
        $this->resource->setTitle($item['content']);
    }

    private function formatMeta(array $item)
    {
        $item[$this->idKey] = $item['name'] ?? md5(json_encode($item));
        $this->resource->appendMeta($item);
    }

    private function formatLink(array $item)
    {
        $this->resource->appendLink($item);
    }

    private function formatScript(array $item)
    {
        $this->resource->appendScript($item);
    }
}
