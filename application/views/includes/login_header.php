<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$uid = 7;
if ($uid) {
  //  $custom_style = $this->inkdesk_model->options_select($uid, 'result');
}
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
define('BASE_URL', 'http://www.formget.com');
$c_url = $_SERVER['REQUEST_URI'];
//include('api/constant.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title>Login</title>

<!--            <link rel="stylesheet" href="<?php //echo base_url(); ?>app_data/css/style.css" />-->
            <link rel="stylesheet" href="<?php echo base_url(); ?>css/login_style.css" />
            <script>base_url = "<?php echo base_url() ?>";</script>
            <?php if (!strpos($c_url, 'analytic/stats')) { ?>
                <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
                <script src="<?php echo base_url(); ?>js/jquery.form.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tipsy.js"></script>
            <?php } ?>
            <script type="text/javascript">
                //Tipsy              
                $(function() {
                    $('.field_desc').tipsy({gravity: 's'});
                });
            </script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.js"></script>
           
            <script type="text/javascript" src= "<?php echo base_url(); ?>js/ddsmoothmenu.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/custom.js"></script>
            <script type="text/javascript" src= "<?php echo base_url(); ?>js/jquery-ui.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.json-1.3.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
             <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
              <script type="text/javascript" src="<?php echo base_url(); ?>js/form_validator.js"></script>
          
            <style>
<?php
if (isset($custom_style[0]->value) && $custom_style[0]->value != '') {
    echo $custom_style[0]->value;
}
?>
            </style>

    </head>
    <body>
