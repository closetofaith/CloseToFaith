<?php

class C2fSearch_Component_Controller_Results extends Phpfox_Component
{


  public function process()
  {

    // get the search inputs
    $aVals = $this->request()->get('val');
    $sFaith = $aVals['faith'];
    $sLocation = $aVals['location'];

    // check the faith type
    // we will do this by calling a function from this components service that
    // will check the database to see if it's a listed faith

    // check the location type
    // if its a a numeric string and is either 5 of 9 digits, then treat it as a zip code
    // in the long run, we probably want to do this with a regular expression
    $sLocType = is_numeric($sLocation) && (strlen($sLocation) == 5 || strlen($sLocation) == 9) ? 'zip' : 'string';

    $this->template()->assign(array(
        'sFaith' => $sFaith,
        'sLocation' => $sLocation,
        'sLocType' => $sLocType,
        'sFaithType' => $sFaithType
      )
    );
  }
  


}

?>
