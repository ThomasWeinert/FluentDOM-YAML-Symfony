FluentDOM-YAML-Symfony
=====================

[![License](https://poser.pugx.org/fluentdom/yaml-symfony/license.svg)](http://www.opensource.org/licenses/mit-license.php)
[![Build Status](https://travis-ci.org/ThomasWeinert/FluentDOM-YAML-Symfony.svg?branch=master)](https://travis-ci.org/FluentDOM/YAML-Symfony)
[![Total Downloads](https://poser.pugx.org/fluentdom/yaml-symfony/downloads.svg)](https://packagist.org/packages/fluentdom/yaml-symfony)
[![Latest Stable Version](https://poser.pugx.org/fluentdom/yaml-symfony/v/stable.svg)](https://packagist.org/packages/fluentdom/yaml-symfony)
[![Latest Unstable Version](https://poser.pugx.org/fluentdom/yaml-symfony/v/unstable.svg)](https://packagist.org/packages/fluentdom/yaml-symfony)


Adds support for YAML to FluentDOM. It adds a loader and a serializer. It uses the
[Symfony/YAML](http://symfony.com/doc/current/components/yaml/introduction.html) component.

Installation
------------

```text
composer require fluentdom/yaml-symfony
```

Loader
------

The loader registers automatically. You can trigger it with the types `yaml` and `text/yaml`.

```php
$document = FluentDOM::load($yaml, 'text/yaml');
$query = FluentDOM($yaml, 'text/yaml');
```

Serializer
----------

The serializer needs to be created with for document and can be casted into a string.

```php
echo new FluentDOM\YAML\Symfony\Serializer($document);
```



