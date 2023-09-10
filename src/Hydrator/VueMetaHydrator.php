<?php

declare(strict_types=1);

namespace Butschster\Head\Hydrator;

use Butschster\Head\Contracts\Hydrator;
use Butschster\Head\Contracts\MetaTags\MetaInterface;

class VueMetaHydrator implements Hydrator
{
    private VueMetaResource $resource;

    public function __construct(
        private string $idKey = 'hid',
    ) {
        $this->resource = new VueMetaResource();
    }

    /**
     * @throws \JsonException
     */
    public function hydrate(MetaInterface $meta): array
    {
        $array = $meta->head()->toArray();

        foreach ($array as $item) {
            $this->format($item);
        }

        return $this->resource->toArray();
    }

    /**
     * @throws \JsonException
     */
    private function format(array $item): void
    {
        if (!isset($item['tag'])) {
            return;
        }

        $tag = $item['tag'];
        unset($item['tag'], $item['type']);

        switch ($tag) {
            case 'title':
                $this->formatTitle($item);
                break;
            case 'meta':
                $this->formatMeta($item);
                break;
            case 'link':
                $this->formatLink($item);
                break;
            case 'script':
                $this->formatScript($item);
                break;
        }
    }

    private function formatTitle(array $item): void
    {
        $this->resource->setTitle($item['content']);
    }

    /**
     * @throws \JsonException
     */
    private function formatMeta(array $item): void
    {
        $item[$this->idKey] = $item['name'] ?? md5(json_encode($item, JSON_THROW_ON_ERROR));
        $this->resource->appendMeta($item);
    }

    private function formatLink(array $item): void
    {
        $this->resource->appendLink($item);
    }

    private function formatScript(array $item): void
    {
        $this->resource->appendScript($item);
    }
}
