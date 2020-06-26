<?php

namespace Butschster\Head\MetaTags\Concerns;

trait InitializeDefaults
{
    /**
     * @return $this
     */
    public function initialize()
    {
        if (!empty($title = $this->config('title.default'))) {
            $this->setTitle($title);
        }

        if (!empty($title = $this->config('title.max_length'))) {
            $this->getTitle()->setMaxLength($this->config('title.max_length'));
        }

        if (!empty($title = $this->config('title.separator'))) {
            $this->setTitleSeparator($title);
        }

        if (!empty($description = $this->config('description.default'))) {
            $this->setDescription($description);
        }

        if (!empty($title = $this->config('description.max_length'))) {
            $this->getDescription()->setMaxLength($this->config('description.max_length'));
        }

        if (!empty($keywords = $this->config('keywords.default'))) {
            $this->setKeywords($keywords);
        }

        if (!empty($title = $this->config('keywords.max_length'))) {
            $this->getKeywords()->setMaxLength($this->config('keywords.max_length'));
        }

        if (!empty($charset = $this->config('charset'))) {
            $this->setCharset($charset);
        }

        if (!empty($robots = $this->config('robots'))) {
            $this->setRobots($robots);
        }

        if (!empty($viewport = $this->config('viewport'))) {
            $this->setViewport($viewport);
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
