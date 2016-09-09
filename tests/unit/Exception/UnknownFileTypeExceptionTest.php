<?php

namespace tests\unit\TomPHP\ConfigServiceProvider\Exception;

use DomainException;
use PHPUnit_Framework_TestCase;
use TomPHP\ConfigServiceProvider\Exception\Exception;
use TomPHP\ConfigServiceProvider\Exception\UnknownFileTypeException;

final class UnknownFileTypeExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testItImplementsTheBaseExceptionType()
    {
        $this->assertInstanceOf(Exception::class, new UnknownFileTypeException());
    }

    public function testItIsADomainException()
    {
        $this->assertInstanceOf(DomainException::class, new UnknownFileTypeException());
    }

    public function testItCanBeCreatedFromFileExtension()
    {
        $exception = UnknownFileTypeException::fromFileExtension('.yml', ['.json', '.php']);

        $this->assertSame(
            'No reader configured for ".yml" files; readers are available for [".json", ".php"].',
            $exception->getMessage()
        );
    }
}
