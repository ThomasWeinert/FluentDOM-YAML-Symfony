<?php
/**
 * Load a DOM document from a HTML5 string or file
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2014 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\YAML\Symfony {

  use FluentDOM\Document;
  use FluentDOM\Loadable;
  use FluentDOM\Loader\Supports;

  use Symfony\Component\Yaml\Parser;

  /**
   * Load a DOM document from a HTML5 string or file
   */
  class Loader extends \FluentDOM\Loader\Json\JsonDOM {

    use Supports;

    /**
     * @return string[]
     */
    public function getSupported() {
      return ['yaml', 'text/yaml'];
    }

    /**
     * Load the YAML string into an DOMDocument
     *
     * @param mixed $source
     * @param string $contentType
     * @param array $options
     * @return Document|NULL
     */
    public function load($source, $contentType, array $options = []) {
      if ($this->supports($contentType)) {
        if (FALSE === strpos($source, "\n")) {
          $source = file_get_contents($source);
        }
        $parser = new Parser();
        $yaml = $parser->parse($source);
        if (!empty($yaml) || is_array($yaml)) {
          $dom = new Document('1.0', 'UTF-8');
          $dom->appendChild(
            $root = $dom->createElementNS(self::XMLNS, 'json:json')
          );
          $this->transferTo($root, $yaml);
          return $dom;
        }
      }
      return NULL;
    }
  }
}