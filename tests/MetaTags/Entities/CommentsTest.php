<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Comment;
use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Tests\TestCase;

class CommentsTest extends TestCase
{
    function test_comment_can_wrap_a_tag_object()
    {
        $favicon = new Favicon('http://site.com/favicon.ico');
        $favicon->setPlacement('footer');

        $comment = new Comment($favicon, 'Favicon');

        $this->assertHtmlableEquals(<<<COM
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico">
<!-- /Favicon -->
COM
,
            $comment
        );

        $this->assertEquals($favicon->getPlacement(), $comment->getPlacement());
    }

    function test_close_comments_can_be_set()
    {
        $favicon = new Favicon('http://site.com/favicon.ico');
        $comment = new Comment($favicon, 'Favicon', 'Close comment');

        $this->assertHtmlableEquals(<<<COM
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico">
<!-- /Close comment -->
COM
            ,
            $comment
        );
    }

    function test_by_default_comment_is_visible()
    {
        $favicon = new Favicon('http://site.com/favicon.ico');
        $comment = new Comment($favicon, 'Favicon', 'Close comment');

        $this->assertTrue($comment->isVisible());
    }

    function test_visibility_condition_can_be_set()
    {
        $favicon = new Favicon('http://site.com/favicon.ico');
        $comment = new Comment($favicon, 'Favicon', 'Close comment');

        // Make it invisible
        $this->assertFalse($comment->visibleWhen(function () {return false;})->isVisible());

        // Make it visible
        $this->assertTrue($comment->visibleWhen(function () {return true;})->isVisible());
    }
}
