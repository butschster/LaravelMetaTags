<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\Entities\Script;
use Butschster\Tests\TestCase;

class ScriptTest extends TestCase
{
    function test_it_can_be_created()
    {
        $this->assertHtmlableEquals(
            '<script src="http://site.com"></script>',
            new Script('script_name', 'http://site.com')
        );
    }

    function test_it_can_has_attributes()
    {
        $this->assertHtmlableEquals(
            '<script src="http://site.com" defer async></script>',
            new Script('script_name', 'http://site.com', [
                'defer', 'async'
            ])
        );
    }

    function test_it_has_footer_default_placement()
    {
        $script = new Script('script_name', 'http://site.com');

        $this->assertEquals(Meta::PLACEMENT_FOOTER, $script->getPlacement());
    }

    function test_a_placement_can_be_set_through_constructor()
    {
        $script = new Script('script_name', 'http://site.com', [], 'test');

        $this->assertEquals('test', $script->getPlacement());
    }


}
