<?php
/*
 * index.php loads the webpage
 */
 //____ mainprocess ____
require_once 'includes/autoload.php';

 try {
    $dbi = new Database(new PDO(Config::DB_DSN, Config::DB_USER, Config::DB_PASSWORD));
} catch (PDOException $e) {
	exit($e->getMessage());
}
$numberNodes = $dbi->getNumberOfNodes();


include 'includes/header.php';

include 'includes/dashboard.php';

include 'includes/loading.php';

include 'includes/footer.php';
