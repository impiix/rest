<?php
/**
 * Date: 2/8/16
 * Time: 12:19 AM
 */
namespace AppBundle\DependencyInjection;

use Symfony\Bundle\MonologBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class AppExtension
 * @package AppBundle\DependencyInjection
 */
class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = new Configuration();
        $this->processConfiguration($config, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load("services.yml");
    }
}
