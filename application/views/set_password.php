<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <?php
     
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>FormGet</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/global.css">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/forgot-password.css">
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



                                <div class='resetform_container'>
                                    <div id="mid" class="reset-container">
                                        <h1 class="heading">New Password</h1>
                                        <div class='login_bar'></div>
                                        <form action="<?php echo base_url(); ?>forget_password/update_password" method="post">					   <input type='password' class='f_email fg-input text fg-fw new_pass' id='new_pass' placeholder='New Password' />
                                            <p class="fg-help">Enter your new password</p>
                                            <input type='password' name="password"class='f_email fg-input text fg-fw conf_pass' id='conf_pass' placeholder='Confirm Password'/>
                                            <p class="fg-help">Confirm your password</p>
                                            <input type="hidden" name="id" value="<?php  if(isset($user_id)){echo $user_id;} ?>"
                                                   <p id="error_msg"></p>
                                                <button id='for_sub' type='submit' class='fg-btn fg-fw block blue large bold' onclick='update_pass()'>Reset Password</button>
                                                </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




