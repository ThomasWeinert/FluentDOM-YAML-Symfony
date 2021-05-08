<?php

namespace FluentDOM\YAML\Symfony {

  use DOMDocument;
  use DOMNode;
  use FluentDOM\Loader\Lazy as LazyLoader;

  \FluentDOM::registerLoader(
    new LazyLoader(
      [
        'text/yaml' => static function () {
          return new Loader;
        },
        'yaml' => static function () {
          return new Loader;
        }
      ]
    )
  );
  \FluentDOM::registerSerializerFactory(
    function(DOMNode $node) {
      return new Serializer(
        $node instanceof DOMDocument ? $node : $node->ownerDocument, []
      );
    },
    'text/yaml',
    'yaml'
  );
}
