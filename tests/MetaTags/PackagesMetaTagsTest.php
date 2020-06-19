<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Entities\Script;
use Butschster\Head\MetaTags\Entities\Style;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Head\Packages\Manager;
use Butschster\Head\Packages\Package;
use Butschster\Tests\TestCase;

class PackagesMetaTagsTest extends TestCase
{
    function test_packages_can_be_loaded()
    {
        $meta = $this->makeMetaTags(
            $manager = new Manager()
        );

        $manager->create('jquery', function (Package $package) {
            $package->addScript('jquery', 'http://cdn.jquery.com/jquery.latest.js', ['defer']);
            $package->addStyle('jquery.css', 'http://cdn.jquery.com/jquery.latest.css');
        });

        $manager->create('vuejs', function (Package $package) {
            $package->addScript('vuejs', 'http://cdn.vuejs.com/vuejs.latest.js');
        });

        $meta->includePackages(['jquery']);

        $this->assertHtmlableContains(
            '<script src="http://cdn.jquery.com/jquery.latest.js" defer></script>',
            $meta->footer()
        );

        $this->assertHtmlableContains(
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css">',
            $meta
        );

        $this->assertHtmlableNotContains([
            '<script src="http://cdn.vuejs.com/vuejs.latest.js"></script>',
            '<script src="http://cdn.jquery.com/jquery.latest.js" defer></script>',
        ], $meta);

        $this->assertHtmlableNotContains([
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css">',
            '<script src="http://cdn.vuejs.com/vuejs.latest.js"></script>',
        ], $meta->footer());
    }

    function test_a_package_can_be_registered()
    {
        $meta = $this->makeMetaTags();

        $package = new Package('jquery');
        $package->addScript('jquery', 'http://cdn.jquery.com/jquery.latest.js', ['defer'], 'head');
        $package->addScript('jquery.footer', 'http://cdn.jquery.com/jquery.footer.latest.js');
        $package->addStyle('jquery.css', 'http://cdn.jquery.com/jquery.latest.css');

        $meta->registerPackage($package);

        $this->assertHtmlableContains([
            '<script src="http://cdn.jquery.com/jquery.latest.js" defer></script>',
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css">',
        ], $meta);

        $this->assertHtmlableNotContains(
            '<script src="http://cdn.jquery.com/jquery.footer.latest.js"></script>',
            $meta
        );

        $this->assertHtmlableContains(
            '<script src="http://cdn.jquery.com/jquery.footer.latest.js"></script>',
            $meta->placement('footer')
        );
    }

    function test_a_package_without_placements_can_be_registered()
    {
        $meta = $this->makeMetaTags();
        $package = new TestPackage([
            new Script('jquery', 'http://cdn.jquery.com/jquery.latest.js', [], 'head'),
            new Script('jquery.footer', 'http://cdn.jquery.com/jquery.footer.latest.js'),
            new Style('jquery.css', 'http://cdn.jquery.com/jquery.latest.css')
        ]);

        $meta->registerPackage($package);

        $this->assertHtmlableContains([
            '<script src="http://cdn.jquery.com/jquery.latest.js"></script>',
            '<link media="all" type="text/css" rel="stylesheet" href="http://cdn.jquery.com/jquery.latest.css">',
        ], $meta);

        $this->assertHtmlableNotContains(
            '<script src="http://cdn.jquery.com/jquery.footer.latest.js"></script>',
            $meta
        );

        $this->assertHtmlableContains(
            '<script src="http://cdn.jquery.com/jquery.footer.latest.js"></script>',
            $meta->placement('footer')
        );
    }
}

class TestPackage extends TagsCollection implements PackageInterface
{
    public function getName(): string { return 'test'; }
    public function getTags(): TagsCollection { return $this; }
    public function toHtml(){}
}