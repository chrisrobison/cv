#!/usr/bin/php
<?php
    $files = glob("*.txt");
    $jobs = array();

    foreach ($files as $file) {
        $lines = file($file);
        $job = array();

        foreach ($lines as $line) {
            $line = trim($line);
            $line = preg_replace("/\&amp;/", "&", $line);

            $parts = preg_split("/:/", $line, 2);
            
            if ((count($parts) == 2) && (preg_match("/^\/\//", $parts[1]))) {
                $job[$pkey] .= "\n" . $line;
            } else if ((count($parts) == 2) && ($parts[0] != "")) {
                $job[$parts[0]] .= $parts[1];
                
                $pkey = $parts[0];
            } else {
                $job[$pkey] .= "\n" . $line;
            }
        }
        list($start, $end) = preg_split("/\-/", $job['Period']);
        list($job['StartMonth'], $job['StartYear']) = preg_split("/,\s/", $start);
        list($job['EndMonth'], $job['EndYear']) = preg_split("/,\s/", $end);
        
        $job['StartDate'] = trim($start);
        $job['EndDate'] = trim($end);

        $jobs[] = $job;
    }
    print json_encode($jobs);
//    print_r($jobs);
?>
