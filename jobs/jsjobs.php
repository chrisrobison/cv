#!/usr/bin/php
<?php
    $files = glob("*.txt");
    $jobs = array();
    
    $translate = array("Title"=>'position', "Desc"=>"summary", "URL"=>"website"); 
    foreach ($files as $file) {
        $lines = file($file);
        $job = array();

        foreach ($lines as $line) {
            $line = trim($line);
            $line = preg_replace("/\&amp;/", "&", $line);

            $parts = preg_split("/:/", $line, 2);

            if ($translate[$parts[0]]) {
                $parts[0] = $translate[$parts[0]];
            }
            
            if ((count($parts) == 2) && (preg_match("/^\/\//", $parts[1]))) {
                $job[$pkey] .= "\n" . $line;
            } else if ((count($parts) == 2) && ($parts[0] != "")) {
                $job[strtolower($parts[0])] .= $parts[1];
                
                $pkey = strtolower($parts[0]);
            } else {
                $job[strtolower($pkey)] .= "\n" . $line;
            }
        }
        list($start, $end) = preg_split("/\-/", $job['period']);
        list($startMonth, $startYear) = preg_split("/,\s/", $start);
        list($endMonth, $endYear) = preg_split("/,\s/", $end);

        $sdate = date("Y-m-01", strtotime(preg_replace("/,/", '', $start)));
        $edate = date("Y-m-01", strtotime(preg_replace("/,/", '', $end)));

        $job['startDate'] = $sdate;
        $job['endDate'] = $edate;

        $jobs[] = $job;
    }
    $jobs = array_reverse($jobs);

    print json_encode($jobs);
    // print_r($jobs);
?>
