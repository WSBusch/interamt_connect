<?php

namespace WSBusch\InteramtConnect\Hooks;

use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PluginPreviewRenderer extends StandardContentPreviewRenderer
{
    protected const LLPATH = 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:';

    public array $table = [];

    public array $flexformData = [];

    /** @var IconFactory */
    protected $iconFactory;

    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        $row = $item->getRecord();
        $result = '';
        $header = '<strong>'.$this->getLanguageService()->sL(self::LLPATH.'tx_interamt_connect_connector.name').'</strong>';
        $this->table = [];
        $flexforms = GeneralUtility::xml2array($row['pi_flexform']);
        if(is_string($flexforms)) {
            return 'ERROR: '.htmlspecialchars($flexforms);
        }
        $this->flexformData = (array)$flexforms;
        if (!empty($this->flexformData)) {
            if($row['list_type'] === 'interamtconnect_connector') {
                $viewMode = $this->getFieldFromFlexform('settings.mode');
                $viewBehaviour = $this->getFieldFromFlexform('settings.behaviour');

                $this->table[] = ['Anzeige-Modus', ($viewMode === 'list' ? 'Listenansicht' : 'Detailansicht')];
                $this->table[] = ['Datensätze', ($viewBehaviour === 'fallback' ? 'aus Fallback' : 'Live-Daten')];

                if($viewMode === 'list') {
                    $authorities = GeneralUtility::intExplode(',',$this->getFieldFromFlexform('settings.authorities', 's_ListView'), true);
                    if(\count($authorities) > 0) {
                        $authoritiesOut = [];
                        foreach($authorities as $authority) {
                            $authoritiesOut[] = $this->getRecordData($authority, 'tx_interamtconnect_domain_model_authority');
                        }
                        $this->table[] = [
                            'Behörden', implode(', ', $authoritiesOut)
                        ];
                    }
                    $sortField = (string) $this->getFieldFromFlexform('settings.sortField', 's_ListView');
                    $sortDir = (string) $this->getFieldFromFlexform('settings.sortDirection', 's_ListView');

                    $this->table[] = ['sortieren nach', $this->getLanguageService()->sL(self::LLPATH.'tx_interamtconnect_domain_model_vacancy.'.$sortField)];
                    $this->table[] = ['Sortierreihenfolge', ($sortDir === 'DESC' ? 'absteigend' : 'aufsteigend')];

                    $detailLink = (int) $this->getFieldFromFlexform('settings.detailPageLink', 's_ListView');
                    if($detailLink === 1) {
                        $this->table[] = ['Link zur Detailseite', 'Ja'];
                        $detailPage = (int) $this->getFieldFromFlexform('settings.detailPage', 's_ListView');
                        $this->table[] = ['Detailseite', $this->getRecordData($detailPage)];
                    } else {
                        $this->table[] = ['Link zur Detailseite', 'Nein (Verlinkung zur INTERAMT Detailseite)'];
                    }

                    $filterEnabled = (bool) (int) $this->getFieldFromFlexform('settings.filter.enabled', 's_Filter');
                    if($filterEnabled) {
                        $filterFreeText = (bool) (int) $this->getFieldFromFlexform('settings.filter.free_text', 's_Filter');
                        $filterArea = (bool) (int) $this->getFieldFromFlexform('settings.filter.area', 's_Filter');
                        $filterContracts = (bool) (int) $this->getFieldFromFlexform('settings.filter.contracts', 's_Filter');
                        $filterEmploymentDuration = (bool) (int) $this->getFieldFromFlexform('settings.filter.employment_duration', 's_Filter');
                        $filterWorkTime = (bool) (int) $this->getFieldFromFlexform('settings.filter.work_time', 's_Filter');
                        $filterOut = [];
                        if($filterFreeText) { $filterOut[] = 'Freitext-Suche'; }
                        if($filterArea) { $filterOut[] = 'Bereich-Suche'; }
                        if($filterContracts) { $filterOut[] = 'Dienstverhältnis-Suche'; }
                        if($filterEmploymentDuration) { $filterOut[] = 'Beschäftigungsdauer'; }
                        if($filterWorkTime) { $filterOut[] = 'Arbeitszeiten'; }
                        if(\count($filterOut) > 0) {
                            $this->table[] = ['Filter', implode(', ', $filterOut)];
                        }
                    }

                } else {
                    $listPage = (int) $this->getFieldFromFlexform('settings.listPage', 's_DetailView');
                    $this->table[] = ['Übersichtsseite', $this->getRecordData($listPage)];
                }
                $result = $this->renderTable();
            }
        }

        return $header.$result;
    }

    public function getFieldFromFlexform(string $key, string $sheet = 'sDEF'): ?string {
        $flexform = $this->flexformData;
        if(isset($flexform['data'])) {
            $flexform = $flexform['data'];
            if(isset($flexform[$sheet]['lDEF'][$key]['vDEF'])) {
                return $flexform[$sheet]['lDEF'][$key]['vDEF'];
            }
        }
        return null;
    }

    public function getRecordData(int $id, string $table='pages'): string {
        $record = BackendUtility::getRecord($table, $id);
        if(is_array($record)) {
            $data = '<span data-toggle="tooltip" data-placement="top" data-title="id='.$record['uid'].'">'
                . $this->iconFactory->getIconForRecord($table, $record, Icon::SIZE_SMALL)->render()
                . '</span> ';
            $content = BackendUtility::wrapClickMenuOnIcon(
                $data,
                $table,
                $record['uid'],
                true,
                $record,
                '+info,edit,history'
            );
            $linkTitle = htmlspecialchars(BackendUtility::getRecordTitle($table, $record));
            if($table === 'pages') {
                $id = $record['uid'];
                $currentPageId = (int) GeneralUtility::_GET('id');
                $link = htmlspecialchars($this->getEditLink($record, $currentPageId));
                $switchLabel = 'zur Seite wechseln';
                $content .= ' <a href="#" data-toggle="tooltip" data-placement="top" data-title="'.$switchLabel.'" onclick=\'top.jump("'.$link.'", "web_layout", "web", ' . $id . ');return false\'>' . $linkTitle . '</a>';
            } else {
                $content .= $linkTitle;
            }
        } else {
            $text = sprintf('Datensatz mit der uid "%s" ist nicht mehr vorhanden!', $id);
            $content = $this->generateCallout($text);
        }
        return $content;
    }

    /**
     * @return string
     */
    private function renderTable() {
        $table = "<table class='table table-condensed'>";
        foreach ($this->table as $tableData) {
            $table .= "<tr>";
            $table .= "<td scope='row' style='width:150px'>".$tableData[0]."</td>";
            $table .= "<td>".$tableData[1]."</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        return $table;
    }

    /**
     * @param array $row
     * @param int $currentPageUid
     * @return string
     */
    protected function getEditLink(array $row, int $currentPageUid): string {
        $editLink = '';
        $localCalcPerms = $GLOBALS['BE_USER']->calcPerms(BackendUtility::getRecord('pages', $row['uid']));
        $permsEdit = $localCalcPerms & Permission::PAGE_EDIT;
        if($permsEdit) {
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
            $returnUrl = $uriBuilder->buildUriFromRoute('web_layout', ['id' => $currentPageUid]);
            $editLink = $uriBuilder->buildUriFromRoute('web_layout', [
                'id' => $row['uid'],
                'returnUrl' => $returnUrl
            ]);
        }
        return $editLink;
    }

    protected function generateCallout(string $text): string {
        return '<div class="alert alert-warning">'.htmlspecialchars($text).'</div>';
    }
}