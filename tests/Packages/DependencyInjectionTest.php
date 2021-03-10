<?php

namespace Butschster\Tests\Packages;

use Butschster\Head\MetaTags\Entities\Script;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Head\Packages\Manager;
use Butschster\Head\Packages\Package;
use Butschster\Tests\TestCase;

class DependencyInjectionTest extends TestCase
{
    function test_dependency_should_be_included()
    {
        $jqueryPkg = new Package('jquery');
        $jqueryPkg->setRobots('noindex, nofollow');
        $jqueryPkg->addScript('jquery.js', 'http://site.com/jquery.min.js');

        $bootstrapPkg = new Package('bootstrap4');
        $bootstrapPkg->requires('jquery');
        $bootstrapPkg->addScript('bootstrap4.js', 'http://site.com/bootstrap4.min.js');
        $bootstrapPkg->addStyle('bootstrap4.css', 'http://site.com/bootstrap4.min.css');

        $manager = new Manager();
        $manager->register($jqueryPkg);
        $manager->register($bootstrapPkg);

        $meta = $this->makeMetaTags($manager);
        $meta->includePackages('bootstrap4');

        $this->assertHtmlableContains([
            '<script src="http://site.com/jquery.min.js"></script>',
            '<script src="http://site.com/bootstrap4.min.js"></script>',
        ], $meta->footer());

        $this->assertHtmlableContains([
            '<link media="all" type="text/css" rel="stylesheet" href="http://site.com/bootstrap4.min.css">',
            '<meta name="robots" content="noindex, nofollow">',
        ], $meta);
    }


    function test_registered_dependencies_should_not_register_twice()
    {
        $package = \Mockery::mock(Package::class);
        $package->shouldReceive('getName')->times(4)->andReturn('jquery');
        $package->shouldReceive('getDependencies')->once()->andReturn(['jquery']);
        $package->shouldReceive('getPlacements')->once()->andReturn([]);
        $package->shouldReceive('getTags')->once()->andReturn(new TagsCollection([
            new Script('jquery.js', 'http://site.com/jquery.min.js')
        ]));

        $manager = new Manager();
        $manager->register($package);

        $meta = $this->makeMetaTags($manager);
        $meta->includePackages('jquery');

        $this->assertHtmlableEquals([
            ''
        ], $meta);

        $this->assertHtmlableEquals([
            '<script src="http://site.com/jquery.min.js"></script>'
        ], $meta->footer());
    }
}
