<?php

namespace WSBusch\InteramtConnect\Helper;

class SearchHelper
{
    public static function collectContracts(int $selected=0, array $settings=[]): array {
        $contracts = [];
        $contracts[1] = ['uid' => 1, 'title' => 'Beamter', 'selected' => $selected===1];
        $contracts[2] = ['uid' => 2, 'title' => 'Arbeitnehmer', 'selected' => $selected===2];
        $contracts[3] = ['uid' => 3, 'title' => 'Ausbildung/Praktikum/Duales Studium', 'selected' => $selected===3];
        return $contracts;
    }

    public static function collectEmploymentDuration(int $selected=0, array $settings=[]): array {
        $duration = [];
        $duration[0] = ['uid' => 0, 'title' => 'offen', 'selected' => $selected===0];
        $duration[1] = ['uid' => 1, 'title' => 'unbefristet', 'selected' => $selected===1];
        $duration[2] = ['uid' => 2, 'title' => 'befristet, Option unbefristet', 'selected' => $selected===2];
        $duration[3] = ['uid' => 3, 'title' => 'befristet', 'selected' => $selected===3];
        return $duration;
    }

    public static function collectWorkTime(int $selected=0, array $settings=[]): array {
        $workTime = [];
        $workTime[0] = ['uid' => 0, 'title' => 'offen', 'selected' => $selected===0];
        $workTime[1] = ['uid' => 1, 'title' => 'Teilzeit', 'selected' => $selected===1];
        $workTime[2] = ['uid' => 2, 'title' => 'Vollzeit', 'selected' => $selected===2];
        $workTime[3] = ['uid' => 3, 'title' => 'beides möglich', 'selected' => $selected===3];
        return $workTime;
    }

    public static function collectAreas(array $selected=[], array $settings=[]): array {
        $areas = [];
        $areas[1] = ['uid' => 1, 'title' => 'Allgemeine Verwaltung', 'selected' => in_array(1, $selected)];
        $areas[2] = ['uid' => 2, 'title' => 'Finanzverwaltung', 'selected' => in_array(2, $selected)];
        $areas[3] = ['uid' => 3, 'title' => 'Bildung und Wissenschaft', 'selected' => in_array(3, $selected)];
        $areas[4] = ['uid' => 4, 'title' => 'Justiz', 'selected' => in_array(4, $selected)];
        $areas[5] = ['uid' => 5, 'title' => 'Öffentliche Sicherheit', 'selected' => in_array(5, $selected)];
        $areas[6] = ['uid' => 6, 'title' => 'Gesundheit', 'selected' => in_array(6, $selected)];
        $areas[7] = ['uid' => 7, 'title' => 'Naturwissenschaften', 'selected' => in_array(7, $selected)];
        $areas[8] = ['uid' => 8, 'title' => 'Technischer Dienst', 'selected' => in_array(8, $selected)];
        return $areas;
    }
}