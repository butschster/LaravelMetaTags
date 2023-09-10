<?php

declare(strict_types=1);

namespace Butschster\Head\Hydrator;

use Illuminate\Contracts\Support\Arrayable;

class VueMetaResource implements Arrayable, \JsonSerializable
{
    private ?string $title = null;
    
    private array $meta = [];
    
    private array $link = [];
    
    private array $script = [];

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function appendLink(array $link): void
    {
        $this->link[] = $link;
    }

    public function appendScript(array $script): void
    {
        $this->script[] = $script;
    }

    public function appendMeta(array $meta): void
    {
        $this->meta[] = $meta;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'meta' => $this->meta,
            'link' => $this->link,
            'script' => $this->script,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
