<?php
/**
 * Serialize an (XHTML) DOM into a YAML string.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

namespace FluentDOM\YAML\Symfony {

  use DOMDocument;
  use Exception;
  use FluentDOM\Serializer\Json as JsonSerializer;
  use Symfony\Component\Yaml\Dumper;

  /**
   * Serialize an (XHTML) DOM into a YAML string.
   */
  class Serializer {

    /**
     * @var DOMDocument
     */
    private $_document;

    /**
     * @var array
     */
    private $_options;

    public function __construct(DOMDocument $document, array $options = []) {
      $this->_document = $document;
      /** @noinspection UnusedConstructorDependenciesInspection */
      $this->_options = $options;
    }

    public function __toString(): string {
      try {
        return $this->asString();
      } catch (Exception $e) {
        return '';
      }
    }

    public function asString(): string {
      $jsonDOM = new JsonSerializer($this->_document);
      $dumper = new Dumper(2);
      return $dumper->dump(
        json_decode(json_encode($jsonDOM), JSON_OBJECT_AS_ARRAY), 10
      );
    }
  }
}
