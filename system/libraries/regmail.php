<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RegMail {
   function inkdesk_model() {
        $CI = & get_instance();
        $CI->load->model('inkdesk_model');
        return $CI;
    }

    function paid_account($fid) {
        $CI = $this->inkdesk_model();
        $uid = $CI->inkdesk_model->get_user_by_form_id($fid);
        $pro_account = $CI->inkdesk_model->pro_account($uid);
        $u_reg_date=$CI->inkdesk_model->get_date_for_pro_bar($uid);
	    $u_reg_date=date('Y-m-d',strtotime("$u_reg_date +30 days"));
	    $user_date_check=date('Y-m-d');
		if($u_reg_date>=$user_date_check){
		$pro_account='Paid';
		}
        return $pro_account;
    }
    public function reg_mail($html, $msg) {
		$deschtml_free='';
        $imglink = 'http://www.formget.com/';
        if ($html == 1) {
// Registration Text
            $heading = "Welcome to FormGet.";
            $subheading = "Add New Form now to create amazing contact form for your website.";
            $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
            $deschtml = '';
            $buttontext = "Login to your account";
            $buttonlink = "http://www.formget.com/app/login";
        } elseif ($html == 2) {
// New Agent add 
            $username = $msg['username'];
            $password = $msg['password'];
            $company_name = $msg['company_name'];
            $form_head = $msg['form_head'];
            $heading = "You are added as a new agent.";
            $subheading = "You have been assigned the form: {$form_head} by {$company_name}";
            $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
            $buttontext = "Login to your account here";
            $buttonlink = "http://www.formget.com/app/login";
            $desc_heading = "Use the Credentials below to login to your agent account.";
            $deschtml = <<<EOD
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td valign="top">
					<h3 style="margin:0;font-size:20px;color:#444444"><a href="textlink" style="font-size:20px;text-decoration:none;color:#444444" target="_blank">
						{$desc_heading}</a></h3>
                        <p style="margin:0;padding:7px 0 0; color:#888888;">Username: <b>{$username}</b>
						<br/>Password: <b>{$password}</b></p>
                         </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
EOD;
        } elseif ($html == 3) {
            /**
             * Email to User when admin replies to user message
             */
            if ($msg['chk'] == 1) {
                $company_name = $msg['company_name'];
                $heading = $msg['mhead'];
                $subheading = $msg['mbody']; 
                $address = $msg['mfooter']; 
                $deschtml = "";
                $buttontext = "Click here to read the reply";
                $buttonlink = $msg['client_url'];
            } else {
                $company_name = $msg['company_name'];
                $heading = "Someone replied on your message.";
                $subheading = "Someone has just replied to your Message at {$company_name}";
                $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal MP, India 462023.<br></span>";
                $deschtml = "";
                $buttontext = "Click here to read the reply";
                $buttonlink = $msg['client_url'];
            }
            $deschtml = "";
        }
 elseif ($html == 11) {
            /**
             * Email to Admin when user replies to client_query
             */
            if ($msg['chk'] == 1) {
                $deschtml = $msg['client_msg'];
                $heading = $msg['mhead'];
                $subheading = '';
                $address = $msg['mfooter'];
                $buttontext = "Click here to read the reply";
                $buttonlink = 'http://formget.com/app/login';
            } else {
                $deschtml = $msg['client_msg'];
                $heading = "User replied to your message.";
                $subheading = "";
                $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal MP, India 462023.<br></span>";
                $buttontext = "Click here to read the reply";
                $buttonlink = 'http://formget.com/app/login';
            }
        }		elseif ($html == 4) {
            //Email to Admin when message is received
   if ($msg['chk'] == 1) {
	   $enc_f_id=$msg['enc_f_id'];
    $enc_e_id=$msg['enc_e_id'];
                $msg['formhead'];
                $formhead = $msg['formhead'];
                $formsub = $msg['form_subhead'];
                $desc = $msg['formhtml'];
                $heading = $formhead;
                $subheading =  nl2br($formsub);
                $address = '';
                $buttontext = "Login to your account here";
                 $buttonlink = "http://www.formget.com/app/reply/enquiry/{$enc_f_id}/{$enc_e_id}?p=entry";


                $deschtml = <<<EOD
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td valign="top">
                       <p style=" text-align:center; margin:0;padding:7px 0 0; color:#888888;">{$desc}</p>
                         </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
EOD;
            } else {
                $fid =  $this->paid_account($msg['fid']);
                if ($fid == 'Paid') {
                    $formhead = $msg['formhead'];
                    $desc = $msg['formhtml'];
                    $heading = "New Message Received";
                    $subheading = "A new message is submitted to your form: <b>{$formhead}</b> at FormGet.";
                    $address = "";
                    $buttontext = "Login to your account here";
                    $buttonlink = "http://www.formget.com/app/login";
                    $deschtml = <<<EOD
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td valign="top">
                       <p style="margin:0;padding:7px 0 0; color:#888888;">{$desc}</p>
                         </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
EOD;
                } else {
                    // Free User mail send
                    $formhead = $msg['formhead'];
                    $deschtml = '';
                    $desc = "Want to receive the entire message on your email itself.<br/><a href='http://www.formget.com/app/pricing'> UPGRADE to FormGet Pro.</a>";
                    $heading = "New Message Received";
                    $subheading = " A new message has been submitted on your form: <b> {$formhead} </b>at FormGet.";
                    $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal MP, India 462023.<br></span>";
                    $buttontext = "Click here to view the message and reply back ";
                    $buttonlink = "http://www.formget.com/app/login";
                    $deschtml_free = <<<EOD
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td valign="top">
                       <p style=" text-align:center; margin:0;padding:7px 0 0; color:#888888;">{$desc}</p>
                         </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
EOD;
                }
            }
        } elseif ($html == 5) {
            $user_name = $msg['user_name'];
            $form_name = $msg['form_name'];
            $agent_msg = nl2br($msg['agent_msg']);
			// New agent add 2nd time
            $heading = "You are added as a new agent.";
            $subheading = "{$agent_msg} <br/> <br/> You have been assigned the form: {$form_name} by {$user_name} ";
            $address = "";
            $buttontext = "Login to your account";
            $buttonlink = "http://www.formget.com/app/login";
            $deschtml = "";
        } elseif ($html == 6) {
// Email to User after Message is Submitted
			 $formhead = $msg['formhead'];
            if ($msg['chk'] == 1) {
			   // $heading = $formhead;
				$heading = "Your Message Received.";
                $subheading =  nl2br($msg['form_subhead']);
                $address = $msg['mfooter'];
                $deschtml =  nl2br($msg['form_body']);
            } else {
				echo $fid_paid =  $this->paid_account($msg['fid']);
                if($fid_paid != 'Paid'){
                $deschtml = '<p style="text-align: center;">This form is created using FormGet.<br/> <a href="http://www.formget.com/">Create you own free form now.</a></p>';
				}else{
				$deschtml="";
				}
                $heading = "Your Message Received.";
                $subheading = "We have successfully received your message at " . $formhead;
				if($fid_paid != 'Paid'){
                $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
				}else{
				$address="";
				}
            }
           
            $buttontext = "";
            $buttonlink = "";
        }

        if ($html == 7) {
// Client Payment Received.
            $heading = "Thanks for your purchase.";
            $subheading = $msg['content'];
            $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
            $deschtml = $msg['detail'];
            $buttontext = "Login to your account here";
            $buttonlink = "http://www.formget.com/app/login";
        }
        if ($html == 8) {
            // Reset password
            $heading = "Welcome,Reset Your Password";
            $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
            $buttontext = "Click Here To Set New Password";
            $buttonlink = $msg['link'];
            $deschtml = "";
            $subheading = "";
        }
        if ($html == 9) {
            /**
             * Admin Payment
             * Email to Admin when Payment is received by him
             */
            if ($msg['chk'] == 1) {
                $heading = $msg['mhead'];
                $subheading = $msg['mbody'];
                $address = $msg['mfooter'];
                $deschtml = $msg['detail'];
                $buttontext = "Login to your account here";
                $buttonlink = "http://www.formget.com/app/login";
            } else {
                $heading = $msg['mhead'];
                $subheading = '';
                $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
                $deschtml = $msg['detail'];
                $buttontext = "Login to your account here";
                $buttonlink = "http://www.formget.com/app/login";
            }
        } elseif ($html == 10) {
            /**
             * User Payment
             * Email to User when payment is sent by user
             */
            if ($msg['chk'] == 1) {
                $heading = $msg['mhead'];
                $subheading = $msg['mbody'];
                $address = $msg['mfooter'];
                $deschtml = $msg['detail'];
                $buttontext = "";
                $buttonlink = "";
            } else {
                $heading = $msg['mainheader'];
                $subheading = $msg['subheader'];
                $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal 462023.<br></span>";
                $deschtml = $msg['detail'];
                $buttontext = "";
                $buttonlink = "";
            }
        }
		  elseif ($html == 20) {
		  // message limit cross 
            //Email to Admin when message is received
            if ($msg['chk'] == 1) {
                $msg['formhead'];
                $formhead = $msg['formhead'];
                $formsub = $msg['form_subhead'];
                $desc = $msg['formhtml'];
                $heading = $formhead;
                $subheading = $formsub;
                $address = $msg['mfooter'];
            } else {
                $formhead = $msg['formhead'];
                $desc = $msg['formhtml'];
// New Message Text
                $heading = "New Message Received";
                $subheading = "A new message is submitted to your form: {$formhead} at FormGet.";
                $address = " <span>E-3/49, 3rd Floor.</span> <span>Arera Colony, Bhopal MP, India 462023.<br></span>";
            }
            $buttontext = "Upgrade Account Now";
            $buttonlink = "http://www.formget.com/app/pricing";
            $deschtml = <<<EOD
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                    <td valign="top">
                       <center><p style="margin:0;padding:7px 0 0; color:#888888;">You have received a new message on your form.<br/>However, Since you have exceeded your form message limit,<br/>Please upgrade your account through link below to view your new received message.</p></center>
                         </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
EOD;
        }		
elseif ($html == 21) {
            //create new form email
            if (isset($msg['url'])) {
                $url=$msg['url'];
				$exp_ele_arr=explode('/',$url);
				$get_form_id=$exp_ele_arr[count($exp_ele_arr)-2];
				$view_url=base_url().'form/share/'.$get_form_id;
                $u_name=$msg['name'];
				$page_height=$msg['page_height'];
                $formhead ='';
                $formsub = '';
                $desc = '';
                $heading ='Your Form is ready at FormGet.';
                $subheading = '';
                $address = '';
            } else {
                $url='';
				$view_url='';
                $u_name='';
                $name='';
                $formhead ='';
                $desc = '';
                $heading ='Your Form is ready at FormGet.';
                $subheading = "";
                $address = "";
            }
            $buttontext = "";
            $buttonlink = "";
            $deschtml = <<<EOD
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr><tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                   <td valign="top">
                       <p style="margin:0;padding:7px 0 0; color:#888888;">Hey, {$u_name}<br/><br/>Your Form is ready at FormGet.<br/><br/><b>Checkout your form link below :</b> <br/>{$view_url}<br/>You can share the link directly with your audience and start collecting data instantly.<br/><br/>To embed this form on your website or blog. Use the embed code below:<br/><br/><b>Embed Code:</b><br/><span style="margin:0;padding:7px 0 0; color:#888888;">&lt;iframe height='{$page_height}' id='fg-iframe' allowTransparency='true' frameborder='0' scrolling='yes' style='width:100%;border:none'  src='{$url}'&gt;&lt;/iframe&gt;</span><br/><br/>Just paste the code above anywhere on your website. Here is the <a href="http://www.formget.com/how-to-regiser-and-embed-the-form-a-complete-tutorial/" target="_blank">guide</a> to help you out.<br/><br/>If you any questions or any queries. Email me at neeraj@formget.com<br/><br/>Thanks & Warm Regards,<br/>
Neeraj Agarwal<br/>
FormGet.com<br/></p>
                         </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
EOD;
        }  elseif ($html == 22) {
/** form share**/
            $heading = $msg['mhead'];
            $subheading = $msg['mbody'];
            $address = $msg['mfooter'];
            $deschtml = '';
            $buttontext = "View Form";
            $buttonlink = $msg['murl'];
        }

		
//html string
        $str = <<<EOD
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>Solution - Responsive E-mail Template</title>
<!-- Hotmail ignores some valid styling, so we have to add this -->
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Wrapper -->
<div style="margin:0;padding:0;background:#eeeeee">  
    <table border="0" cellspacing="0" cellpadding="0" width="100%" style="background-color:#eeeeee">
        <tbody>
		<tr>
            <td>   
			<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:640px;padding-left:20px;padding-right:20px">
                    <tbody><tr><td style="min-height:20px"><div style="min-height:20px;min-height:20px;max-height:20px;vertical-align:top;overflow:hidden"></div></td></tr>
                    <tr>
                        <td>
                            
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                                
                                                                
                                                                    <tbody><tr>
                                        <td>
                                            
                                            
                                            
<table border="0" cellspacing="0" cellpadding="40" width="100%" style="margin-top:20px;background:#ffffff;border-radius:8px">
    <tbody><tr>
        <td style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;padding-bottom:0;font-size:14px;line-height:22px;color:#888888;background-color:#ffffff;border-radius:6px">
            
                        
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr>
        <td valign="top" style="padding-bottom:20px">
            <h1 style="margin:0;color:#444444;line-height:32px;font-size:30px">{$heading}
                        </h1><br/>
            <p style="color:#888888">{$subheading}</p>
        </td>
    </tr>
</tbody></table>{$deschtml}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
        <td style="padding:30px 0">
            <table border="0" cellpadding="0" cellspacing="0" width="526">
                <tbody><tr>
				<a style="display:inline-block;width:100%;background-color:#eaf3ff;text-decoration:none;color:#5486c6;font-size:18px;font-weight:bold;text-align:center;padding:15px 0px 15px 0px;border-radius:2px" href="{$buttonlink}" target="_blank">{$buttontext}</a>
									</tr>           </tbody></table>
									{$deschtml_free}
        </td>
    </tr>
</tbody></table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody><tr><td><hr style="color:#eeeeee;background-color:#eeeeee;min-height:1px;border:0;margin:0;padding:0;width:526px"></td></tr>    <tr>
    </tr>
</tbody></table>        </td>
    </tr>
</tbody></table>                                            
                                            
                                        </td>
                                    </tr>
                                                                
                                                                    <tr><td height="20"></td></tr>
                                    <tr>
                                        <td>
                                            
                                            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-bottom:10px">
                                                <tbody><tr>
                                                    <td valign="top" align="center" width="*" style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:11px;line-height:15px;color:#9d9d9d">
                                                       {$address}
                                                        <a href="emailsetting" style="color:#9d9d9d;text-decoration:none;font-weight:bold" target="_blank"></a>
                                                                                                                <a href="opt-out" style="color:#9d9d9d;text-decoration:none;font-weight:bold" target="_blank"></a>
                                                       
                                                                                                            </td>
                                                </tr>
                                            </tbody></table>
                                            
                                        </td>
                                    </tr>
                                                            </tbody></table>
                            
                        </td>
                    </tr>
                    <tr><td style="min-height:20px"><div style="min-height:20px;min-height:20px;max-height:20px;vertical-align:top;overflow:hidden"></div></td></tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody></table>
</div>
<!-- Done -->
</body>
</html>
EOD;
        return $str;
    }
	
	
		/**
	 * Payment Collection reached 500 on particular form 
	 *
	 **/
	
	function payment_exceed($fid, $email_data){
		$CI = $this->inkdesk_model();
		if(!($CI->inkdesk_model->get_user_payment_detail($fid))){
      	$msg = <<<EOD
<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
  <head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>FormGet</title>
  </head>
  <body style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">

<!-- BODY -->
    <table class="body-wrap" bgcolor="#d3e6ec" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;">
      <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td class="container topest" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block !important; max-width: 600px !important; clear: both !important; margin: 40px auto 0; padding: 0;">
			<table class="heading" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; background: #42A2CE; margin: 0; padding: 12px 15px;" bgcolor="#42A2CE"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><a href="http://www.formget.com"><img src="http://www.formget.com/wp-content/themes/form/images/logo.png" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 100%; margin: 0; padding: 0; cursor:pointer;" /></a></td>
				</tr></table><div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 600px; display: block; margin: 0 auto; padding: 15px;">
			<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
						<p class="mini-desc" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; text-align: center; color: #525252; font-size: 16px; font-weight: normal; line-height: 1.6; margin: 10px 0 25px; padding: 0;" align="center">Payment Collected using FormGet Form Exceeded the Free Plan Limit.</p>
						<!-- Callout Panel -->
						<p class="callout" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; text-align: center; color: #888; font-weight: normal; font-size: 14px; line-height: 2.6; background: #F6FCFF; margin: 0 0 35px; padding: 15px;" align="center">
							Please upgrade your account in order to collect more payments.<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;" /><a href="http://www.formget.com/app/pricing" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #2BA6CB; font-weight: bold; margin: 0; padding: 0;">Upgrade to FormGet Pro.</a>
						</p><!-- /Callout Panel -->					
												
						<!-- social & contact -->
						<table class="social" width="100%" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; background: #fcfcfc; margin: 0; padding: 0;" bgcolor="#fcfcfc"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
									
									<!-- column 1 -->
									<table align="left" class="column" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 275px; float: left; min-width: 275px; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 15px;">				
												
												<h5 class="social-heading" style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; color: #525252; font-weight: 100; font-size: 14px; line-height: 1.1; margin: 0 0 15px; padding: 0;">Connect with Us:</h5>
												<p class="" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;"><a href="https://www.facebook.com/FormGet" class="soc-btn fb" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #FFF; font-size: 12px; text-decoration: none; font-weight: bold; display: inline-block; text-align: center; background-color: #3B5998 !important; margin: 0 0 10px; padding: 3px 7px;">Facebook</a> <a href="https://plus.google.com/113839515083342793445/posts" class="soc-btn gp" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #FFF; font-size: 12px; text-decoration: none; font-weight: bold; display: inline-block; text-align: center; background-color: #DB4A39 !important; margin: 0 0 10px; padding: 3px 7px;">Google+</a></p>
						
												
											</td>
										</tr></table><!-- /column 1 --><!-- column 2 --><table align="left" class="column left" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 275px; float: left; min-width: 275px; color: #999999; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 15px;">				
																			
												<h5 class="social-heading" style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; color: #525252; font-weight: 100; font-size: 14px; line-height: 1.1; margin: 0 0 15px; padding: 0;">Contact Info:</h5>												
										<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">E-3/49, 3rd Floor. Arera Colony, Bhopal MP, India 462023.<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;" />
												 <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><a href="http://www.formget.com/contact-us/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #2BA6CB; margin: 0; padding: 0;">Contact Us</a></strong></p>
                
											</td>
										</tr></table><!-- /column 2 --><span class="clear" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block; clear: both; margin: 0; padding: 0;"></span>	
									
								</td>
							</tr></table><!-- /social & contact --></td>
				</tr></table></div><!-- /content -->
									
		</td>
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
	</tr>
    </table>
<!-- /BODY -->
<!-- FOOTER -->
    <table bgcolor="#d3e6ec" class="footer-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; clear: both !important; margin: 0; padding: 0;">
      <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
		<td class="container" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0;">
			
				<!-- content -->
				<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 600px; display: block; margin: 0 auto; padding: 15px;">
				<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td align="center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
						
					</td>
				</tr></table></div><!-- /content -->
				
		</td>
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
	</tr>
    </table>
<!-- /FOOTER -->
  </body>
</html>
EOD;
   //$CI->inkdesk_model->inkdesk_mail("nitisha015@gmail.com", "Payment Exceeded", $msg, "FormGet", $email_data[0]->user_name);
	$CI->inkdesk_model->inkdesk_mail($email_data, "Payment Exceeded", $msg, "FormGet", "noreply@formget.com");
	}
}


function send_mail(){
$CI = $this->inkdesk_model();
$msg_content = "Payment Collected using FormGet Form Exceeded the Free Plan Limit.";
$msg = <<<EOD
<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
  <head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>FormGet</title>
  </head>
  <body style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">

<!-- BODY -->
    <table class="body-wrap" bgcolor="#d3e6ec" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;">
      <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td class="container topest" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block !important; max-width: 600px !important; clear: both !important; margin: 40px auto 0; padding: 0;">
			<table class="heading" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; background: #42A2CE; margin: 0; padding: 12px 15px;" bgcolor="#42A2CE"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><a href="http://www.formget.com"><img src="http://www.formget.com/wp-content/themes/form/images/logo.png" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 100%; margin: 0; padding: 0; cursor:pointer;" /></a></td>
				</tr></table><div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 600px; display: block; margin: 0 auto; padding: 15px;">
			<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
						<p class="mini-desc" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; text-align: center; color: #525252; font-size: 16px; font-weight: normal; line-height: 1.6; margin: 10px 0 25px; padding: 0;" align="center">{$msg_content}</p>
													
						<!-- social & contact -->
						<table class="social" width="100%" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; background: #fcfcfc; margin: 0; padding: 0;" bgcolor="#fcfcfc"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
									
									<!-- column 1 -->
									<table align="left" class="column" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 275px; float: left; min-width: 275px; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 15px;">				
												
												<h5 class="social-heading" style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; color: #525252; font-weight: 100; font-size: 14px; line-height: 1.1; margin: 0 0 15px; padding: 0;">Connect with Us:</h5>
												<p class="" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;"><a href="https://www.facebook.com/FormGet" class="soc-btn fb" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #FFF; font-size: 12px; text-decoration: none; font-weight: bold; display: inline-block; text-align: center; background-color: #3B5998 !important; margin: 0 0 10px; padding: 3px 7px;">Facebook</a> <a href="https://plus.google.com/113839515083342793445/posts" class="soc-btn gp" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #FFF; font-size: 12px; text-decoration: none; font-weight: bold; display: inline-block; text-align: center; background-color: #DB4A39 !important; margin: 0 0 10px; padding: 3px 7px;">Google+</a></p>
						
												
											</td>
										</tr></table><!-- /column 1 --><!-- column 2 --><table align="left" class="column left" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 275px; float: left; min-width: 275px; color: #999999; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 15px;">				
																			
												<h5 class="social-heading" style="font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; color: #525252; font-weight: 100; font-size: 14px; line-height: 1.1; margin: 0 0 15px; padding: 0;">Contact Info:</h5>												
										<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">E-3/49, 3rd Floor. Arera Colony, Bhopal MP, India 462023.<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;" />
												 <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><a href="http://www.formget.com/contact-us/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #2BA6CB; margin: 0; padding: 0;">Contact Us</a></strong></p>
                
											</td>
										</tr></table><!-- /column 2 --><span class="clear" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block; clear: both; margin: 0; padding: 0;"></span>	
									
								</td>
							</tr></table><!-- /social & contact --></td>
				</tr></table></div><!-- /content -->
									
		</td>
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
	</tr>
    </table>
<!-- /BODY -->
<!-- FOOTER -->
    <table bgcolor="#d3e6ec" class="footer-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; clear: both !important; margin: 0; padding: 0;">
      <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
		<td class="container" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0;">
			
				<!-- content -->
				<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 600px; display: block; margin: 0 auto; padding: 15px;">
				<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"><td align="center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
						
					</td>
				</tr></table></div><!-- /content -->
				
		</td>
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;"></td>
	</tr>
    </table>
<!-- /FOOTER -->
  </body>
</html>
EOD;
$title ="New Email template title";
$CI->inkdesk_model->inkdesk_mail("nitisha015@gmail.com", $title, $msg, "", "");
}

}

?>