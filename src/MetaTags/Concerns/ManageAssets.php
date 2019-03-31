<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\MetaTags\Entities\Script;
use Butschster\Head\MetaTags\Entities\Style;
use Butschster\Head\MetaTags\Meta;

trait ManageAssets
{
    /**
     * @inheritdoc
     */
    public function addStyle(string $name, string $src, array $attributes = [])
    {
        $this->addTag(
            $name,
            new Style($name, $src, $attributes)
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addScript(string $name, string $src, array $attributes = [], string $placement = Meta::PLACEMENT_FOOTER)
    {
        $this->addTag(
            $name,
            new Script($name, $src, $attributes, $placement)
        );

        return $this;
    }
}