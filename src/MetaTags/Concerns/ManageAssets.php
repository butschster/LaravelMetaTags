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
}