# Domain Abstraction Class

This is my helper method for dealing with url strings. Specific to a couple of projects I'm working on

## Install

Easy install with [Composer](http://getcomposer.org/).

```php
php composer.phar require "crit/domain": "dev-master"
```

## Usage

```php
<?php
include "vendor/autoload.php";

use Domain\Domain;

$local = Domain::isLocal("http://google.com"); // false
$ip = Domain::isIP("http://www.google.com"); // false
$host = Domain::Host("http://www.google.com/search?q=php"); // www.google.com
$sub = Domain::Sub("http://a.www.google.com/"); // www (I only need first sub)
$tld = Domain::TLD("http://www.google.com/search?q=php"); // com
$ident = Domain::Identity("http://www.google.com"); // google.com
```