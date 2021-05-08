<?php
/**
 * Load a DOM document from a YAML string or file
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

namespace FluentDOM\YAML\Symfony {

  use FluentDOM\DOM\Document;
  use FluentDOM\DOM\DocumentFragment;
  use FluentDOM\Exceptions\InvalidSource;
  use FluentDOM\Loader\Json\JsonDOM as JsonDOMLoader;
  use FluentDOM\Loader\Options;
  use FluentDOM\Loader\Result as LoaderResult;
  use FluentDOM\Loader\Supports;

  use Symfony\Component\Yaml\Parser;
  use Traversable;

  /**
   * Load a DOM document from a YAML string or file
   */
  class Loader extends JsonDOMLoader {

    use Supports;

    /**
     * @return string[]
     */
    public function getSupported(): array {
      return ['yaml', 'text/yaml'];
    }

    /**
     * Load the YAML string into an DOMDocument
     *
     * @param mixed $source
     * @param string $contentType
     * @param array|Traversable|Options $options
     * @return Document|NULL
     * @throws InvalidSource
     */
    public function load($source, string $contentType, $options = []): ?LoaderResult {
      if ($this->supports($contentType)) {
        $settings = $this->getOptions($options);
        $settings->isAllowed($sourceType = $settings->getSourceType($source));
        switch ($sourceType) {
        case Options::IS_FILE :
          $source = file_get_contents($source);
        case Options::IS_STRING :
        default :
          $parser = new Parser();
          $yaml = $parser->parse($source);
          if (!empty($yaml) || is_array($yaml)) {
            $document = new Document('1.0', 'UTF-8');
            $document->appendChild(
              $root = $document->createElementNS(self::XMLNS, 'json:json')
            );
            $this->transferTo($root, $yaml);
            return new LoaderResult($document, $contentType);
          }
        }
      }
      return NULL;
    }

    /**
     * Load the YAML string into an DOMDocumentFragment
     *
     * @param mixed $source
     * @param string $contentType
     * @param array|Traversable|Options $options
     * @return DocumentFragment|NULL
     */
    public function loadFragment($source, string $contentType, $options = []): ?DocumentFragment {
      if ($this->supports($contentType)) {
        $parser = new Parser();
        $yaml = $parser->parse($source);
        if (!empty($yaml) || is_array($yaml)) {
          $document = new Document('1.0', 'UTF-8');
          $fragment = $document->createDocumentFragment();
          $this->transferTo($fragment, $yaml);
          return $fragment;
        }
      }
      return NULL;
    }

    public function getOptions($options): Options {
      $result = new Options(
        $options,
        [
          Options::CB_IDENTIFY_STRING_SOURCE => function($source) {
            return (FALSE !== strpos($source, "\n"));
          }
        ]
      );
      return $result;
    }
  }
}
