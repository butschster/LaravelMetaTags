<?php
declare(strict_types=1);

namespace Butschster\Head\Hydrator;

use Illuminate\Contracts\Support\Arrayable;

class VueMetaResource implements Arrayable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var array
     */
    private $meta = [];

    /**
     * @var array
     */
    private $link = [];

    /**
     * @var array
     */
    private $script = [];

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function appendLink(array $link)
    {
        $this->link[] = $link;
    }

    public function appendScript(array $script)
    {
        $this->script[] = $script;
    }

    public function appendMeta(array $meta)
    {
        $this->meta[] = $meta;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'meta' => $this->meta,
            'link' => $this->link,
            'script' => $this->script
        ];
    }
}
