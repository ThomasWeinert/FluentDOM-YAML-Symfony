<?php
namespace FluentDOM\YAML\Symfony {

  use FluentDOM\Document;
  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../vendor/autoload.php';

  class SerializerTest extends TestCase {

    /**
     * @covers \FluentDOM\YAML\Symfony\Serializer
     */
    public function testLoadReturnsImportedDocument() {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <json:json xmlns:json="urn:carica-json-dom.2013">
          <regular_map>
            <one>first</one>
            <two>second</two>
          </regular_map>
          <shorthand_map>
            <one>first</one>
            <two>second</two>
          </shorthand_map>
        </json:json>';

      $dom = new Document();
      $dom->preserveWhiteSpace = FALSE;
      $dom->loadXml($xml);

      $serializer = new Serializer($dom);

      $yaml =
        "regular_map:\n".
        "  one: first\n".
        "  two: second\n".
        "shorthand_map:\n".
        "  one: first\n".
        "  two: second\n";

      $this->assertEquals(
        $yaml,
        (string)$serializer
      );
    }

    /**
     * @covers \FluentDOM\YAML\Symfony\Serializer
     */
    public function testToStringCatchesExceptionAndReturnEmptyString() {
      $serializer = new Serializer_TestProxy(new Document());
      $this->assertEquals(
        '', (string)$serializer
      );
    }
  }

  class Serializer_TestProxy extends Serializer {

    public function asString() {
      throw new \LogicException('Catch It.');
    }
  }
}