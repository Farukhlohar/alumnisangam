<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:16:21
?>
<?php

/**
 * address actions.
 *
 * @package    sf_sandbox
 * @subpackage address
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class addressActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('address', 'list');
  }

  public function executeList()
  {
    $this->addresss = AddressPeer::doSelect(new Criteria());
  }

  public function executeShow()
  {
  	$c = new Criteria();
  	$c->add(UserPeer::USERNAME, $this->getUser()->getAttribute('username'));
  	$user = UserPeer::doSelectOne($c);
    
    $c = new Criteria();
    $c->add(AddressPeer::USER_ID, $user->getId());
    $c->add(AddressPeer::TYPE, 0);
    $this->addressh = AddressPeer::doSelectOne($c);
  	
    $c = new Criteria();
    $c->add(AddressPeer::USER_ID, $user->getId());
    $c->add(AddressPeer::TYPE, 1);
    $this->addressw = AddressPeer::doSelectOne($c);
    
    $c = new Criteria();
    $c->add(AddressPeer::USER_ID, $user->getId());
    $c->add(AddressPeer::TYPE, 2);
    $this->addressp = AddressPeer::doSelectOne($c);
    
    $this->userid = $user->getId();
    //$this->address = AddressPeer::retrieveByPk($this->getRequestParameter('id'));
    //$this->forward404Unless($this->address);
  }

  public function executeCreate()
  {
    $this->address = new Address();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    //$userid = $this->getRequestParameter('id');
    $username = $this->getUser()->getAttribute('username');
	$c = new Criteria();
	$c->add(UserPeer::USERNAME, $username);
	$user = UserPeer::doSelectOne($c);
    $userid = $user->getId(); 
  	
    $c = new Criteria();
    $c->add(AddressPeer::USER_ID, $userid);
    $c->add(AddressPeer::TYPE, '0');
    $this->address1 = AddressPeer::doSelectOne($c);
    if(!$this->address1)
    {
    	$this->address1 = new Address();
    }
    
    $c = new Criteria();
    $c->add(AddressPeer::USER_ID, $userid);
    $c->add(AddressPeer::TYPE, '1');
    $this->address2 = AddressPeer::doSelectOne($c);
    if(!$this->address2)
    {
    	$this->address2 = new Address();
    }

    $c = new Criteria();
    $c->add(AddressPeer::USER_ID, $userid);
    $c->add(AddressPeer::TYPE, '2');
    $this->address3 = AddressPeer::doSelectOne($c);
    if(!$this->address3)
    {
    	$this->address3 = new Address();
    }
	$this->userid = $userid;
    $this->privacyoptions = Array('1' => 'Myself', '2' => 'My Classmates', '3' => 'Everyone'); 
  }

  public function executeUpdate()
  {
 
    if (!$this->getRequestParameter('id'))
    {
      $addressh = new Address();
      $addressh->setType('0');
    }
    else
    {
      $addressh = AddressPeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($addressh);
    }
  	
    $addressh->setUserId($this->getRequestParameter('user_id') ? $this->getRequestParameter('user_id') : null);
    $addressh->setAddress($this->getRequestParameter('address'));
    $addressh->setAddressflag($this->getRequestParameter('addressflag'));
    $addressh->setCity($this->getRequestParameter('city'));
    $addressh->setCityflag($this->getRequestParameter('cityflag'));
    $addressh->setState($this->getRequestParameter('state'));
    $addressh->setStateflag($this->getRequestParameter('stateflag'));
    $addressh->setCountry($this->getRequestParameter('country'));
    $addressh->setCountryflag($this->getRequestParameter('countryflag'));
    $addressh->setPostalcode($this->getRequestParameter('postalcode'));
    $addressh->setPostalcodeflag($this->getRequestParameter('postalcodeflag'));
    $addressh->setPhone1($this->getRequestParameter('phone1'));
    $addressh->setPhone1flag($this->getRequestParameter('phone1flag'));
    $addressh->setPhone2($this->getRequestParameter('phone2'));
    $addressh->setPhone2flag($this->getRequestParameter('phone2flag'));
    $addressh->setCellphone($this->getRequestParameter('cellphone'));
    $addressh->setCellphoneflag($this->getRequestParameter('cellphoneflag'));
    $addressh->setFax($this->getRequestParameter('fax'));
    $addressh->setFaxflag($this->getRequestParameter('faxflag'));
    $addressh->save();
    
    
    
    
     if (!$this->getRequestParameter('id2'))
    {
      $addressw = new Address();
      $addressw->setType('1');
    }
    else
    {
      $addressw = AddressPeer::retrieveByPk($this->getRequestParameter('id2'));
      $this->forward404Unless($addressw);
    }
      
 
  
    $addressw->setUserId($this->getRequestParameter('user_id') ? $this->getRequestParameter('user_id') : null);
    $addressw->setAddress($this->getRequestParameter('address2'));
    $addressw->setAddressflag($this->getRequestParameter('addressflag2'));
    $addressw->setCity($this->getRequestParameter('city2'));
    $addressw->setCityflag($this->getRequestParameter('cityflag2'));
    $addressw->setState($this->getRequestParameter('state2'));
    $addressw->setStateflag($this->getRequestParameter('stateflag2'));
    $addressw->setCountry($this->getRequestParameter('country2'));
    $addressw->setCountryflag($this->getRequestParameter('countryflag2'));
    $addressw->setPostalcode($this->getRequestParameter('postalcode2'));
    $addressw->setPostalcodeflag($this->getRequestParameter('postalcodeflag2'));
    $addressw->setPhone1($this->getRequestParameter('phone12'));
    $addressw->setPhone1flag($this->getRequestParameter('phone1flag2'));
    $addressw->setPhone2($this->getRequestParameter('phone22'));
    $addressw->setPhone2flag($this->getRequestParameter('phone2flag2'));
    $addressw->setCellphone($this->getRequestParameter('cellphone2'));
    $addressw->setCellphoneflag($this->getRequestParameter('cellphoneflag2'));
    $addressw->setFax($this->getRequestParameter('fax2'));
    $addressw->setFaxflag($this->getRequestParameter('faxflag2'));

    $addressw->save();
    
    
    if (!$this->getRequestParameter('id3'))
    {
      $addressp = new Address();
      $addressp->setType('2');
    }
    else
    {
      $addressp = AddressPeer::retrieveByPk($this->getRequestParameter('id3'));
      $this->forward404Unless($addressp);
    }
      
 
  
    $addressp->setUserId($this->getRequestParameter('user_id') ? $this->getRequestParameter('user_id') : null);
    $addressp->setAddress($this->getRequestParameter('address3'));
    $addressp->setAddressflag($this->getRequestParameter('addressflag3'));
    $addressp->setCity($this->getRequestParameter('city3'));
    $addressp->setCityflag($this->getRequestParameter('cityflag3'));
    $addressp->setState($this->getRequestParameter('state3'));
    $addressp->setStateflag($this->getRequestParameter('stateflag3'));
    $addressp->setCountry($this->getRequestParameter('country3'));
    $addressp->setCountryflag($this->getRequestParameter('countryflag3'));
    $addressp->setPostalcode($this->getRequestParameter('postalcode3'));
    $addressp->setPostalcodeflag($this->getRequestParameter('postalcodeflag3'));
    $addressp->setPhone1($this->getRequestParameter('phone13'));
    $addressp->setPhone1flag($this->getRequestParameter('phone1flag3'));
    $addressp->setPhone2($this->getRequestParameter('phone23'));
    $addressp->setPhone2flag($this->getRequestParameter('phone2flag3'));
    $addressp->setCellphone($this->getRequestParameter('cellphone3'));
    $addressp->setCellphoneflag($this->getRequestParameter('cellphoneflag3'));
    $addressp->setFax($this->getRequestParameter('fax3'));
    $addressp->setFaxflag($this->getRequestParameter('faxflag3'));

    $addressp->save();

 return $this->redirect('address/show');
    
    

}

  public function executeDelete()
  {
    $address = AddressPeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($address);

    $address->delete();

    return $this->redirect('address/list');
  }
}