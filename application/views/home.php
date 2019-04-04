<!DOCTYPE html>
 <?php if (!$this->session->userdata('user_name')) { 
      header('Location:' . base_url() . 'login');    
    }   
     ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/global.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fg-main-style.css">
    </head>
    <body>
       
            <div id="main-wrapper" class="container-fluid">

                <!-- Header Section -->
                <div class="row">
                    <div class="main-header">  
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <a href="#" class="logo"><img src="<?php echo base_url(); ?>images/logo.png" alt="Formget Fugo"></a>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <div>
                                <div class="user-nav">
                                    <span class="wel-name">Welcome  <?php if(isset($user_name)){echo $user_name; } ?> </span>
                                    <div id="user-img">
                                        <img src="<?php if ($this->session->userdata('user_picture')) { 
                                           echo $this->session->userdata('user_picture');  
                                            } else{echo base_url()."images/user-img.png";}?>" alt="Profile Picture">
                                        <span class="arrow-down"></span>
                                        <div id="fg-dropdown">
                                            <div class="fg-dropdown-inner">
                                                <ul>
                                                    <li><a href="<?php echo base_url(); ?>login/home" class="first">Home</a></li>
                                                    <li><a href="<?php echo base_url(); ?>login/profile">Account Settings</a></li>
                                                    <li><a href="<?php if ($this->session->userdata('logout_url')) { 
                                         echo $this->session->userdata('logout_url');  
                                          }else { echo "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=". base_url()."login/logout" ; }?>" >Log out</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fg-clear"></div>


                        <div class="fg-clear"></div>
                    </div>
                </div>

                <!-- Middle Section -->
                <div class="row  main-container blue-bg">
                    <div class="col-md-3 nopadding">

                        <div id="sidebar">
                            <h3>Preferences</h3>
                            <hr>
                            <ul class="all-options">
                                <li><a href="<?php echo base_url(); ?>login/home"><i class="icon-arrow-right5"></i>Home</a></li>
                                <li><a href="<?php echo base_url(); ?>login/profile"><i class="icon-arrow-right5"></i>My Profile</a></li>

                            </ul>
                        </div>

                    </div>
                    <div class="col-md-9 nopadding">

                        <div id="right-section-wrapper">

                            <div class="clearfix"></div>
                            <div class="fg-box End">
                                <p class="fg-box-header relative rl-pad">Add Your Template</p>
                                <div class="fg-inner-box rl-pad">
                                    <p class="m-bottom">Here You can add your own template</p>
                                    <div class="agent-detail">
                                        <div class="fg-row last">
                                            <div class="col-md-6 nopadding agent">
                                                <div class="single-agent">
                                                    <div class="fg-left">
                                                        <img class="agent-img" src="<?php echo base_url(); ?>images/noimg.png"/>
                                                    </div>
                                                    <div class="detail">
                                                        <ul>
                                                            <li class="name bold">John di</li>
                                                            <li class="email regular">johndi@ymail.com</li>
                                                            <li class="assigned-form"><span class="arrow">Contact Us</span>→<span>All Category</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="fg-clear"></div>
                                                    <a class="remove icon-cross3"></a>
                                                </div>
                                            </div>

                                            <div class="col-md-6 nopadding agent">
                                                <div class="single-agent">
                                                    <div class="fg-left">
                                                        <img class="agent-img" src="<?php echo base_url(); ?>images/noimg.png">
                                                    </div>
                                                    <div class="detail">
                                                        <ul>
                                                            <li class="name bold">Ema ru</li>
                                                            <li class="email regular">emaru@gmail.com</li>
                                                            <li class="assigned-form"><span class="arrow">Contact Us</span>→<span>All Category</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="fg-clear"></div>
                                                    <a class="remove icon-cross3"></a>
                                                </div>
                                            </div>


                                            <div class="col-md-6 nopadding agent">
                                                <div class="single-agent">
                                                    <div class="fg-left">
                                                        <img class="agent-img" src="<?php echo base_url(); ?>images/noimg.png">
                                                    </div>
                                                    <div class="detail">
                                                        <ul>
                                                            <li class="name bold">Smith</li>
                                                            <li class="email regular">Smith@gmail.com</li>
                                                            <li class="assigned-form"><span class="arrow">Contact Us</span>→<span>All Category</span></li>
                                                            <li class="assigned-form"><span class="arrow">Feedback</span>→<span>All Category</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="fg-clear"></div>
                                                    <a class="remove icon-cross3"></a>
                                                </div>
                                            </div>


                                            <div class="col-md-6 nopadding agent">
                                                <div class="single-agent">
                                                    <div class="fg-left">
                                                        <img class="agent-img" src="<?php echo base_url(); ?>images/noimg.png">
                                                    </div>
                                                    <div class="detail">
                                                        <ul>
                                                            <li class="name bold">Keddy ty</li>
                                                            <li class="email regular">keddyty@gmail.com</li>
                                                            <li class="assigned-form"><span class="arrow">Contact Us</span>→<span>All Category</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="fg-clear"></div>
                                                    <a class="remove icon-cross3"></a>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fg-parent-box">


                            </div><!-- fg-parent-box End-->
                        </div><!-- right-section-wrapper End -->
                    </div>
                </div>

                <!-- Footer Section -->
                <div class="row">
                    <div class="main-footer">
                        <div class="link-footer">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Faqs</a></li> 
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Affiliates</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Terms &amp; Conditions and License</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="copyright-footer">
                            <p>2014 &copy; FormGet.com All rights reserved.</p>
                        </div>
                    </div>
                </div>

            </div><!-- Main wrapper closing -->
            <script src="<?php echo base_url(); ?>js/plugin.js"></script>
            <script src="<?php echo base_url(); ?>js/fg-script.js"></script>       
        </body>
       
</html>
