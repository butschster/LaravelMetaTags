<?php

namespace Butschster\Head\MetaTags\Concerns;

trait InitializeDefaults
{
    /**
     * @return $this
     */
    public function initialize()
    {
        if (!empty($charset = $this->config('charset'))) {
            $this->setCharset($charset);
        }

        if (!empty($viewport = $this->config('viewport'))) {
            $this->setViewport($viewport);
        }
        
        if (!empty($title = $this->config('title.default'))) {
            $this->setTitle($title);
        }

        if (!empty($description = $this->config('description.default'))) {
            $this->setDescription($description);
        }

        if (!empty($keywords = $this->config('keywords.default'))) {
            $this->setKeywords($keywords);
        }

        if (!empty($robots = $this->config('robots'))) {
            $this->setRobots($robots);
        }

        if ($showCSRFToken = $this->config('csrf_token')) {
            $this->addCsrfToken();
        }

        if (!empty($packages = $this->config('packages'))) {
            $this->includePackages($packages);
        }

        return $this;
    }
}
