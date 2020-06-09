<?php

#this file is not yet used

global $ips;

prepare_dir(UNZIP_LOCATION.'persistent/',FALSE);

$ips = array_unique($ips);
$ips = array_fill_keys($ips,[]);
$ips = json_encode($ips);
file_put_contents(UNZIP_LOCATION.'persistent/ips.json',$ips);