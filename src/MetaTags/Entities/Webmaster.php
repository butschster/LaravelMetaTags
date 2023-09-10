<?php

namespace Butschster\Head\MetaTags\Entities;

class Webmaster extends Tag
{
    public const GOOGLE = 'google';
    
    public const YANDEX = 'yandex';
    
    public const PINTEREST = 'pinterest';
    
    public const ALEXA = 'alexa';
    
    public const BING = 'bing';
    
    public const FACEBOOK = 'facebook';

    /**
     * The supported webmasters.
     */
    protected array $services = [
        Webmaster::YANDEX => 'yandex-verification',
        Webmaster::GOOGLE => 'google-site-verification',
        Webmaster::PINTEREST => 'p:domain_verify',
        Webmaster::ALEXA => 'alexaVerifyID',
        Webmaster::BING => 'msvalidate.01',
        Webmaster::FACEBOOK => 'facebook-domain-verification',
    ];

    public function __construct(string $service, string $content)
    {
        parent::__construct('meta', [
            'name' => $this->getServiceName($service),
            'content' => $content
        ]);
    }

    protected function getServiceName(string $service): string
    {
        if (!isset($this->services[$service])) {
            throw new \InvalidArgumentException('Webmaster service is not supported.');
        }

        return $this->services[$service];
    }
}
