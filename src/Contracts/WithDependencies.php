<?php

namespace Butschster\Head\Contracts;

interface WithDependencies
{
    public function getDependencies(): array;

    public function hasDependencies(): bool;
}
