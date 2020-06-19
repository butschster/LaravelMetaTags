<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\ConditionalComment;
use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Tests\TestCase;

class ConditionalCommentsTest extends TestCase
{
    function test_a_comment_can_be_added_for_tag()
    {
        $tag = new Favicon('http://site.com/favicon.ico');

        $comment = new ConditionalComment($tag, 'IE 6');

        $this->assertHtmlableEquals(<<<COM
<!--[if IE 6]>
<link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico">
<![endif]-->
COM
, $comment);

        $this->assertEquals($tag->getPlacement(), $comment->getPlacement());
    }
}