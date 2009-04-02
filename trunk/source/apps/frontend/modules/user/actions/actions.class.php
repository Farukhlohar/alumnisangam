<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:14:41
?>
<?php

/**
 * user actions.
 *
 * @package    sf_sandbox
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class userActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('user', 'pendinglist');
  }

  public function executeList()
  {
    $this->users = UserPeer::doSelect(new Criteria());
  }

  public function executeShow()
  {
    $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->user);
  }

  public function executeCreate()
  {
    $this->user = new User();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->user);
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $user = new User();
    }
    else
    {
      $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($user);
    }

    $user->setId($this->getRequestParameter('id'));
    $user->setUsername($this->getRequestParameter('username'));
    $user->setPassword($this->getRequestParameter('password'));
    $user->setEnrolment($this->getRequestParameter('enrolment'));
    $user->setEnrolflag($this->getRequestParameter('enrolflag'));
    $user->setRoll($this->getRequestParameter('roll'));
    $user->setRollflag($this->getRequestParameter('rollflag'));
    $user->setGraduationyear($this->getRequestParameter('graduationyear'));
    $user->setGraduationyearflag($this->getRequestParameter('graduationyearflag'));
    $user->setBranchId($this->getRequestParameter('branch_id') ? $this->getRequestParameter('branch_id') : null);
    $user->setBranchflag($this->getRequestParameter('branchflag'));
    $user->setDegreeId($this->getRequestParameter('degree_id') ? $this->getRequestParameter('degree_id') : null);
    $user->setDegreeflag($this->getRequestParameter('degreeflag'));
    $user->setSecretquestion($this->getRequestParameter('secretquestion'));
    $user->setSecretanswer($this->getRequestParameter('secretanswer'));
    $user->setIslocked($this->getRequestParameter('islocked', 0));

    $user->save();

    return $this->redirect('user/show?id='.$user->getId());
  }

  public function executeDelete()
  {
    $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($user);

    $user->delete();

    return $this->redirect('user/list');
  }
  
  public function executePendinglist()
  {
  	$c = new Criteria();
  	$c->addJoin(UserPeer::ID, PersonalPeer::USER_ID);
  	$c->addJoin(UserPeer::DEGREE_ID, DegreePeer::ID);
  	$c->addJoin(UserPeer::BRANCH_ID, BranchPeer::ID);
  	$c->add(UserPeer::ISLOCKED, '2');
  	$this->personal = PersonalPeer::doSelect($c);
  	
  }
  
  public function executeManagenewuser()
  {
  	$ids = $this->getRequestParameter('ids');
  	$action = $this->getRequestParameter('action1');
  	$value = 5;
  	if($action == 'approve')
  	{
  		$value = 0;
  	}
  	elseif($action == 'reject')
  	{
  		$value = 1;
  	}
  	$idlist = split(',',$ids);
  	$count = 0;
  	foreach($idlist as $id)
  	{
  		$user = UserPeer::retrieveByPK($id);
  		$previslocked = 5;
		if($user)
		{
			$previslocked = $user->getIslocked();
			$c = new Criteria();
			$c->add(PersonalPeer::USER_ID, $user->getId());
			$personal = PersonalPeer::doSelectOne($c);
			$name = $personal->getFirstname()." ".$personal->getMiddlename()." ".$personal->getLastname();
			$newmail = $personal->getEmail();
			
			$newpassword = $this->generatePassword();
  			$user->setIslocked($value);
  			$user->setPassword($newpassword);
  			
  			$count++;
  			
			$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $newmail;
			$subject = "Registration request for ITBHU Global Org";
			if($action == 'approve')
			{
				$userrole = new Userrole();
				$userrole->setRoleId('3');
				$userrole->setUserId($id);
				$userrole->save();
				
				$professional = new Professional();
				$professional->setUserId($id);
				$professional->save();
				
				$academic = new Academic();
				$academic->setUserId($id);
				$academic->save();
				
				$user->save();
				$body ='
Dear '.$name.',

Congrats!! You are now connected to ITBHU GLOBAL.

Your Login Details are:

Username: '.$user->getUsername().'
Password: '.$newpassword.'

Admin,
ITBHU Global
';
			}
			elseif($action == 'reject')
			{
				if($previslocked == 2){
					$user->setIslocked('1');
					$user->save();
				}else{
					$user->delete();
					$personal->delete();
				}
				$body ='
Dear '.$name.',

Your connect request to ITBHU GLOBAL is not approved as your details couldn\'t be verified. 	


Admin,
ITBHU Global
';
			}
			$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  			
		}
  	}
  	if($action == 'approve')
  	{
  		if($count == 0)
  		{
  			$this->setFlash('newuseraction', 'No user(s) selected to approve');
  		}
  		else
  		{
  			$this->setFlash('newuseraction', 'You have successfuly approved '.$count.' users');
  		}
  	}
  	elseif($action == 'reject')
  	{
  		if($count == 0)
  		{
  			$this->setFlash('newuseraction', 'No user(s) selected to reject');
  		}
  		else
  		{
  			$this->setFlash('newuseraction', 'You have successfuly rejected '.$count.' users');
  		}
  	}
  	return $this->redirect('user/newregister');
  	
  }
  protected function generatePassword($length = 8)
  {
	  $password = "";
	  $possible = "0123456789abcdefghjkmnpqrstvwxyzBCDEFGHJKMNPQRSTVWXYZ!@$#%"; 
	  $i = 0; 
	  while ($i < $length) 
	  { 
	    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	    if (!strstr($password, $char)) { 
	      $password .= $char;
	      $i++;
	    }
	  }
	  return $password;
  }
  
  public function executeNewregister()
  {
  	$c = new Criteria();
  	$c->addJoin(UserPeer::ID, PersonalPeer::USER_ID);
  	/*$c->addJoin(UserPeer::BRANCH_ID, BranchPeer::ID);*/
  	$c->add(UserPeer::ISLOCKED, '3');
  	$this->personal = PersonalPeer::doSelect($c);  	
  }
  
 public function executeForgotpasswordform()
 {
 	
 }
  
  public function executeForgotpassword()
  {
  	$email = $this->getRequestParameter('email');
	if($email)
	{
  		$c = new Criteria();
	  	$c->add(PersonalPeer::EMAIL, $email);
	  	$personal = PersonalPeer::doSelectOne($c);
	  	if($personal)
	  	{
		  	$user = $personal->getUser();
		  	
		  	$name = $personal->getFirstname()." ".$personal->getMiddlename()." ".$personal->getLastname();
			$newpassword = $this->generatePassword();
		  	$user->setPassword($newpassword);
		  	$user->save();
		  	
		  	$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $email;
			$subject = "Password reset request for ITBHU Global Org";
			$body ='
		
			Dear '.$name.',
			
			As per your request, your password has been reset.
		
			Your Login Details are:
			
			Username: '.$user->getUsername().'
			Password: '.$newpassword.'
			
			Admin,
			ITBHU Global
			';
			
		  	$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
	  	}
		$this->setFlash('forgotpassword', 'If the Email provided by you is correct and registered, You\'ll recieve a mail soon.' );
  		$this->redirect('user/forgotpasswordform');
	}
  }
	public function handleErrorForgotpassword()
	{
		$this->forward('user','forgotpasswordform');
	}
  	
  public function executeChangepassword()
  {
  	$oldpass = $this->getRequestParameter('oldpassword');
  	$newpass = $this->getRequestParameter('newpassword');
  	if($oldpass)
  	{
		$user = UserPeer::retrieveByPK($this->getUser()->getAttribute('userid'));  		
  		$salt = md5("I am Indian.");
		if(sha1($salt.$oldpass) == $user->getPassword())
		{
			$user->setPassword($newpass);
			$user->save();
			$this->setFlash('changepassword', 'Password changed successfully.' );
			
	  		$c = new Criteria();
		  	$c->add(PersonalPeer::USER_ID, $user->getId());
		  	$personal = PersonalPeer::doSelectOne($c);
		  			  	
		  	$name = $personal->getFirstname()." ".$personal->getMiddlename()." ".$personal->getLastname();
		  	
		  	$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $personal->getEmail();
			$subject = "Password change request for ITBHU Global Org";
			$body ='
		
Dear '.$name.',

Someone, probably you have changed the password.
If its not you, please contact admin as soon as practical.

Admin,
ITBHU Global
';
			
		  	$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			
		}
		else
		{
			$this->setFlash('changepassword', 'Incorrect Old Password' );			
		}
  	}
  }
  

 
  
public function executeSearch()
	{
		$this->mdl = $this->getRequestParameter('mdl');
		$this->fnc = $this->getRequestParameter('fnc');
		
		$branchid = $this->getRequestParameter('branchoption');
		$chapterid = $this->getRequestParameter('chapteroption');
		$year = $this->getRequestParameter('yearoption');
		$degreeid = $this->getRequestParameter('degreeoption');
		// $currentlyat = $this->getRequestParameter('currentlyat');
		
		$flag = 0;
		
		$c = new Criteria();
		if($branchid != 0)
		{
			$c->add(UserPeer::BRANCH_ID, $branchid);
			$flag = 1;
		}
		if($chapterid != 0)
		{
			$c->addJoin(UserPeer::ID, UserchapterregionPeer::USER_ID);
			$c->addJoin(UserchapterregionPeer::CHAPTERREGION_ID, ChapterregionPeer::ID);
			$c->add(ChapterregionPeer::CHAPTER_ID, $chapterid);
			$flag = 1;
		}
		if($year != 0)
		{
			$c->add(UserPeer::GRADUATIONYEAR, $year);
			$flag = 1;
		}
		if($degreeid != 0)
		{
			$c->add(UserPeer::DEGREE_ID, $degreeid);
			$flag = 1;
		}

		if($flag == 1)
		{
			$this->results = UserPeer::doSelect($c);
		}
		else
		{
			$this->flag = 1;
			$this->setFlash('searchnone', 'Select At least one field...');
			return $this->redirect('user/searchform');
		}
		$this->chapterid = $chapterid;
	}

 
  
	public function executeEmailform(){
  		$option = $this->getRequestParameter('o');         
		if ($option == 's'){
			$this->userid =$this->getRequestParameter('selectedid');
			$user = UserPeer::retrieveByPK($this->userid);
		  	$this->fullname = $user->getFullname();
		}
		elseif ($option == 'm'){
			$this->userid = $this->getRequestParameter('userid');
		  	$this->count = count($this->userid);
		  	$this->getUser()->setAttribute('uu', $this->getRequestParameter('userid'));
		}
		/*else {
			$this->userid = $this->getRequestParameter('userid');
		  	$this->count = count($this->userid);
		  	$this->getUser()->setAttribute('uu', $this->getRequestParameter('userid'));
		  	for ($i = 0 ; $i<$this->count ; $i++){
		  		$user = UserPeer::retrieveByPK($this->userid[$i]);
		  		$this->fullnames[$i] = $user->getFullname();
		  	}
		}*/
		
		$this->option = $option;

 	 }

	public function executeSendmail(){
		$option = $this->getRequestParameter('o');
		$userid = $this->getRequestParameter('userid');
		$subject = $this->getRequestParameter('subject');
		$body = $this->getRequestParameter('letter');
	  	$sendermail = sfConfig::get('app_from_mail');
		$sendername = sfConfig::get('app_from_name');

		$userids = $this->getUser()->getAttribute('uu');
		$this->getUser()->getAttributeHolder()->remove('uu');
		
		if($option == 's'){
			$user = UserPeer::retrieveByPK($userid);
			$to = $user->getEmail();
			$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
		}
		elseif($option == 'm'){
			echo count($userids);
			foreach ($userids as $uid){
				echo "hello";
				$ab = $uid;
				$user = UserPeer::retrieveByPK($uid);
				$to = $user->getEmail();
				$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			}
		}
		
		else {
		echo count($userids);
			foreach ($userids as $uid){
				echo "hello";
				$ab = $uid;
				$user = UserPeer::retrieveByPK($uid);
				$to = $user->getEmail();
				$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			}
			
		}

	}
  
   

  public function executeLor(){
  	$lorById = $this->getUser()->getAttribute('userid');
  	$lorByUser = UserPeer::retrieveByPK($lorById);
  	$lorForId = $this->getRequestParameter('lorfor');
  	$lorForUser = UserPeer::retrieveByPK($lorForId);
 	$newmail = $this->getRequestParameter('email');
    if($newmail){
  		$this->lorsave(sfConfig::get('app_lor_email'), $newmail, $lorForId);

  		if($lorForUser->getIslocked() == sfConfig::get('app_islocked_approved'))
  		{
  			$mail = new sfMail();
			$mail->initialize();
			$mail->addCc(sfConfig::get('app_to_adminmail'));
			$mail->addAddress($lorForUser->getEmail());
			
	  		$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $newmail;
			$subject = "Alert: Did you changed your email";
			$body ='
			
Hi '.$lorForUser->getFullname().',
	
	'.$lorByUser->getFullname().' has told us that your email address is 
	actually '.$newmail.'. Is that so? If so, please update it by logging in. If you 
	are having trouble with that, let the admin know [CC\'d on this email].
	
	Admin,
	ITBHU Global
	';
				
		  	$mail = myUtility::newsendmail($mail,$sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  		}elseif($lorForUser->getIslocked() == sfConfig::get('app_islocked_unclaimed')){
			$mail = new sfMail();
			$mail->initialize();
			$mail->addCc(sfConfig::get('app_to_adminmail'));
			$mail->addAddress($lorForUser->getEmail());
			
	  		$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $newmail;
			$subject = "Alert: Connect with your friends at ".sfConfig::get('app_names_org');
			$body ='
			
Hi '.$lorForUser->getFullname().',
	
	'.$lorByUser->getFullname().' has told us that your email address is 
	actually '.$newmail.'.  If so, we strongly encourage you to claim it 
	at '.sfConfig::get('app_urls_claim').' so you can connect with your friends.
	
	Admin,
	ITBHU Global
	';
				
		  	$mail = myUtility::newsendmail($mail,$sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  			
  		}
  	}
  	if($this->getRequestParameter('location')){
  		$this->lorsave(sfConfig::get('app_lor_location'), $this->getRequestParameter('location'), $lorForId);
  	}
    if($this->getRequestParameter('employer')){
  		$this->lorsave(sfConfig::get('app_lor_employer'), $this->getRequestParameter('employer'), $lorForId);
  	}
    if($this->getRequestParameter('position')){
  		$this->lorsave(sfConfig::get('app_lor_position'), $this->getRequestParameter('position'), $lorForId);
  	}  	
    if($this->getRequestParameter('linkedin')){
  		$this->lorsave(sfConfig::get('app_lor_linkedin'), $this->getRequestParameter('linkedin'), $lorForId);
  	}  	
    if($this->getRequestParameter('general')){
  		$this->lorsave(sfConfig::get('app_lor_general'), $this->getRequestParameter('general'), $lorForId);
  	}  	
  	
  	$this->setFlash('notice', 'Comment saved successfully.');
  	$this->redirect('home/searchform');
  }
  
  protected function lorsave($fieldid, $data, $lorForId){
  	$lorById = $this->getUser()->getAttribute('userid');

  	$lor = new Lorvalues();
  	$lor->setLorfieldsId($fieldid);
  	$lor->setData($data);
  	$lor->setUserId($lorById);
  	$lor->setCreatedAt(time());
  	$lor->save();

  	$loruser = new Loruser();
  	$loruser->setLorvaluesId($lor->getId());
  	$loruser->setUserId($lorForId);
	$loruser->save();
  }

	

	
  public function executeLorform(){
  	$this->lorForId = $this->getRequestParameter('selectedid');
  	$user = UserPeer::retrieveByPK($this->lorForId);
  	$this->fullname = $user->getFullname();
  	//$lorById = $this->getUser()->getAttribute('userid');
  }


  public function executeProfile(){
  	$userid = $this->getUser()->getAttribute('userid');
  	$user = UserPeer::retrieveByPK($userid);
  	$oUserid = $this->getRequestParameter('selectedid');
  	$oUser = UserPeer::retrieveByPK($oUserid);
  	
  	$sameclass = 0;
  	if( ($user->getGraduationYear() == $oUser->getGraduationyear) && ($user->getDegreeId() == $oUser->getDegreeId()) && ($user->getBranchId() == $oUser->getBranchId()) ){
  		$sameclass = 1;
  	}
  	$this->oUser = $oUser;
  	$this->sameclass = $sameclass;
  	
  	$this->profilekeysPers = array('Maiden Name', 'IT-BHU Name', 'Gender', 'DoB', 'Marital Status', 'Website', 'Linked In', 'tail');
  	$this->profilekeysProf = array('head', 'Employer', 'Position', 'tail');
  	$this->profilekeysAcad = array('head',  'tail');
  	$this->profilekeysAddh = array('head', 'Address', 'City', 'State', 'Country', 'Postal Code', 'Phone no. 1', 'Phone no. 2', 'Mobile', 'tail');
  	$this->profilekeysAddw = array('head', 'Address', 'City', 'State', 'Country', 'Postal Code', 'Phone no. 1', 'Phone no. 2', 'Mobile', 'Fax', 'tail');
  	$this->profilekeysAddp = array('head', 'Address', 'City', 'State', 'Country', 'Postal Code', 'Phone no. 1', 'Phone no. 2', 'Mobile', 'tail', 'end');
  	
  	//$profilekeys = array_merge($profilekeysPers, $profilekeysProf, $profilekeysAddh, $profilekeysAddw, $profilekeysAddp);
	$profilevaluesPers = array();
	$profilevaluesProf = array();
	$profilevaluesAcad = array();
	$profilevaluesAddh = array();
	$profilevaluesAddw = array();
	$profilevaluesAddp = array();
  	
  	$c = new Criteria();
  	$c->add(PersonalPeer::USER_ID, $oUserid);
  	$personal = PersonalPeer::doSelectOne($c);
  	if($personal){
	 // 	$profilevaluesPers[] = "Personal Details";
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getMaidennameflag(), $personal->getMaidenname());
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getItbhunameflag(), $personal->getItbhuname());
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getGenderflag(), $personal->getGender());
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getDobflag(), $personal->getDob());
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getMaritalstatusflag(), $personal->getMaritalstatus());
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getWebsiteflag(), $personal->getWebsite());
	  	$profilevaluesPers[] = $this->getData($sameclass, $personal->getLinkedinflag(), $personal->getLinkedin());
	  	$profilevaluesPers[] = "tails";
  	}
  	
  	$c = new Criteria();
  	$c->add(ProfessionalPeer::USER_ID, $oUserid);
  	$professional = ProfessionalPeer::doSelectOne($c);
  	if($professional){
	  	$profilevaluesProf[] = "Professional Details";
	  	$profilevaluesProf[] = $this->getData($sameclass, $professional->getEmployerflag(), $professional->getEmployer());
	  	$profilevaluesProf[] = $this->getData($sameclass, $professional->getPositionflag(), $professional->getPosition());
	  	$profilevaluesProf[] = "tails";
  	}
  	
  	$c = new Criteria();
  	$c->add(AcademicPeer::USER_ID, $oUserid);
  	$academic = AcademicPeer::doSelectOne($c);
  	
  	$c = new Criteria();
  	$c->add(AddressPeer::USER_ID, $oUserid);
  	$c->add(AddressPeer::TYPE, '0');
  	$address = AddressPeer::doSelectOne($c);
	if($address){
	  	$profilevaluesAddh[] = "Home Address";
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getAddressflag(), $address->getAddress());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getCityflag(), $address->getCity());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getStateflag(), $address->getState());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getPostalcodeflag(), $address->getPostalcode());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getCountryflag(), $address->getCountry());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getPhone1flag(), $address->getPhone1());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getPhone2flag(), $address->getPhone2());
	  	$profilevaluesAddh[] = $this->getData($sameclass, $address->getCellphoneflag(), $address->getCellphone());
	  	$profilevaluesAddh[] = "tails";
	}
	  	
  	$c = new Criteria();
  	$c->add(AddressPeer::USER_ID, $oUserid);
  	$c->add(AddressPeer::TYPE, '1');
  	$address = AddressPeer::doSelectOne($c);
	if($address){
	  	$profilevaluesAddw[] = "Work Address";
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getAddressflag(), $address->getAddress());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getCityflag(), $address->getCity());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getStateflag(), $address->getState());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getPostalcodeflag(), $address->getPostalcode());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getCountryflag(), $address->getCountry());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getPhone1flag(), $address->getPhone1());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getPhone2flag(), $address->getPhone2());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getCellphoneflag(), $address->getCellphone());
	  	$profilevaluesAddw[] = $this->getData($sameclass, $address->getFaxflag(), $address->getFax());
	  	$profilevaluesAddw[] = "tails";
	}
	
  	$c = new Criteria();
  	$c->add(AddressPeer::USER_ID, $oUserid);
  	$c->add(AddressPeer::TYPE, '2');
  	$address = AddressPeer::doSelectOne($c);
  	if($address){
		$profilevaluesAddp[] = "Permanent Address";
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getAddressflag(), $address->getAddress());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getCityflag(), $address->getCity());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getStateflag(), $address->getState());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getPostalcodeflag(), $address->getPostalcode());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getCountryflag(), $address->getCountry());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getPhone1flag(), $address->getPhone1());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getPhone2flag(), $address->getPhone2());
	  	$profilevaluesAddp[] = $this->getData($sameclass, $address->getCellphoneflag(), $address->getCellphone());
	  	$profilevaluesAddp[] = "tails";
  	}
  	
  	//$this->pk = $profilekeys;
  	$this->pvPr = $profilevaluesPers;
  	$this->pvPf = $profilevaluesProf;
  	$this->pvAc = $profilevaluesAcad;
  	$this->pvAh = $profilevaluesAddh;
  	$this->pvAw = $profilevaluesAddw;
  	$this->pvAp = $profilevaluesAddp;
  }
  
  protected function getData($sameclass, $fl, $val){
	$privacy = $fl;
	switch ($privacy) {
		case '1':
			return '';
			break;
		case '2':
			if($sameclass == 1){
				if($val){
					return $val;
				}else{
					return '#';
				}
			}
			else
				return '';
			break;
		case '3':
			if($val){
				return $val;
			}else{
				return '#';
			}
			break;
		default:
			if($val){
				return $val;
			}else{
				return '#';
			}

	}
	
  }
  
  public function executeInvite(){
  	 $userid =  $this->getUser()->getAttribute('userid');
  	    
  	 $user = UserPeer::retrieveByPK($userid);
	    $this->fullname = $user->getFullname();
  	
  }
  
   public function executeSendinvite(){
		
	   $this->emailid =$this->getRequestParameter('emailid');
	    
		$userid = $this->getRequestParameter('userid');
		$subject = $this->getRequestParameter('subject');
		$body = $this->getRequestParameter('message');
	  	$sendermail = sfConfig::get('app_from_mail');
		$sendername = sfConfig::get('app_from_name');

		
		
	
			$user = UserPeer::retrieveByPK($userid);
			$to = $this->emailid ;
			$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
		}

		
		public function handleErrorSendinvite()
	{
		$this->forward('user','sendinvite');
	}
	
	public function executeDbsearchform(){
		
		//firstname
		/*$c = new Criteria();
		$firstnames = PersonalPeer::doSelect($c);
		foreach ($firstnames as $firstname){
			
		}*/
		
		//lastname
		//Department
		
		$c = new Criteria();
		$branches = BranchPeer::doSelect($c);
		$options = array();
		$options[] = 'Select Department';
		foreach($branches as $branch)
		{
			$options[$branch->getId()] = $branch->getName();
		}
		$this->broptions = $options;	
		//Year of graduation
		
		$options = array();
		$options[] = 'Select Year';
		for($i=1923; $i<=2013; $i++)
		{
			$options[$i] = $i;
		}
		$this->yroptions = $options; 
		
		//Chapter(s) affiliation
		
			
		$c = new Criteria();
		$chapters = ChapterPeer::doSelect($c);
		$options = array();
		$options[] = 'Select Chapter';
		foreach($chapters as $chapter)
		{
			$options[$chapter->getId()] = $chapter->getName();
		}
		$this->choptions = $options;
		//User type
		
		$options = array();
		    $options[0] = 'Student';
		    $options[1] = 'Alumni';
			$options[2] = 'Faculty';
		
		$this->useroptions = $options; 
		
		//Location (city)
		//Country
		
			$c = new Criteria();
		$countrys = CountryPeer::doSelect($c);
		$options = array();
		$options[] = 'Select Country';
		foreach($countrys as $country)
		{
			$options[$country->getId()] = $country->getName();
		}
		$this->countryoptions = $options;
		
      	$this->mdl = $this->getRequestParameter('m');
		$this->fnc = $this->getRequestParameter('f');
		$this->hdr = $this->getRequestParameter('h');
		$this->option = $this->getRequestParameter('o');	
	
		
		
	}
	
	public function executeDbsearch(){
		
		$this->mdl = $this->getRequestParameter('mdl');
		$this->fnc = $this->getRequestParameter('fnc');
		$this->option = $this->getRequestParameter('o');
		$firstname = $this->getRequestParameter('firstname');
		$lastname = $this->getRequestParameter('lastname');
		$branchid = $this->getRequestParameter('branch');
		$yearid = $this->getRequestParameter('year');
		$chapterid = $this->getRequestParameter('chapter');
		$usertypeid = $this->getRequestParameter('usertype');
		$locationid = $this->getRequestParameter('location');
		$countryid = $this->getRequestParameter('country');
		//$c->addAscendingOrderByColumn()
		
		$flag = 0;
		
		$c = new Criteria();
		if($firstname)
		{
			$c->addJoin(UserPeer::ID, PersonalPeer::USER_ID);
			$c->add(PersonalPeer::FIRSTNAME , $firstname);
			$flag = 1;
		}
		
	 if($lastname)
		{
			$c->add(PersonalPeer::LASTNAME , $lastname);
			$flag = 1;
		}
		
	 if($branchid != 0)
		{
			$c->add(UserPeer::BRANCH_ID , $branchid);
			$flag = 1;
		}
		
	 if($yearid != 0)
		{
			$c->add(UserPeer::GRADUATIONYEAR, $yearid);
			$flag = 1;
		}
		
	 if($chapterid != 0)
		{
			$c->addJoin(UserPeer::ID, UserchapterregionPeer::USER_ID);
			$c->addJoin(UserchapterregionPeer::CHAPTERREGION_ID, ChapterregionPeer::ID);
			$c->add(ChapterregionPeer::CHAPTER_ID, $chapterid);
			$flag = 1;
		}
		
		
	  		$c->add(UserPeer::USERTYPE, $usertypeid);
			
	  		
	  		
		if($flag == 1)
		{
			$this->results = UserPeer::doSelect($c);
				$this->count = count($this->results);
				
		}
		else
		{
			$this->flag = 1;
			
			$this->setFlash('searchnone', 'Select At least one field...');
		
			return $this->redirect('user/dbsearchform');
		}
		
		
		
	}
  	
		

	public function executeSort(){
		
		 return $this->forward('user', 'searchform');
		
	}

}

  
