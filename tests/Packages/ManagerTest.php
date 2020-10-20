<?php

namespace Butschster\Tests\Packages;

use Butschster\Head\Packages\Manager;
use Butschster\Head\Packages\Package;
use Butschster\Tests\TestCase;

class ManagerTest extends TestCase
{
    function test_a_package_can_be_registered()
    {
        $manager = new Manager();
        $package = new Package('jquery');
        $manager->register($package);

        $this->assertEquals($package, $manager->getPackage('jquery'));
    }

    function test_it_can_register_packages()
    {
        $manager = new Manager();

        $manager->create('jquery', function (Package $package) {
            $package->addScript('jquery', 'http://cdn.jquery.com/jquery.latest.js');
        });

        $manager->create('vuejs', function (Package $package) {
            $package->addScript('vuejs', 'http://cdn.vuejs.com/vuejs.latest.js');
        });

        $this->assertCount(2, $manager->getPackages());
        $this->assertEquals(['jquery', 'vuejs'], array_keys($manager->getPackages()));
    }

    function test_gets_the_package()
    {
        $manager = new Manager();

        $manager->create('jquery', function (Package $package) {
            $package->addScript('jquery', 'http://cdn.jquery.com/jquery.latespt.js');
        });

        $this->assertInstanceOf(Package::class, $manager->getPackage('jquery'));
        $this->assertEquals('jquery', $manager->getPackage('jquery')->getName());

        $this->assertNull($manager->getPackage('vuejs'));
    }
}
