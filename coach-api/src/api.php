<?php
require_once 'database.php';
require_once 'filter_and_sort.php';

header('Content-Type: application/json');

$filter = $_GET['filter'] ?? '';
$sort = $_GET['sort'] ?? '';

$coaches = getCoaches();
$result = filterAndSort($coaches, $filter, $sort);

echo json_encode($result);
