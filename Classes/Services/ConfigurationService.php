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

        $newSettings['paginate']['itemsPerPage'] = (int) $settings['paginate']['itemsPerPage'];
        $newSettings['paginate']['maximumNumberOfLinks'] = (int) $settings['paginate']['maximumNumberOfLinks'];
        $newSettings['paginate']['insertAbove'] = (bool) (int) $settings['paginate']['insertAbove'];
        $newSettings['paginate']['insertBelow'] = (bool) (int) $settings['paginate']['insertBelow'];

        $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['interamt_connect'];
        $newSettings['extension'] = [
            'useConnectorFallback' => (int) $extConf['connectorUseFallback'],
            'connectorUrl' => trim($extConf['connectorUrl']),
            'connectorService' => trim($extConf['connectorService']),
            'connectorExistingRecords' => trim($extConf['connectorExistingRecords'])
        ];

        return $newSettings;
    }
}