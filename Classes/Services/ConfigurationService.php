<?php

namespace WSBusch\InteramtConnect\Services;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use WSBusch\InteramtConnect\Domain\Repository\AuthorityRepository;

class ConfigurationService
{
    public static function parseSettings(array $settings): array {
        $newSettings = $settings;
        $newSettings['detailPage'] = (int) $settings['detailPage'];
        $newSettings['detailPageLink'] = (bool) (int) $settings['detailPageLink'];
        $newSettings['behaviour'] = (string) $settings['behaviour'];
        $newSettings['listPage'] = (int) $settings['listPage'];

        if($settings['authorities'] !== '') {
            $authorities = GeneralUtility::intExplode(',', $settings['authorities'], true);
            $authorityList = [];
            $authoritiesRepository = GeneralUtility::makeInstance(AuthorityRepository::class);
            foreach($authorities as $authority) {
                $authorityObject = $authoritiesRepository->findByUid($authority);
                $authorityList[] = $authorityObject;
            }
            $newSettings['authorities'] = $authorityList;
        } else {
            $newSettings['authorities'] = null;
        }

        if(array_key_exists('filter', $settings)) {
            $newSettings['filter'] = [
                'enabled' => (bool) (int) $settings['filter']['enabled'],
                'free_text' => (bool) (int) $settings['filter']['free_text'],
                'area' => (bool) (int) $settings['filter']['area'],
                'contracts' => (bool) (int) $settings['filter']['contracts'],
                'employment_duration' => (bool) (int) $settings['filter']['employment_duration'],
                'work_time' => (bool) (int) $settings['filter']['work_time']
            ];
        }

        $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['interamt_connect'];
        $newSettings['extension'] = [
            'useConnectorFallback' => (int) $extConf['connectorUseFallback'],
            'connectorUrl' => trim($extConf['connectorUrl']),
            'connectorService' => trim($extConf['connectorService']),
            'connectorExistingRecords' => trim($extConf['connectorExistingRecords']),
            'proxyEnable' => (int) $extConf['proxyEnable'],
            'proxySchema' => trim($extConf['proxySchema']),
            'proxyServer' => trim($extConf['proxyServer']),
            'proxyPort' => (int) $extConf['proxyPort']
        ];

        return $newSettings;
    }
}