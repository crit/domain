<?php
namespace Domain;

/**
 * Class Domain
 *
 * @package Domain
 */
class Domain
{
    /**
     * @param string $url
     *
     * @return null|string
     */
    static function Sub($url)
    {
        if (self::isIP($url)) return null; // disregard IP addresses

        $host = self::Host($url);

        if (self::isLocal($host)) return null; // disregard "localhost"

        $parts = explode('.', $host);

        if (count($parts) < 3) return null; // disregard "domain.tld"

        $sub = array_reverse(array_slice($parts, 0, count($parts) - 2)); // "a.b.c.domain.tld" => [c, b, a]

        return $sub[0];
    }

    /**
     * @param string $url
     *
     * @return null|string
     */
    static function TLD($url)
    {
        if (self::isIP($url)) return null; // disregard IP Addresses

        $host = self::Host($url);

        if (self::isLocal($host)) return null; // disregard "localhost"

        $parts = array_reverse(explode('.', $host)); // "a.b.c.domain.tld" => [tld, domain, c, b, a]

        return $parts[0];
    }

    /**
     * @param string $url
     *
     * @return null|string
     */
    static function Identity($url)
    {
        if (self::isIP($url)) return null;

        $host = self::Host($url);

        if (self::isLocal($host)) return null;

        $parts = array_slice(explode('.', $host), -2); // "a.b.c.domain.tld" => [a, b, c, domain, tld] => [domain, tld];

        return implode('.', $parts);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    static function isLocal($value)
    {
        return (strpos($value, '.') === false);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    static function isIP($value)
    {
        $value = preg_replace('/^(http|https|file|ftp):\/\//', '', $value);
        return (bool) filter_var($value, FILTER_VALIDATE_IP);
    }

    /**
     * @param string $value
     *
     * @return mixed
     */
    static function Host($value)
    {
        if (!preg_match('/^(http|file|ftp)/', $value)) $value = "http://$value";
        return parse_url($value, PHP_URL_HOST);
    }
}