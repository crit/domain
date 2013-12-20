<?php
include dirname(__DIR__) . "/vendor/autoload.php";

use \Domain\Domain;

function tell($msg) {
    echo "$msg \n";
}

function format($value, $result, $pass, $desired) {
    $desired = json_encode($desired);
    $result = json_encode($result);
    $pass = $pass ? " " : "-";
    return "\t$pass $value => $result ($desired)";
}

$tests = array(
    'isLocal' => array(
        '1.0.0.0' => false,
        'localhost' => true,
        'domain' => true,
        'domain.tld' => false
    ),
    'isIP' => array(
        '1.9.0.0' => true,
        'domain' => false,
        'https://domain.com' => false
    ),
    'Host' => array(
        'localhost' => 'localhost',
        'http://localhost:3000/main.html?id=e#app' => 'localhost',
        'domain.tld' => 'domain.tld',
        'www.domain.tld' => 'www.domain.tld',
        'http://a.b.www.domain.tld' => 'a.b.www.domain.tld'
    ),
    'Sub' => array(
        '1.0.0.0' => null,
        'localhost' => null,
        'https://localhost' => null,
        'a.localhost' => null,
        'https://a.localhost' => null,
        'a.b.localhost' => 'a',
        'https://a.b.localhost' => 'a',
        'www.domain.tld' => 'www',
        'http://www.domain.tld' => 'www',
        'a.b.www.domain.tld' => 'www',
        'ftp://a.b.www.domain.tld' => 'www'
    ),
    'TLD' => array(
        '1.0.0.0' => null,
        'http://1.0.0.0' => null,
        'localhost' => null,
        'http://localhost' => null,
        'a.localhost' => 'localhost',
        'https://a.localhost' => 'localhost',
        'a.localhost.tld' => 'tld',
        'ftp://a.localhost.tld' => 'tld',
        'a.b.c.domain.tld' => 'tld',
        'file://a.b.c.domain.tld/file.pdf' => 'tld',
        'http://a.b.c.domain.co.uk' => 'co.uk'
    ),
    'Registerable' => array(
        '1.0.0.0' => null,
        'http://1.0.0.0' => null,
        'localhost' => null,
        'https://localhost' => null,
        'domain.tld' => 'domain.tld',
        'https://domain.tld' => 'domain.tld',
        'www.domain.tld' => 'domain.tld',
        'http://www.domain.tld/main.html' => 'domain.tld',
        'a.b.c.domain.tld' => 'domain.tld'
    )
);

foreach ($tests as $class => $expectation) {
    tell("Domain::$class");
    foreach ($expectation as $value => $desired) {
        $result = Domain::$class($value);
        $msg = format($value, $result, $result === $desired, $desired);
        tell($msg);
    }
}