<?php

$year = date("Y");
$holysource = json_decode(file_get_contents('../data/holydays.json'), true);

$holydays = [];

foreach($holysource as $holyday) {
  if($holyday['date'] === null && $holyday['rule'] !== null) {
    $date = new \DateTime($year.'-01-01');
    $holyday['date'] = $date->modify($holyday['rule'])->format('Y-m-d');
  }

  if(isset($holyday['easter'])) {
    $date = new \DateTime();
    $date->setTimestamp(easter_date($year));
    $holyday['date'] = $date->modify($holyday['easter'].' day')->format('Y-m-d');
    $easter_label = ($holyday['easter'] < 0) ? "before" : "after";
    $holyday['rule'] = str_replace("-","",$holyday['easter'])." days ".$easter_label." Easter";

    unset($holyday['easter']);
  }

  if($holyday['rule'] === null) unset($holyday['rule']);

  $holydays[] = $holyday;
}

var_dump($holydays);
