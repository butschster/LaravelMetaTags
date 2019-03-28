<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\PlacementsInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\TagsCollection;

trait ManagePackages
{
    /**
     * @var array
     */
    private $packages = [];

    /**
     * @inheritdoc
     */
    public function registerPackage(PackageInterface $package)
    {
        if ($package instanceof PlacementsInterface) {
            foreach ($package->getPlacements() as $placement => $tags) {
                $this->registerTags($tags, $placement);
            }
        }

        if ($package instanceof TagsCollection) {
            $this->registerTags($package);
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