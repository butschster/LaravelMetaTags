<?php
declare(strict_types=1);

namespace Butschster\Head\Contracts;

use Butschster\Head\Contracts\MetaTags\MetaInterface;

interface Hydrator
{
    public function hydrate(MetaInterface $meta): array;
}
