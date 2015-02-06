<?php
namespace FluentDOM\YAML\Symfony {

  require_once(__DIR__.'/../vendor/autoload.php');

  class LoaderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers FluentDOM\YAML\Symfony\Loader
     */
    public function testSupportsExpectingFalse() {
      $loader = new Loader();
      $this->assertTrue($loader->supports('text/yaml'));
    }

    /**
     * @covers FluentDOM\YAML\Symfony\Loader
     */
    public function testLoadReturnsImportedDocument() {
      $yaml =
        "regular_map:\n".
        "  one: first\n".
        "  two: second\n".
        "\n".
        "shorthand_map: { one: first, two: second }\n";

      $loader = new Loader();
      $this->assertXmlStringEqualsXmlString(
        '<?xml version="1.0" encoding="UTF-8"?>
        <json:json xmlns:json="urn:carica-json-dom.2013">
          <regular_map>
            <one>first</one>
            <two>second</two>
          </regular_map>
          <shorthand_map>
            <one>first</one>
            <two>second</two>
          </shorthand_map>
        </json:json>',
        $loader->load($yaml, 'text/yaml')->saveXML()
      );
    }

    /**
     * @covers FluentDOM\YAML\Symfony\Loader
     */
    public function testLoadReturnsNullFormInvalidSource() {
      $loader = new Loader();
      $this->assertNull(
        $loader->load(NULL, 'type/invalid')
      );
    }
  }
}