<?php
ini_set('max_execution_time', 99999);



$openlogs = $conn1->prepare("SELECT * FROM custaudit.changelog_custaudit WHERE changelog_completedate is NULL ORDER BY changelog_priority");
$openlogs->execute();
$openlogsarray = $openlogs->fetchAll(pdo::FETCH_ASSOC);
