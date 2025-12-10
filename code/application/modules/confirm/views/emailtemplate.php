<div class="col-sm-12 col-md-8 col-lg-12 no-padding-both">
  <div style="height:7px; background-color:#535353">&nbsp;</div>
  <div style="background-color:#191970; margin:0px; padding:55px 20px 40px 20px; font-family:Helvetica, sans-serif; font-size:13px; color:#535353;">
  <div style="width:100%; text-align:center; margin:auto;">
  <div style="float:left; margin:0 0 0 20px;"><img src="http://orthomol.com.sa/demo/images/logo.png"></div>
  </div>
    <div style="clear:both;"></div>
    <div style="border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:13px;"><span style="font-weight:bold;"></span>
      <div class="row"> <div class="col-md-12" ><span style="text-align:center; font-size:20px; font-weight:bold;margin: 30px 0 0 30px; color:#535353;" >ORDER DETAILS</span></div> </div>
	 <div class="row"> <div class="col-md-3" >Order ID:<b> <?php echo stripslashes($record['order_id']);?> </b></div> <div class="col-md-3"  >Date Time: <?php echo  date("F j, Y, g:i a"); ?></div></div>

    
      <table style="width:80%; margin:20px 0 0 0; border: 1px solid black; border-collapse: collapse;">
  <tr>
    <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;" >Quantity</th>
    <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;">Item Name</th> 
 <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;">Image</th> 	
    <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;" >Rate</th>
    <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;" >Total</th>    
  </tr>
  <?php foreach($products as $items){ ?>
  <tr>
    <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;" ><?php echo $items['qty']; ?></td>
    <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" ><?php echo stripslashes(str_replace("\n","",$items['name'])); ?></td>
	 <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" ><img src="<?php echo site_url(); ?>images/products/<?php echo $items['image']; ?>" height="50" width="100"></td>
   <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;" ><?php echo stripslashes(str_replace("\n","",$items['price'])); ?></td>    
    <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;" ><?php echo stripslashes(str_replace("\n","",$items['subtotal'])); ?></td>    
  </tr>
  <?php  } ?>
   <tr>
    <td  colspan="4" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" >Subtotal</td>
    <td colspan="1" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;" ><?php echo stripslashes($record['cart_total']); ?></td>
  </tr>
  
   <tr>
    <td  colspan="4" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" >Shipping</td>
    <td colspan="1" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;" ><?php echo stripslashes($record['shipping']); ?></td>
  </tr>
  <tr>
    <td  colspan="4" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" >Payable Amount</td>
    <td colspan="1" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;" >Rs.<?php 
	echo stripslashes($record['total']);
	?></td>
  </tr>
  <tr>
    <td  colspan="5" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" ><b>Shipping Address</b></td>
  </tr>
   <tr>
    <td  colspan="5" style="border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;" ><?php echo "Name :".$record['dname']."<br> Email :".$record['demail']."<br> Mobile".$record['dmobile']."<br> Address "$record['daddress']."<br>"; ?> </td>
  </tr>
</table>

<p>Thank You.</p>
<p>For any query or assistance, feel free to <a href="<?php echo site_url();?>contactus">Contact Us.</a></p>

      </div>
  </div>
</div>