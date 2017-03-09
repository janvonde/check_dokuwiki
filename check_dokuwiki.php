#!/usr/bin/php
<?php
 
/***
 *
 * Monitoring plugin to check the Dokuwiki update status.
 *
 * Copyright (c) 2017 Jan Vonde <mail@jan-von.de>
 *
 *
 * Usage: /usr/bin/php ./check_dokuwiki.php -p /path/to/dokuwiki
 *
 *
 * For more information visit https://github.com/janvonde/check_dokuwiki
 *
 ***/
 
 

// get commands passed as arguments
$options = getopt("p:");
if (!is_array($options) ) {
	print "There was a problem reading the passed option.\n\n";
	exit(1);
}
 
if (count($options) != "1") {
	print "check_dokuwiki.php - Monitoring plugin to check the Dokuwiki update status\n
You need to specify the following parameters:
  -p:   full path to dokuwiki root directory \n\n";
	exit(2);
} 


$dokuwikiBasePath = trim($options['p']);



// we need the updateVersion number from doku.php
$handle = fopen("$dokuwikiBasePath/doku.php", "r");

while (!feof($handle)) {
  $data = fgets($handle);
  $pattern = '/(^\$updateVersion = )(.*)(;)/'; 
  preg_match($pattern, $data, $matches);

  if (!empty($matches)) {
    $updateVersionOne = $matches['2'];
    $updateVersion = str_replace('"', '', $updateVersionOne);
  }
}
fclose($handle);



// get information from Dokuwiki website
$ctx = stream_context_create(array(
  'http' => array(
    'timeout' => 3
    )
  )
);
$result = @file_get_contents("http://update.dokuwiki.org/check/$updateVersion", 0, $ctx);
if ($result === FALSE) {
  echo "WARNING: Could not get information from update.dokuwiki.org. Aborting. \n";
  exit (1);
}


// return info
if ($result != "" ) {
  $results = explode("\n", $result);
  echo "ERROR: Dokuwiki - " . $results[0] . "\n | update=1";
  exit (2);
}
else {
  echo "OK: Dokuwiki is up to date. | update=0";
}
?>

