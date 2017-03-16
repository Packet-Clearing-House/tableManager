<?php

function show503($msg){
    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');
    print "Oh no! Error: " . $msg;
}