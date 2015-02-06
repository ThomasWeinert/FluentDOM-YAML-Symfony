<?php
/**
 * Serialize an (XHTML) DOM into a HTML5 string.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2014 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\YAML\Symfony {

  use Symfony\Component\Yaml\Dumper;

  /**
   * Serialize an (XHTML) DOM into a HTML5 string.
   *
   * @license http://www.opensource.org/licenses/mit-license.php The MIT License
   * @copyright Copyright (c) 2009-2014 Bastian Feder, Thomas Weinert
   */
  class Serializer {

    /**
     * @var \DOMDocument
     */
    private $_document = NULL;

    /**
     * @var array
     */
    private $_options = [];

    public function __construct(\DOMDocument $document, array $options = []) {
      $this->_document = $document;
      $this->_options = $options;
    }

    public function __toString() {
      try {
        return $this->asString();
      } catch (\Exception $e) {
        return '';
      }
    }

    public function asString() {
      $jsondom = new \FluentDOM\Serializer\Json($this->_document);
      $dumper = new Dumper();
      $dumper->setIndentation(2);
      $yaml = $dumper->dump(
        json_decode(json_encode($jsondom), JSON_OBJECT_AS_ARRAY), 10, 0
      );
      return (string)$yaml;
    }
  }
}
