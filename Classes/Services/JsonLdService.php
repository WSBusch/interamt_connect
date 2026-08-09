<?php

namespace WSBusch\InteramtConnect\Services;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Typolink\LinkFactory;
use WSBusch\InteramtConnect\Domain\Model\Authority;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;

class JsonLdService
{
    public function buildItemListForVacancies($vacancies): string
    {
        $items = [];
        foreach ($vacancies as $pos => $vacancy) {
            /** @var Vacancy $vacancy */

            $detailUrl = $vacancy->getLocalDetailPage();
            if ($detailUrl === '') {
                $detailUrl = 'https://interamt.de/koop/app/stelle?id=' . $vacancy->getInteramtUid();
            }

            $items[] = [
                '@type' => 'ListItem',
                'position' => $pos + 1,
                'url' => $detailUrl,
                'name' => $vacancy->getTitle(),
            ];
        }

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $items,
        ];

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }

    public function buildJobPostingForVacancy(Vacancy $vacancy, ?Authority $authority, ?LinkFactory $linkFactory, ?ContentObjectRenderer $contentObjectRenderer): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $vacancy->getTitle(),
            'description' => $vacancy->getDescription() !== ''
                ? $vacancy->getDescription()
                : $vacancy->getTitle(),
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => $authority?->getTitle() ?? '',
                'value' => (string) $vacancy->getInteramtUid(),
            ],
        ];

        if ($vacancy->getTenderDate() !== null) {
            $data['datePosted'] = $vacancy->getTenderDate()->format('Y-m-d');
        }

        if ($vacancy->getApplicationDeadline() !== null) {
            $data['validThrough'] = $vacancy->getApplicationDeadline()->format('c');
        }

        if ($authority !== null) {
            $organization = [
                '@type' => 'Organization',
                'name' => $authority->getTitle(),
            ];
            if ($authority->getWebsite() !== '') {
                $website = $linkFactory->createUri($authority->getWebsite(), $contentObjectRenderer);
                $organization['sameAs'] = $website->getUrl();
            }
            $data['hiringOrganization'] = $organization;
        }

        if ($vacancy->getLocationCity() !== '') {
            $data['jobLocation'] = [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $vacancy->getLocationStreet(),
                    'postalCode' => $vacancy->getLocationZip(),
                    'addressLocality' => $vacancy->getLocationCity(),
                    'addressCountry' => 'DE',
                ],
            ];
        }

        $employmentTypes = $this->mapEmploymentType($vacancy);
        if ($employmentTypes !== []) {
            $data['employmentType'] = count($employmentTypes) === 1
                ? $employmentTypes[0]
                : $employmentTypes;
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }

    private function mapEmploymentType(Vacancy $vacancy): array
    {
        $types = [];
        $workTime = \mb_strtolower($vacancy->getWorkTime());
        if (str_contains($workTime, 'teilzeit')) {
            $types[] = 'PART_TIME';
        } elseif (str_contains($workTime, 'vollzeit')) {
            $types[] = 'FULL_TIME';
        }

        $duration = \mb_strtolower($vacancy->getLimitedTo());
        if (str_contains($duration, 'befristet') && !str_contains($duration, 'unbefristet')) {
            $types[] = 'TEMPORARY';
        }

        return $types;
    }
}
