<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require "YQLQueryBuilder.php";

$y = new YQLQueryBuilder();

$query = $y->beginQuery()
           ->where("url", "http://en.wikipedia.org/wiki/Yahoo")
           ->where("xpath", "//table/*[contains(.,\"Founder\")]//a")
           // ->where("city", array(1,2,3,4,5), "IN", "OR")
           // ->where("id", array(1,2,3,4,5), "IN", "OR")
           ->showQuery();

echo($query);
