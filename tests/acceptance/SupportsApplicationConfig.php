<?php

namespace tests\acceptance;

use TomPHP\ConfigServiceProvider\ConfigureContainer;

trait SupportsApplicationConfig
{
    public function testItAddsConfigToTheContainer()
    {
        $config = ['keyA' => 'valueA'];

        ConfigureContainer::apply()->configFromArray($config)->to($this->container);

        $this->assertEquals('valueA', $this->container->get('config.keyA'));
    }

    public function testItCascadeAddsConfigToTheContainer()
    {
        $config = [
            'keyA' => 'valueA',
            'keyA' => 'valueA',
        ];

        ConfigureContainer::apply()
            ->configFromArray(['keyA' => 'valueA', 'keyB' => 'valueX'])
            ->configFromArray(['keyB' => 'valueB'])
            ->to($this->container);

        $this->assertEquals('valueA', $this->container->get('config.keyA'));

    }

    public function testItAddsGroupedConfigToTheContainer()
    {
        $config = ['group1' => ['keyA' => 'valueA']];

        ConfigureContainer::apply()->configFromArray($config)->to($this->container);

        $this->assertEquals(['keyA' => 'valueA'], $this->container->get('config.group1'));
        $this->assertEquals('valueA', $this->container->get('config.group1.keyA'));
    }

    public function testItAddsConfigToTheContainerWithAnAlternativeSeparator()
    {
        $config = ['keyA' => 'valueA'];

        ConfigureContainer::apply()
            ->configFromArray($config)
            ->withSetting('config_separator', '/')
            ->to($this->container);

        $this->assertEquals('valueA', $this->container->get('config/keyA'));
    }

    public function testItAddsConfigToTheContainerWithAnAlterantivePrefix()
    {
        $config = ['keyA' => 'valueA'];

        ConfigureContainer::apply()
            ->configFromArray($config)
            ->withSetting('config_prefix', 'settings')
            ->to($this->container);

        $this->assertEquals('valueA', $this->container->get('settings.keyA'));
    }

    public function testItAddsConfigToTheContainerWithNoPrefix()
    {
        $config = ['keyA' => 'valueA'];

        ConfigureContainer::apply()
            ->configFromArray($config)
            ->withSetting('config_prefix', '')
            ->to($this->container);

        $this->assertEquals('valueA', $this->container->get('keyA'));
    }
}
