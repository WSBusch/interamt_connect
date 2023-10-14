<?php

namespace WSBusch\InteramtConnect\Services;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use WSBusch\InteramtConnect\Domain\Repository\AuthorityRepository;
use WSBusch\InteramtConnect\Domain\Repository\VacancyRepository;

class ConnectorService
{
    protected AuthorityRepository $authorityRepository;
    protected VacancyRepository $vacancyRepository;

    public function injectAuthorityRepository(AuthorityRepository $authorityRepository) {
        $this->authorityRepository = $authorityRepository;
    }

    public function injectVacancyRepository(VacancyRepository $vacancyRepository) {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function serviceIsOnline(array $connector=[]): bool {
        if(!array_key_exists('connectorUrl', $connector) || !array_key_exists('connectorService', $connector) ||
            empty($connector['connectorUrl']) || empty($connector['connectorService'])) {
            return false;
        }
        $url = $connector['connectorUrl'].$connector['connectorService'].'?id=1';
        $options = [
            CURLOPT_RETURNTRANSFER => true,      // return web page
            CURLOPT_HEADER         => false,     // do not return headers
            CURLOPT_FOLLOWLOCATION => true,      // follow redirects
            CURLOPT_AUTOREFERER    => true,       // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 2,          // timeout on connect (in seconds)
            CURLOPT_TIMEOUT        => 2,          // timeout on response (in seconds)
            CURLOPT_MAXREDIRS      => 10,         // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,     // SSL verification not required
            CURLOPT_SSL_VERIFYHOST => false,     // SSL verification not required
        ];
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($returnCode !== 200) {
            return false;
        }
        return true;
    }

    public function collectVacanciesListByDemand(array $connector=[], array $demand=[], bool $all=false, string
$subPage=''): array {
        $jobs = [];
        $parameters = [];
        $parameters['partner'] = $demand['authority'];
        if($demand['usePagination']) {
            /** @todo Pagination */
        }

        DebuggerUtility::var_dump($demand);
        DebuggerUtility::var_dump($parameters);

        $response = $this->callService($connector, $parameters, $subPage);
        if(!$all) {
            if(array_key_exists('Stellenangebote', $response)) {
                $jobs = $response['Stellenangebote'];
            }
            return $jobs;
        }
        return $response;
    }

    public function collectVacancyByUid(array $connector=[], int $vacancyUid=0): array {
        $data = [];
        $parameters = [];
        $parameters['id'] = $vacancyUid;
        $response = $this->callService($connector, $parameters);
        if(array_key_exists('Id', $response) && (int) $response['Id'] === $vacancyUid) {
            $data = $response;
        }
        return $data;
    }

    private function callService(array $connector, array $parameters=[], string $subPage=''): array {
        $url = $connector['connectorUrl'].$connector['connectorService'];
        if($subPage) {
            $url .= '/'.$subPage;
        }
        $param = [];
        foreach($parameters as $key => $value) {
            $param[] = $key.'='.urlencode($value);
        }
        if(\count($param) > 0) {
            $url .= '?'.implode('&', $param);
        }
        $result = [];
        $options = [
            CURLOPT_RETURNTRANSFER => true,      // return web page
            CURLOPT_HEADER         => false,     // do not return headers
            CURLOPT_FOLLOWLOCATION => true,      // follow redirects
            CURLOPT_AUTOREFERER    => true,       // set referer on redirect
            CURLOPT_SSL_VERIFYPEER => false,     // SSL verification not required
            CURLOPT_SSL_VERIFYHOST => false,     // SSL verification not required
            CURLOPT_TIMEOUT_MS     => 5000       // Timeout after 5 seconds
        ];
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $responseJson = curl_exec($ch);
        curl_close($ch);
        if($responseJson) {
            return json_decode($responseJson, true);
        }
        return $result;
    }
}