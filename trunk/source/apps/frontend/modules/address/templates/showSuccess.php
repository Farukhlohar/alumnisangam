<?php include_component('home','leftmenu'); ?>
<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:16:21
?>
<table class="showprofile">
<tbody>
<tr>
<!--<th>Id: </th>
<td><?php //echo $address->getId() ?></td>
</tr>
<tr>
<th>User: </th>
<td><?php //echo $address->getUserId() ?></td>
</tr>
-->

<?php $herror="Home Address<br>"; $werror="Work Address<br>"; $perror="Permanent Address<br>"; $flag=0; ?>
<?php if($addressh):
$flag++;
$herror="";
?>
<?php endif; ?>

<?php if($addressw):
$flag++;
$werror="";
?>
<?php endif; ?>

<?php if($addressp):
$flag++;
$perror="";
?>
<?php endif; ?>


<tr>
<td>
<?php if($flag ==0){ 
		echo "No Address Specified."; 
	}	
	else{ 
		echo "You have not specified the following: <br>".$herror.$werror.$perror; 
	}
	?>

</td>
</tr>




<?php if($addressh): ?>
<tr>
<td>
<?php
echo "Home Address";
/*$flag++;
$herror="";*/
?>
</td>
</tr>
<tr>
<th>Address: </th>
<td><?php echo $addressh->getAddress() ?></td>

<th>Visible to: </th>
<td><?php if($addressh->getAddressflag()  == 1): echo "None"; elseif($addressh->getAddressflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>City: </th>
<td><?php echo $addressh->getCity() ?></td>

<th>Visible to: </th>
<td><?php if($addressh->getCityflag()  == 1): echo "None"; elseif($addressh->getCityflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>State: </th>
<td><?php echo $addressh->getState() ?></td>

<th>Visible to: </th>
<td><?php if($addressh->getStateflag()  == 1): echo "None"; elseif($addressh->getStateflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Country: </th>
<td><?php echo $addressh->getCountry() ?></td>

<th>Visible to: </th>
<td><?php if($addressh->getCountryflag()  == 1): echo "None"; elseif($addressh->getCountryflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Postalcode: </th>
<td><?php echo $addressh->getPostalcode() ?></td>
<th>Visible to: </th>
<td><?php if($addressh->getPostalcodeflag()  == 1): echo "None"; elseif($addressh->getPostalcodeflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>Phone1: </th>
<td><?php echo $addressh->getPhone1() ?></td>
<th>Visible to: </th>
<td><?php if($addressh->getPhone1flag()  == 1): echo "None"; elseif($addressh->getPhone1flag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>Phone2: </th>
<td><?php echo $addressh->getPhone2() ?></td>

<th>Visible to: </th>
<td><?php if($addressh->getPhone2flag()  == 1): echo "None"; elseif($addressh->getPhone2flag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Cellphone: </th>
<td><?php echo $addressh->getCellphone() ?></td>

<th>Visible to: </th>
<td><?php if($addressh->getCellphoneflag()  == 1): echo "None"; elseif($addressh->getCellphoneflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>


<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>

<?php endif; ?>




<?php if($addressw): 
/*$flag++;
$werror="";*/
?>
<tr>
<td>
<?php echo "Work Address"; ?>
</td>
</tr>
<tr>
<!--<th>Id: </th>
<td><?php //echo $address->getId() ?></td>
</tr>
<tr>
<th>User: </th>
<td><?php //echo $address->getUserId() ?></td>
</tr>
-->

<tr>
<th>Address: </th>
<td><?php echo $addressw->getAddress() ?></td>

<th>Visible to: </th>
<td><?php if($addressw->getAddressflag()  == 1): echo "None"; elseif($addressw->getAddressflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>City: </th>
<td><?php echo $addressw->getCity() ?></td>

<th>Visible to: </th>
<td><?php if($addressw->getCityflag()  == 1): echo "None"; elseif($addressw->getCityflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>State: </th>
<td><?php echo $addressw->getState() ?></td>

<th>Visible to: </th>
<td><?php if($addressw->getStateflag()  == 1): echo "None"; elseif($addressw->getStateflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Country: </th>
<td><?php echo $addressw->getCountry() ?></td>

<th>Visible to: </th>
<td><?php if($addressw->getCountryflag()  == 1): echo "None"; elseif($addressw->getCountryflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Postalcode: </th>
<td><?php echo $addressw->getPostalcode() ?></td>
<th>Visible to: </th>
<td><?php if($addressw->getPostalcodeflag()  == 1): echo "None"; elseif($addressw->getPostalcodeflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>Phone1: </th>
<td><?php echo $addressw->getPhone1() ?></td>
<th>Visible to: </th>
<td><?php if($addressw->getPhone1flag()  == 1): echo "None"; elseif($addressw->getPhone1flag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>Phone2: </th>
<td><?php echo $addressw->getPhone2() ?></td>

<th>Visible to: </th>
<td><?php if($addressw->getPhone2flag()  == 1): echo "None"; elseif($addressw->getPhone2flag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Cellphone: </th>
<td><?php echo $addressw->getCellphone() ?></td>

<th>Visible to: </th>
<td><?php if($addressw->getCellphoneflag()  == 1): echo "None"; elseif($addressw->getCellphoneflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>
<tr>
<th>Fax: </th>
<td><?php echo $addressw->getFax() ?></td>
<th>Visible to: </th>
<td><?php if($addressw->getFaxflag()  == 1): echo "None"; elseif($addressw->getFaxflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>

<?php endif; ?>

<?php if($addressp): 
/*$flag++;
$perror="";*/
?>
<tr>
<td>
<?php echo "Permanent Address"; ?>
</td>
</tr>

<tr>
<!--<th>Id: </th>
<td><?php //echo $address->getId() ?></td>
</tr>
<tr>
<th>User: </th>
<td><?php //echo $address->getUserId() ?></td>
</tr>
-->

<tr>
<th>Address: </th>
<td><?php echo $addressp->getAddress() ?></td>

<th>Visible to: </th>
<td><?php if($addressp->getAddressflag()  == 1): echo "None"; elseif($addressp->getAddressflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>City: </th>
<td><?php echo $addressp->getCity() ?></td>

<th>Visible to: </th>
<td><?php if($addressp->getCityflag()  == 1): echo "None"; elseif($addressp->getCityflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>State: </th>
<td><?php echo $addressp->getState() ?></td>

<th>Visible to: </th>
<td><?php if($addressp->getStateflag()  == 1): echo "None"; elseif($addressp->getStateflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Country: </th>
<td><?php echo $addressp->getCountry() ?></td>

<th>Visible to: </th>
<td><?php if($addressp->getCountryflag()  == 1): echo "None"; elseif($addressp->getCountryflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Postalcode: </th>
<td><?php echo $addressp->getPostalcode() ?></td>
<th>Visible to: </th>
<td><?php if($addressp->getPostalcodeflag()  == 1): echo "None"; elseif($addressp->getPostalcodeflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>Phone1: </th>
<td><?php echo $addressp->getPhone1() ?></td>
<th>Visible to: </th>
<td><?php if($addressp->getPhone1flag()  == 1): echo "None"; elseif($addressp->getPhone1flag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>


</tr>

<tr>
<th>Phone2: </th>
<td><?php echo $addressp->getPhone2() ?></td>

<th>Visible to: </th>
<td><?php if($addressp->getPhone2flag()  == 1): echo "None"; elseif($addressp->getPhone2flag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<tr>
<th>Cellphone: </th>
<td><?php echo $addressp->getCellphone() ?></td>

<th>Visible to: </th>
<td><?php if($addressp->getCellphoneflag()  == 1): echo "None"; elseif($addressp->getCellphoneflag() == 2): echo "My Classmates"; else: echo "All"; endif; ?></td>

</tr>

<?php endif; ?>



</tbody>
<!--<tr>
<td>
<?php if($flag ==0): echo "No Address Specified."; else: echo "You have not specified the following: <br>".$herror.$werror.$perror; endif;?>
</td>
</tr>

--></table>
<hr />
<?php echo link_to('edit', 'address/edit?id='.$userid) ?>
<!--

&nbsp;<?php // echo link_to('list', 'address/list') ?>
-->