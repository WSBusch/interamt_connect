<?php

namespace WSBusch\InteramtConnect\Provider;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;
use WSBusch\InteramtConnect\Domain\Repository\VacancyRepository;

class BreadcrumbProvider implements DataProcessorInterface
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        if (!$processorConfiguration['menus']) {
            return $processedData;
        }
        if (!ExtensionManagementUtility::isLoaded('interamt_connect')) {
            return $processedData;
        }
        $record = $this->getRecord();
        if ($record) {
            $menus = ['menuBreadcrumb', 'breadcrumb'];
            foreach ($menus as $menu) {
                if (isset($processedData[$menu])) {
                    $this->addRecordToMenu($record, $processedData[$menu]);
                }
            }
        }
        return $processedData;
    }

    public function addRecordToMenu($record, array &$menu) {

        $currentLastKey = \count($menu)-1;
        $menu[$currentLastKey]['hasSubpages'] = 1;

        $menu[] = [
            'data' => $record,
            'title' => (strlen($record['title']) > 60 ? substr($record['title'], 0, 60).'...' : $record['title']),
            'active' => 1,
            'current' => 1,
            'link' => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'),
            'isRecord' => true
        ];
    }

    public function getRecord() {
        $vars = GeneralUtility::_GET('tx_interamtconnect_connector');
        if(!isset($vars['vacancy'])) {
            return null;
        }
        $record = [];
        $vacancyRepository = GeneralUtility::makeInstance(VacancyRepository::class);
        $vacancy = $vacancyRepository->findByInteramtUid($vars['vacancy']);
        if(!$vacancy) {
            // nicht aus Fallback
            return null;
        }

        // aus Fallback
        /** @var Vacancy $vacancy */
        $record['interamtUid'] = $vacancy->getInteramtUid();
        $record['title'] = $vacancy->getTitle();
        return $record;
    }
}