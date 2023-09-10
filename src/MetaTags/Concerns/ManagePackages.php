<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\PlacementsInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\Contracts\WithDependencies;

trait ManagePackages
{
    private array $packages = [];
    
    private array $registeredPackages = [];

    public function registerPackage(PackageInterface $package): self
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

    public function replacePackage(PackageInterface $package): self
    {
        $this->removePackage($package->getName());

        return $this->registerPackage($package);
    }

    public function removePackage(string $name): self
    {
        $package = $this->getPackage($name);

        if (($index = array_search($name, $this->registeredPackages, true)) !== false) {
            unset($this->registeredPackages[$index]);
        }

        if (!$package) {
            return $this;
        }

        if ($package instanceof PlacementsInterface) {
            foreach ($package->getPlacements() as $tags) {
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

    public function getPackage(string $name): ?PackageInterface
    {
        return $this->packageManager->getPackage($name);
    }

    public function includePackages($packages): self
    {
        $packages = is_array($packages) ? $packages : func_get_args();

        foreach ($packages as $package) {
            if ($package = $this->packageManager->getPackage($package)) {
                $this->registerPackage($package);
            }
        }

        return $this;
    }

    protected function isRegisteredPackage(string $name): bool
    {
        return in_array($name, $this->registeredPackages);
    }
}
