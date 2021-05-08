<?php
namespace FluentDOM\YAML\Symfony {

  use FluentDOM\DOM\DocumentFragment;
  use FluentDOM\Exceptions\InvalidSource;
  use FluentDOM\Loader\Options;
  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../vendor/autoload.php';

  class LoaderTest extends TestCase {

    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     */
    public function testSupportsExpectingFalse(): void {
      $loader = new Loader();
      $this->assertTrue($loader->supports('text/yaml'));
    }

    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     * @throws InvalidSource
     */
    public function testLoadReturnsImportedDocument(): void {
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
        $loader->load($yaml, 'text/yaml')->getDocument()->saveXML()
      );
    }


    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     * @throws InvalidSource
     */
    public function testLoadFromFileReturnsImportedDocument(): void {
      $yaml = __DIR__.'/TestData/test.yaml';

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
        $loader->load($yaml, 'text/yaml', [Options::ALLOW_FILE => TRUE])->getDocument()->saveXML()
      );
    }

    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     * @throws InvalidSource
     */
    public function testLoadReturnsNullFromInvalidSource(): void {
      $loader = new Loader();
      $this->assertNull(
        $loader->load(NULL, 'type/invalid')
      );
    }

    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     */
    public function testLoadFragment(): void {
      $yaml =
        "regular_map:\n".
        "  one: first\n".
        "  two: second\n";

      $loader = new Loader();
      $fragment = $loader->loadFragment($yaml, 'text/yaml');
      /** @noinspection PhpPossiblePolymorphicInvocationInspection */
      $this->assertXmlStringEqualsXmlString(
        '<regular_map><one>first</one><two>second</two></regular_map>',
        $fragment->firstChild->saveXml()
      );
    }

    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     */
    public function testLoadFragmentReturnsNullFromInvalidSource(): void {
      $loader = new Loader();
      $this->assertNull(
        $loader->loadFragment(NULL, 'type/invalid')
      );
    }

    /**
     * @covers \FluentDOM\YAML\Symfony\Loader
     */
    public function testLoadFragmentReturnsNullFromEmptySource(): void {
      $loader = new Loader();
      $this->assertNull(
        $loader->loadFragment('', 'text/yaml')
      );
    }
  }
}
