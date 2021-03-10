<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\PlacementsInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\Contracts\WithDependencies;

trait ManagePackages
{
    /**
     * @var array
     */
    private $packages = [];

    /**
     * @var array
     */
    private $registeredPackages = [];

    /**
     * @inheritdoc
     */
    public function registerPackage(PackageInterface $package)
    {
        $name = $package->getName();

        if ($this->isRegisteredPackage($name)) {
            return $this;
        }

        $this->registeredPackages[] = $name;
        $this->packageManager->register($package);

        if ($package instanceof WithDependencies) {
            $this->includePackages(
                $package->getDependencies()
            );
        }

        if ($package instanceof PlacementsInterface) {
            foreach ($package->getPlacements() as $placement => $tags) {
                $this->registerTags($tags, $placement);
            }
        }

        $this->registerTags(
            $package->getTags()
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function replacePackage(PackageInterface $package)
    {
        $this->removePackage($package->getName());

        return $this->registerPackage($package);
    }

    /**
     * @inheritdoc
     */
    public function removePackage(string $name)
    {
        $package = $this->getPackage($name);

        if (($index = array_search($name, $this->registeredPackages)) !== false) {
            unset($this->registeredPackages[$index]);
        }

        if (!$package) {
            return $this;
        }

        if ($package instanceof PlacementsInterface) {
            foreach ($package->getPlacements() as $placement => $tags) {
                foreach ($tags as $name => $tag) {
                    $this->removeTag($name);
                }
            }
        }

        foreach ($package->getTags() as $name => $tag) {
            $this->removeTag($name);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPackage(string $name): ?PackageInterface
    {
        return $this->packageManager->getPackage($name);
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

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function isRegisteredPackage(string $name): bool
    {
        return in_array($name, $this->registeredPackages);
    }
}
