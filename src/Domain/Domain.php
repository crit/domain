<?php
namespace Domain;

class Domain
{
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

    static function TLD($url)
    {
        if (self::isIP($url)) return null; // disregard IP Addresses

        $host = self::Host($url);

        if (self::isLocal($host)) return null; // disregard "localhost"

        $parts = array_reverse(explode('.', $host)); // "a.b.c.domain.tld" => [tld, domain, c, b, a]

        return $parts[0];
    }

    static function Registerable($url)
    {
        if (self::isIP($url)) return null;

        $host = self::Host($url);

        if (self::isLocal($host)) return null;

        $parts = array_slice(explode('.', $host), -2); // "a.b.c.domain.tld" => [a, b, c, domain, tld] => [domain, tld];

        return implode('.', $parts);
    }

    static function isLocal($value)
    {
        return (strpos($value, '.') === false);
    }

    static function isIP($value)
    {
        return (bool) filter_var($value, FILTER_VALIDATE_IP);
    }

    static function Host($value)
    {
        if (preg_match('/^(http|file|ftp)/i', $value) === false) $value = "http://$value";
        return parse_url($value, PHP_URL_HOST);
    }
}