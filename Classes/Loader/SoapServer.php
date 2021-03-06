<?php

/**
 * Loading SoapServer.
 */
declare(strict_types=1);

namespace HDNET\Autoloader\Loader;

use HDNET\Autoloader\Loader;
use HDNET\Autoloader\Utility\ClassNamingUtility;
use HDNET\Autoloader\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Loading SoapServer.
 */
class SoapServer extends AbstractServerLoader
{
    /**
     * Server name.
     *
     * @var string
     */
    protected $serverName = 'Soap';

    /**
     * Get all the complex data for the loader.
     * This return value will be cached and stored in the database
     * There is no file monitoring for this cache.
     *
     * @param Loader $loader
     * @param int    $type
     *
     * @return array
     */
    public function prepareLoader(Loader $loader, int $type): array
    {
        $servicePath = ExtensionManagementUtility::extPath($loader->getExtensionKey()) . 'Classes/Service/Soap/';
        $serviceClasses = FileUtility::getBaseFilesRecursivelyInDir($servicePath, 'php');

        $info = [];
        foreach ($serviceClasses as $service) {
            $serviceClass = ClassNamingUtility::getFqnByPath(
                $loader->getVendorName(),
                $loader->getExtensionKey(),
                'Service/Soap/' . $service
            );
            $info[\lcfirst($service)] = $serviceClass;
        }

        return $info;
    }
}
