<?php

class C2fSearch_Component_Controller_Results extends Phpfox_Component
{


  public function process()
  {

    // get the search inputs
    $aVals = $this->request()->get('val');
    $sFaith = $aVals['faith'];
    $sLocation = $aVals['location'];

    /*
    * break location string into
    * a hash of city, state and zip (or string if we don't know what it is)
    * using our parse_location function
    */
    $aLocation = $this->parse_location($sLocation);
    $sString = $aLocation['string'];
    $sCity = $aLocation['city'];
    $sState = $aLocation['state'];
    $sZip = $aLocation['zip'];
    
    /*
    * get the results, per phpFox coding standards, that means passing information
    * to our components service, since only services should touch the database
    * so we will pass the array of location info and the faith to the service
    * and it will return the results as an array of rows
    * then we can pass those results to the results template
    */
    $aRows = Phpfox::getService('c2fsearch')->get_results($sFaith, $aLocation);
    



    $this->template()->assign(array(
        'sFaith' => $sFaith,
        'sLocation' => $sLocation,
        'sFaithType' => $sFaithType,
        'sCity' => $sCity,
        'sState' => $sState,
        'sZip' => $sZip,
        'sString' => $sString,
        'aRows' => $aRows
      )
    );
  }
  

  public function parse_location($sLocation)
  {
    // first let's create some regex match strings
    // start with a full city, state zip format, like 'city, state zip'
    $sCityStateZip = "/^(?P<city>[A-Za-z0-9\s]+),(?P<state>[A-Za-z\s]+)\s(?P<zip>[0-9-]+)$/";
    // then we'll build a city and state only one, like 'city, state'
    $sCityState = "/^(?P<city>[A-Za-z0-9\s]+),(?P<state>[A-Za-z\s]+)$/";
    // then we'll need a zip code one, like '85008' or '85008-1234'
    $sZip = "/^(?P<zip>[0-9-]+)$/";
    // then we'll need one for a plain string (which we'll have to parse further to see if it's a city or a state)
    $sString = "/^(?P<string>[A-Za-z0-9\s]+)$/";

    if(preg_match($sCityStateZip,$sLocation,$aMatches))
    {
      return $aMatches;
    }
    else if(preg_match($sCityState,$sLocation,$aMatches))
    {
      return $aMatches;
    }
    else if(preg_match($sZip,$sLocation,$aMatches))
    {
      return $aMatches;
    }
    else if(preg_match($sString,$sLocation,$aMatches))
    {
      return $aMatches;
    }
    
    // include a failure array for now, but if we have the regex right, we should never get here
    $aFailure = array(
      'city' => 'city',
      'state' => 'az',
      'zip' => 'zip'
    );
    return $aFailure;
  }


}

?>
