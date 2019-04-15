<?php

namespace Appstract\Opcache;

use Appstract\Opcache\Format\Byte;

/**
 * Class OpcacheConfiguration
 */
class OpcacheConfiguration
{
    /**
     * @var array The (unfiltered) output of opcache_get_configuration()
     */
    private $configData;

    /**
     * @var \Appstract\Opcache\Format\Byte Formatter of byte values
     */
    private $byteFormatter;

    /**
     * Creates instance
     *
     * @param \Appstract\Opcache\Format\Byte $byteFormatter Formatter of byte values
     * @param array                          $configData    The configuration data from opcache
     */
    public function __construct(Byte $byteFormatter, array $configData)
    {
        $this->byteFormatter = $byteFormatter;
        $this->configData = $configData;
    }

    /**
     * Gets the ini directives of OpCache
     *
     * @return array The ini directives
     */
    public function getIniDirectives()
    {
        $directives = $this->configData['directives'];

        $directives['opcache.memory_consumption'] = $this->byteFormatter->format($directives['opcache.memory_consumption']);

        unset($directives['opcache.inherited_hack']);

        return $directives;
    }

    /**
     * Gets blacklisted files
     *
     * @return array List of blacklisted files
     */
    public function getBlackList()
    {
        return $this->configData['blacklist'];
    }
}
