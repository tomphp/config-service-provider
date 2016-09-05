<?php

namespace TomPHP\ConfigServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

final class ConfigServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    const DEFAULT_PREFIX         = 'config';
    const DEFAULT_SEPARATOR      = '.';
    const DEFAULT_INFLECTORS_KEY = 'inflectors';
    const DEFAULT_DI_KEY         = 'di';

    const SETTING_PREFIX    = 'prefix';
    const SETTING_SEPARATOR = 'separator';

    /**
     * @var ApplicationConfig
     */
    private $config;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @deprecated 1.0.0 See UPGRADE.md
     *
     * @param array|ApplicationConfig $config
     * @param array                   $settings
     *
     * @return ConfigServiceProvider
     */
    public static function fromConfig($config, array $settings = [])
    {
        return new self(
            $config,
            self::getSettingOrDefault(self::SETTING_PREFIX, $settings, self::DEFAULT_PREFIX),
            self::getSettingOrDefault(self::SETTING_SEPARATOR, $settings, self::DEFAULT_SEPARATOR)
        );
    }

    /**
     * @deprecated 1.0.0 See UPGRADE.md
     *
     * @param string[] $patterns
     * @param array    $settings
     *
     * @return ConfigServiceProvider
     */
    public static function fromFiles(array $patterns, array $settings = [])
    {
        $separator = self::getSettingOrDefault(self::SETTING_SEPARATOR, $settings, self::DEFAULT_SEPARATOR);

        return self::fromConfig(ApplicationConfig::fromFiles($patterns, $separator), $settings);
    }

    /**
     * @deprecated 1.0.0 See UPGRADE.md
     *
     * @param array|ApplicationConfig $config
     * @param string                  $prefix
     * @param string                  $separator
     */
    public function __construct(
        $config,
        $prefix = self::DEFAULT_PREFIX,
        $separator = self::DEFAULT_SEPARATOR
    ) {
        if (!$config instanceof ApplicationConfig) {
            $config = new ApplicationConfig($config, $separator);
        }

        $this->prefix = $prefix;
        $this->config = $config;
    }

    public function boot()
    {
        $configurator = new League\Configurator();
        $configurator->setContainer($this->container);
        $configurator->addApplicationConfig($this->config, $this->prefix);

        if (isset($this->config[self::DEFAULT_DI_KEY])) {
            $configurator->addServiceConfig(new ServiceConfig($this->config[self::DEFAULT_DI_KEY]));
        }

        if (isset($this->config[self::DEFAULT_INFLECTORS_KEY])) {
            $configurator->addInflectorConfig(
                new InflectorConfig($this->config[self::DEFAULT_INFLECTORS_KEY])
            );
        }
    }

    public function register()
    {
    }

    /**
     * @param string $name
     * @param array  $settings
     * @param mixed  $default
     *
     * @return mixed
     */
    private static function getSettingOrDefault($name, array $settings, $default)
    {
        return isset($settings[$name]) ? $settings[$name] : $default;
    }
}
