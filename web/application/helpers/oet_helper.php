<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//-----------------------------------------------------------------------------
// to get the standard datetime string for oeffitrack
//@param string $datetime a valid datetime string or '0' should be passed
//@return the passed datetime string or the current time if $datetime == '0'
function getStdDateTime($datetime = '0')
{
  if ($datetime == '0')
  {
    $datetime = date('Y-m-d H:i:s');
  }
  return $datetime;
}

//-----------------------------------------------------------------------------
// computes the earliest start time for a route
//@param string $datetime the datetime string
//@return the start time in format  Y-m-d H:i:s
function startTime($datetime)
{
  return date('Y-m-d H:i:s', strtotime($datetime) - 60 * 60 * 12);
}