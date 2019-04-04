
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reset Password</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/global.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/forgot-password.css">
        <script type='text/javascript' src='<?php echo base_url(); ?>js/jquery-1.9.1.js'></script>  
    </head>
    <body>
      <div id="forgot-password">
        <div class="outer-container">
            <div class="login-logo">
                <a href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>/images/formget_login-logo.png" alt="FormGet Free Online Form Builder" class="login-logo">
                </a>
            </div>
            <div class="inner-container">
                <?php if(isset($info)) { ?>
                <div class='resetform_container'>
                    <?php echo $info;?>
                </div>
                <?php } ?>
                 <?php if(isset($error)) { ?>
                <div class='resetform_container' id="error">
                    <?php echo $error;?>
                </div>
                <?php } ?>
                <?php if(isset($updated_pass)) { ?>
                <div class='resetform_container' id="">
                    <?php echo $updated_pass;?>
                    <a href="<?php echo base_url();?>login" id='for_sub' class="fg-btn fg-fw block blue large bold" >Login</a>
                </div>
                <?php } ?>
               <div class='resetform_container'>
                        <div id='mid' class='reset-container'>
                            <?php if (empty($info) && empty($updated_pass)) {?>
                            <h1 class="heading">Reset Your Password</h1>
                            <div class='login_bar'></div>
                            <form action="<?php echo base_url();?>forget_password/check_password" method="post">
                            <input type='text' name ="email"class='f_email fg-input text fg-fw' id='f_email' placeholder="Email Address"/>
                            <p class="fg-help">Enter the email address you used to sign up</p>
                            <p id="error_msg"></p>
                            <input type='hidden' name ="flag"class='f_email fg-input text fg-fw' id='f_email' placeholder="Email Address" value="1"/>
                            <button id='for_sub' class="fg-btn fg-fw block blue large bold" type=submit onclick='set_pass_mail();'>Reset Password</button>
                            </form>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
      
                              
             
