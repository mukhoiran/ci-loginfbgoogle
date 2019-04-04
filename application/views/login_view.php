<?php
$user_name = $this->session->userdata('user_name');
if ($user_name) {
	//echo $userid;
  header('Location:' . base_url() . 'login/home');
}
if(isset($authUrl)){
    echo $_SERVER['QUERY_STRING'];
    if($_SERVER['QUERY_STRING']==='error=access_denied'){
         header('Location:' . base_url());
         
    }else{
            header('Location:' . $authUrl);

    }

}
include_once('includes/login_header.php');
?>

<link rel="stylesheet" href="<?php echo base_url();?>css/global.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>css/login-style.css"/>

<script type="text/javascript">
    $(document).ready(function() {
        var link_url = document.URL;
        jQuery("#freesigninForm").append("<input type='hidden' name='signup_link' value='" + link_url + "' />");
            <?php if(isset($_GET['p'])&&$_GET['p']=='popup'){ ?>
        $('#login_container').hide();
        <?php }else { ?>
        $('#signup_container').hide();
        <?php } ?>
    });

$(function() {
    var wrapper = $('#auth_container');
    var signIn = $('#signin');
    var signInContainer = $('#login_container');
    var signUp = $('#register');
    var signUpContainer = $('#signup_container');
    var spinner = $('#spinner');
    wrapperHeightSignUp = 547;
    wrapperHeightSignIn = 431;
    signUp.click(function(){
        signIn.css('opacity', '0');
        wrapperHeightSignIn = document.getElementById("auth_container").offsetHeight;
        wrapper.css('height',(wrapperHeightSignIn + 60) + 'px');
        signInContainer.fadeOut('slow');
        spinner.fadeIn('slow');    
        spinner.fadeOut('slow');    
        wrapper.stop().animate({ height: wrapperHeightSignUp }, 600); 
        signUpContainer.css('opacity','0', 'display','block');
        signUpContainer.animate({ opacity: 1 }, 'slow').fadeIn(600, function(){
            wrapper.stop().animate({ height: '100%'}, 600);
            signIn.animate({opacity: 1}, 200);
        });
    });
    
    signIn.click(function(){
        signUp.css('opacity', '0');
        wrapperHeightSignUp = document.getElementById("auth_container").offsetHeight;
        wrapper.css('height',(wrapperHeightSignUp + 55) + 'px');
        signUpContainer.fadeOut('slow');
        spinner.fadeIn('slow');    
        spinner.fadeOut('slow');    
        wrapper.stop().animate({ height: wrapperHeightSignIn }, 600); 
        signInContainer.css('opacity','0', 'display','block');
        signInContainer.animate({ opacity: 1 }, 'slow').fadeIn(600, function(){
            wrapper.stop().animate({ height: '100%'}, 600);
            signUp.animate({opacity: 1}, 200);
        });
    });
});

</script>

<style>
    #div_error_box_login,
    #div_error_box_reg{
        color:red;
    }
</style>
<div id="auth_wraper">
    <div class="auth_header">
        <img src="<?php echo base_url(); ?>images/formget_login-logo.png" alt="formget logo"/>
    </div>
    <div id="auth_container">
        <!--Signup Container-->
        <div id="login_container">
            <h2 class="signup_heading">Login to your account.</h2>    
           <div id="social_login">
               <a class="fb_login" href="<?php echo base_url()."login/facebook_login" ; ?>"><span></span>Facebook Login</a>
               <a class="gg_login" href="<?php echo base_url()."login/google_login" ; ?>"><span></span>Google Login</a>
           </div>
            <div class="login_or"></div>
            <div id="div_error_box_login" ><?php
                isset($error) ? $s_e = $error : $s_e = "";
                echo $s_e;
                ?></div>
               
                 <form action="<?php echo base_url(); ?>login/login_check" id="signinForm" class="signinForm" method="post" onsubmit='return login_form_login()' >
                        
                <ul>
                    <li>
                        <input type="text" name="email" id="uname_log" value="" placeholder="Email" class="required requiredField Email fg-input text fg-fw" />
                    </li>
                    <li>
                        <input type="password" name="password" id="password_log" value="" placeholder="Password" class="required requiredField  fg-input text fg-fw" />
                    </li>
                    <li>
                   <div class="chkbox"> <input type="checkbox" name="remember" value="true"/>  Remember me</div>
                    </li>
                    <li>
                        <div class="clear"></div>                       
                        <input onClick="mixpanel.track('new Normal Signup');" class="submit signin_btn fg-btn blue large inline fg-fw bold" type="submit" value="Sign In"/>
                        <input type="hidden" name="submitted" id="submitted" value="true" />
                    </li>
                </ul>
            </form> 
            
            <div>
                <a class="forgot-password" href="<?php echo base_url(); ?>forget_password">Forgot Password</a>
                <a id="register" class="signup-btn">Create New Account</a>
                <div class="clearfix"></div>
            </div>
        </div>
        <!--/Signup Container-->
        <!--Login Container-->
        <div id="signup_container">
            <h2 class="signup_heading">Create a Free Account</h2>     
             <div id="social_login">
               <a class="fb_login" href="<?php echo base_url()."login/facebook_login" ; ?>"><span></span>Facebook Login</a>
               <a class="gg_login" href="<?php echo base_url()."login/google_login" ; ?>"><span></span>Google Login</a>
            </div>
            <div class="login_or"></div>
            <div id="div_error_box_reg" >
                <?php
             //   echo validation_errors();
                isset($r_error) ? $e = $r_error : $e = "";
                echo $e;
                isset($alert_message) ? $message = $alert_message : $message = "";
                echo $message;
                ?>
            </div>
      
            <form action="<?php echo base_url(); ?>login/user_registration" id="freesigninForm" class="freesigninForm" method="post" onsubmit='return login_form_reg()' >
         
                <ul>
                    <li>
                        <input type="text" name="uname" id="reg_uname" value="" placeholder="Full Name" class="required requiredField Username fg-input text fg-fw" />
                    </li>
                    <li>
                        <input type="text" name="email" id="reg_email" value="" placeholder="Email" class="required requiredField Email fg-input text fg-fw" />
                    </li>
                    <li>
                        <input type="password" name="password" id="reg_password" value="" placeholder="Password" class="required requiredField Password fg-input text fg-fw" />
                    </li>
					
                    <div class="clear"></div>
                    <li>
                        <input style="display: none;" id="reg_check3" type="checkbox" name="check" value="YES" checked/>  
                        <span style="display: none;"><a href='http://www.formget.com/terms-conditions/' target='_blank'>I agree with terms and conditions</a></span>
                        <input onClick="mixpanel.track('new Normal Signup');" class="submit fg-btn blue large inline fg-fw bold" type="submit" value="Create Account"/>
                        <input type="hidden" name="submitted" id="submitted" value="true" />
                    </li>
                </ul>
            </form>
            <div>
                <a id="signin" class="signup-btn">Sign In</a>
                <div class="clearfix"></div>
            </div>
        </div>
        <!--/Login Container-->
        <div class="fg-spinner" id="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>                   		
</div>
<!-- trigger for create new account button when email id already exits  -->
 <?php if(isset($email_already_flag)){ ?>
  <script> $("document").ready(function() {
      $("#register").trigger('click');
   });
   </script>
<?php } ?>

<?php
include('includes/login_footer.php');
?>