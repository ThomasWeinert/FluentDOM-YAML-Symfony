FluentDOM-YAML-Symfony
=====================

[![License](https://poser.pugx.org/fluentdom/yaml-symfony/license.svg)](http://www.opensource.org/licenses/mit-license.php)
[![CI](https://github.com/ThomasWeinert/FluentDOM-YAML-Symfony/actions/workflows/ci.yml/badge.svg)](https://github.com/ThomasWeinert/FluentDOM-YAML-Symfony/actions/workflows/ci.yml)
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

The serializer needs to be created for a document and can be cast into a string.

```php
echo new FluentDOM\YAML\Symfony\Serializer($document);
```

```php
$query = FluentDOM($yaml, 'text/yaml');
echo $query;
```


