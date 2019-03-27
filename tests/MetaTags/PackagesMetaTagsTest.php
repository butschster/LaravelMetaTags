<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Packages\Manager;
use Butschster\Head\Packages\Package;
use Butschster\Tests\TestCase;

class PackagesMetaTagsTest extends TestCase
{
    function test_packages_can_be_loaded()
    {
        $manager = new Manager();
        $meta = new Meta($manager);

        $manager->register('jquery', function (Package $package) {
            $package->addScript('jquery', 'http://cdn.jquery.com/jquery.latest.js', ['defer']);
            $package->addStyle('jquery.css', 'http://cdn.jquery.com/jquery.latest.css');
        });

        $manager->register('vuejs', function (Package $package) {
            $package->addScript('vuejs', 'http://cdn.vuejs.com/vuejs.latest.js');
        });

        $meta->includePackages(['jquery']);

        $this->assertStringContainsString(
            '<script src="http://cdn.jquery.com/jquery.latest.js" defer></script>',
            $meta->footer()->toHtml()
        );

        $this->assertStringContainsString(
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css" />',
            $meta->toHtml()
        );

        $this->assertStringNotContainsString(
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css" />',
            $meta->footer()->toHtml()
        );

        $this->assertStringNotContainsString(
            '<script src="http://cdn.jquery.com/jquery.latest.js" defer></script>',
            $meta->toHtml()
        );

        $this->assertStringNotContainsString(
            '<script src="http://cdn.vuejs.com/vuejs.latest.js"></script>',
            $meta->toHtml()
        );

        $this->assertStringNotContainsString(
            '<script src="http://cdn.vuejs.com/vuejs.latest.js"></script>',
            $meta->footer()->toHtml()
        );
    }

    function test_a_package_can_be_registered()
    {
        $meta = $this->makeMetaTags();

        $package = new Package('jquery');
        $package->addScript('jquery', 'http://cdn.jquery.com/jquery.latest.js', ['defer'], [], 'head');
        $package->addStyle('jquery.css', 'http://cdn.jquery.com/jquery.latest.css');

        $meta->registerPackage($package);

        $this->assertStringContainsString(
            '<script src="http://cdn.jquery.com/jquery.latest.js" defer></script>',
            $meta->toHtml()
        );

        $this->assertStringContainsString(
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css" />',
            $meta->toHtml()
        );
    }
}