<?php

namespace tests\unit\TomPHP\ContainerConfigurator\FileReader;

use PHPUnit_Framework_TestCase;
use tests\support\TestFileCreator;
use TomPHP\ContainerConfigurator\FileReader\FileLocator;

final class FileLocatorTest extends PHPUnit_Framework_TestCase
{
    use TestFileCreator;

    /**
     * @var FileLocator
     */
    private $locator;

    protected function setUp()
    {
        $this->locator = new FileLocator();
    }

    public function testItFindsFilesByGlobbing()
    {
        $this->createTestFile('config1.php');
        $this->createTestFile('config2.php');
        $this->createTestFile('config.json');

        $files = $this->locator->locate($this->getTestPath('*.php'));

        assertEquals([
            $this->getTestPath('config1.php'),
            $this->getTestPath('config2.php'),
        ], $files);
    }

    public function testItFindsFindsFilesByGlobbingWithBraces()
    {
        $this->createTestFile('global.php');
        $this->createTestFile('database.local.php');
        $this->createTestFile('nothing.php');
        $this->createTestFile('nothing.php.dist');

        $files = $this->locator->locate($this->getTestPath('{,*.}{global,local}.php'));

        assertEquals([
            $this->getTestPath('global.php'),
            $this->getTestPath('database.local.php'),
        ], $files);
    }
}
