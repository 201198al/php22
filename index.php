<?php

$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
function getPartsFromFullname($fullname) {
    $parts = explode(' ', $fullname);
    return [
        'surname' => $parts[0] ?? '',
        'name' => $parts[1] ?? '',
        'patronomyc' => $parts[2] ?? '',
    ];
}

function getFullnameFromParts($surname, $name, $patronomyc) {
    return $surname . ' ' . $name . ' ' . $patronomyc;
}
function getShortName($fullname) {
    $parts = getPartsFromFullname($fullname);
    return $parts['name'] . ' ' . mb_substr($parts['surname'], 0, 1) . '.';
}
function getGenderFromName($fullname) {
    $parts = getPartsFromFullname($fullname);
    $score = 0;

    if (mb_substr($parts['patronomyc'], -3) === 'вна') $score--;
    if (mb_substr($parts['name'], -1) === 'а') $score--;
    if (mb_substr($parts['surname'], -2) === 'ва') $score--;

    if (mb_substr($parts['patronomyc'], -2) === 'ич') $score++;
    if (in_array(mb_substr($parts['name'], -1), ['й', 'н'])) $score++;
    if (mb_substr($parts['surname'], -1) === 'в') $score++;

    if ($score > 0) return 1;
    if ($score < 0) return -1;
    return 0;
}
function getGenderFromName($fullname) {
    $parts = getPartsFromFullname($fullname);
    $score = 0;

    if (mb_substr($parts['patronomyc'], -3) === 'вна') $score--;
    if (mb_substr($parts['name'], -1) === 'а') $score--;
    if (mb_substr($parts['surname'], -2) === 'ва') $score--;

    if (mb_substr($parts['patronomyc'], -2) === 'ич') $score++;
    if (in_array(mb_substr($parts['name'], -1), ['й', 'н'])) $score++;
    if (mb_substr($parts['surname'], -1) === 'в') $score++;

    if ($score > 0) return 1;
    if ($score < 0) return -1;
    return 0;
}
function getGenderDescription($array) {
    $total = count($array);
    $male = $female = $undefined = 0;

    foreach ($array as $person) {
        $gender = getGenderFromName($person['fullname']);
        if ($gender === 1) $male++;
        elseif ($gender === -1) $female++;
        else $undefined++;
    }

    $malePercent = round(($male / $total) * 100, 1);
    $femalePercent = round(($female / $total) * 100, 1);
    $undefinedPercent = round(($undefined / $total) * 100, 1);

    return "Гендерный состав аудитории:\n---------------------------\n"
        . "Мужчины - $malePercent%\n"
        . "Женщины - $femalePercent%\n"
        . "Не удалось определить - $undefinedPercent%";
}
function getPerfectPartner($surname, $name, $patronomyc, $array) {
    $surname = mb_convert_case($surname, MB_CASE_TITLE);
    $name = mb_convert_case($name, MB_CASE_TITLE);
    $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE);

    $fullname = getFullnameFromParts($surname, $name, $patronomyc);
    $gender = getGenderFromName($fullname);

    do {
        $partner = $array[array_rand($array)];
        $partnerGender = getGenderFromName($partner['fullname']);
    } while ($partnerGender === $gender || $partnerGender === 0);

    $shortName1 = getShortName($fullname);
    $shortName2 = getShortName($partner['fullname']);
    $percent = number_format(mt_rand(5000, 10000) / 100, 2, '.', '');

    return "$shortName1 + $shortName2 = \n♡ Идеально на $percent% ♡";
}
function getPerfectPartner($surname, $name, $patronomyc, $array) {
    $surname = mb_convert_case($surname, MB_CASE_TITLE);
    $name = mb_convert_case($name, MB_CASE_TITLE);
    $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE);

    $fullname = getFullnameFromParts($surname, $name, $patronomyc);
    $gender = getGenderFromName($fullname);

    do {
        $partner = $array[array_rand($array)];
        $partnerGender = getGenderFromName($partner['fullname']);
    } while ($partnerGender === $gender || $partnerGender === 0);

    $shortName1 = getShortName($fullname);
    $shortName2 = getShortName($partner['fullname']);
    $percent = number_format(mt_rand(5000, 10000) / 100, 2, '.', '');

    return "$shortName1 + $shortName2 = \n♡ Идеально на $percent% ♡";
}