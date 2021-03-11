<?php

$link = (function(){
    // $parts = (parse_url(getenv('DATABASE_URL')));
    // extract($parts);
    // $path = ltrim($path, "/");
    // return pg_connect("host={$host} dbname={$path} user={$user} password={$pass}");
    return pg_connect("host='ec2-50-19-171-158.compute-1.amazonaws.com' dbname='dm38beur6ueir' user='ozvdvqpzcffemd' password='15fddb3f7e51b98c703c61478f01f81ca31c397502b5af0858a07eab98f38470'");
})();
/* check connection */
if (pg_last_error()) {
    printf("Connect failed: %s\n", pg_last_error());
    exit();
}

?>