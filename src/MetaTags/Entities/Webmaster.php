<?php

namespace Butschster\Head\MetaTags\Entities;

class Webmaster extends Tag
{
    const GOOGLE = 'google';
    const YANDEX = 'yandex';
    const PINTEREST = 'pinterest';
    const ALEXA = 'alexa';
    const BING = 'bing';
    const FACEBOOK = 'facebook';

    /**
     * The supported webmasters.
     *
     * @var array
     */
    protected $services = [
        Webmaster::YANDEX => 'yandex-verification',
        Webmaster::GOOGLE => 'google-site-verification',
        Webmaster::PINTEREST => 'p:domain_verify',
        Webmaster::ALEXA => 'alexaVerifyID',
        Webmaster::BING => 'msvalidate.01',
        Webmaster::FACEBOOK => 'facebook-domain-verification',
    ];

    /**
     * @param string $service
     * @param string $content
     */
    public function __construct(string $service, string $content)
    {
        parent::__construct('meta', [
            'name' => $this->getServiceName($service),
            'content' => $content
        ]);
    }

    /**
     * @param string $service
     *
     * @return string
     */
    protected function getServiceName(string $service): string
    {
        if (!isset($this->services[$service])) {
            throw new \InvalidArgumentException('Webmaster service is not supported.');
        }

        return $this->services[$service];
    }
}
