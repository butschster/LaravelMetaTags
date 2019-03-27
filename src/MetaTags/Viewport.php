<?php

namespace Butschster\Head\MetaTags;

class Viewport
{
    /**
     * This means that the browser will (probably) render the width of the page at the width of its own screen. So if
     * that screen is 320px wide, the browser window will be 320px wide, rather than way zoomed out and showing 960px
     * (or whatever that device does by default, in lieu of a responsive meta tag).
     */
    const RESPONSIVE = 'width=device-width, initial-scale=1';
}