<?php

namespace Butschster\Tests\Packages;

use Butschster\Head\Packages\Package;
use Butschster\Tests\TestCase;

class PackageTest extends TestCase
{
    function test_a_package_can_be_created()
    {
        $package = new Package('jquery');
        $this->assertEquals('jquery', $package->getName());
    }

    function test_a_css_link_can_be_set()
    {
        $package = new Package('core');

        $package->addStyle('style.css', 'http://site.com/style.css');

        $this->assertHtmlableEquals(
            '<link media="all" type="text/css" rel="stylesheet" href="http://site.com/style.css">',
            $package->getTag('style.css')
        );

        $package->addStyle('style.css', 'http://site.com/style.css', [
            'media' => 'custom'
        ]);

        $this->assertHtmlableEquals(
            '<link media="custom" type="text/css" rel="stylesheet" href="http://site.com/style.css">',
            $package->getTag('style.css')
        );
    }

    function test_a_script_can_be_set()
    {
        $package = new Package('core');

        $package->addScript('script.js', 'http://site.com/script.js', ['async', 'defer']);

        $this->assertHtmlableEquals(
            '<script src="http://site.com/script.js" async defer></script>',
            $package->footer()->get('script.js')
        );
    }

    function test_in_can_have_dependencies()
    {
        $package = new Package('name');

        $this->assertFalse($package->hasDependencies());

        $package->requires('jquery');
        $this->assertEquals(['jquery'], $package->getDependencies());

        $package->requires(['jquery', 'vue']);
        $this->assertEquals(['jquery', 'vue'], $package->getDependencies());

        $this->assertTrue($package->hasDependencies());
    }
}