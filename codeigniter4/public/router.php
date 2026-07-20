<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");
$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri, PHP_URL_PATH);
$fullPath = __DIR__ . $path;
if ($path !== "/" && file_exists($fullPath) && !preg_match("/\.php$/", $path)) {
    return false;
}
chdir(__DIR__);
$_SERVER["SCRIPT_FILENAME"] = __DIR__ . "/index.php";
try {
    require __DIR__ . "/index.php";
} catch (Throwable $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage() . "\n";
    echo nl2br($e->getTraceAsString());
}
