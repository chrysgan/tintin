<?php

  $base_list = [
    'series',
    'editors',
    'personnages',
    'types'
  ];

  $specific_list = [
    'series_of_editor',
    'get_object_desc',
    'get_object_image',
    'setRateId'
  ];

  if(
    in_array($parameters[1],$base_list,false)
    ||
    (in_array($parameters[1],$specific_list,false) && is_numeric($parameters[2]))
  ){
      require_once DIR_MODELS.$controller.'.php';
  }
  else {
    $send = null;
  }
  require_once DIR_VIEWS.$controller.'.php';

?>
