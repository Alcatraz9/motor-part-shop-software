<?php

$link = (function(){
    $parts = (parse_url(getenv('DATABASE_URL')));
    extract($parts);
    $path = ltrim($path, "/");
    return pg_connect("host={$host} dbname={$path} user={$user} password={$pass}");
})();
/* check connection */
if (pg_last_error()) {
    printf("Connect failed: %s\n", pg_last_error());
    exit();
}

?>