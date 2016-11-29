<?php
/**
 * Created by iKNSA.
 * Author: Khalid Sookia <khalidsookia@gmail.com>
 * Date: 26/11/16
 * Time: 22:42
 */

namespace IKNSA\HelperBundle\Util;


class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $urlSections;

    /**
     * Url constructor.
     *
     * @param $url string
     */
    public function __construct($url)
    {
        $this->url = $url;

        $this->setScheme();
        $this->domainNameWithSubDomain();
        $this->setDomainSubDomainAndExtenstion();
    }

    /**
     * Get Url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get Scheme form given Url
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->urlSections['scheme'];
    }

    /**
     * Get sub-domain from given Url
     *
     * @return string
     */
    public function getSubDomain()
    {
        return $this->urlSections['subDomain'];
    }

    /**
     * Get Domain name from given Url
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->urlSections['domain'];
    }

    /**
     * Get Extension from given Url
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->urlSections['extension'];
    }

    /**
     * Get DNS constituted by Domain name (second level domain name) and Extension (first level domain name)
     * Important: Sub-domains are absent here. Only use this method if you dont need the sub-domain.
     * Else use the getFullyQualifiedDns() method
     *
     * @return string
     */
    public function getDns()
    {
        return $this->getDomain() . '.' . $this->getExtension();
    }

    /**
     * Get Fully qualified domain
     * Built with sub-domain (if present), domain name (second level domain name) and extension (first level domain name)
     *
     * @return string
     */
    public function getFullyQualifiedDns()
    {
        return $this->getSubDomain() . '.' . $this->getDomain() . '.' . $this->getExtension();
    }

    /**
     * Set Scheme
     *
     * @return Url
     */
    private function setScheme()
    {
        if (preg_match('/:\/\//', $this->getUrl())) {
            $explodedUrl = explode('://', $this->getUrl());

            $this->addSection('scheme', $explodedUrl[0]);
            $this->addSection('urlWithoutScheme', $explodedUrl[1]);
        }

        return $this;
    }

    /**
     * Seperates domain name and sub-domain name from the rest of the url
     *
     * @return Url
     */
    private function domainNameWithSubDomain()
    {
        if (strstr($this->urlSections['urlWithoutScheme'], '/')) {
            $domainNameWithSubDomain = explode('/', $this->urlSections['urlWithoutScheme'], 2);
        } else {
            $domainNameWithSubDomain = $this->urlSections['urlWithoutScheme'];
        }

        $this->addSection('domainWithSubDomain', $domainNameWithSubDomain[0]);
        $this->addSection('pathInfo', $domainNameWithSubDomain[1]);

        return $this;
    }

    /**
     * Seperates Domain name, sub-domain name and extension
     *
     * @return Url
     */
    private function setDomainSubDomainAndExtenstion()
    {
        $explodedDomainAndSubDomain = explode('.', $this->urlSections['domainWithSubDomain']);

        if (substr_count($this->urlSections['domainWithSubDomain'], '.') > 1) {
            $subDomain = $explodedDomainAndSubDomain[0];
            $domain = $explodedDomainAndSubDomain[1] . '.' . $explodedDomainAndSubDomain[2];
            $extension = $explodedDomainAndSubDomain[2];
        } else {
            $subDomain = null;
            $domain = $explodedDomainAndSubDomain[0];
            $extension = $explodedDomainAndSubDomain[1];
        }

        $this->addSection('subDomain', $subDomain);
        $this->addSection('domain', $domain);
        $this->addSection('extension', $extension);

        return $this;
    }

    /**
     * Add key value pair to urlSection
     *
     * @param $key string
     * @param $value string
     *
     * @return Url
     */
    private function addSection($key, $value)
    {
        $this->urlSections[$key] = $value;

        return $this;
    }
}