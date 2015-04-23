<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css" media="screen">

    <!--  Fluid Grid System -->
    <!--<link rel="stylesheet" href="/assets/css/fluid.css" media="screen">-->

    <!-- Login Stylesheet -->
    <link rel="stylesheet" href="/assets/css/form.css" media="screen">
    <link rel="stylesheet" href="/assets/css/login.css" media="screen">
    <link rel="stylesheet" href="/assets/plugins/zocial/zocial.css" media="screen">

    <title>Subianto & Siane</title>

</head>

<body>

<div id="da-home-wrap">
    <div id="da-home-wrap-inner">
        <div id="da-home-inner">
            <div id="da-home-box">
                <div id="da-home-box-header">
                    <span class="da-home-box-title">Login</span>
                </div>
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'da-login-username',
	'placeholder' => 'Username',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = '';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'da-login-password',
	'placeholder' => 'Password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
	<div class="da-form-row">
        <div class=" da-home-form-big">
		<td><?php echo form_label($login_label, $login['id']); ?></td>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
		</div>
	</tr>
</table>
</br>
<table>
	<tr>
        <div class=" da-home-form-big">
		<td><?php echo form_label('', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
		</div>
	</tr>
    </div>
	<?php if ($show_captcha) {
		if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="3">
			<p>Enter the code exactly as it appears:</p>
			<?php echo $captcha_html; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
		<td><?php echo form_input($captcha); ?></td>
		<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
	</tr>
	<?php }
	} ?>

	<tr>
	<div class=" da-home-form-big">
		<td colspan="3">
			&nbsp;&nbsp;<?php echo form_checkbox($remember); ?>
			<?php echo form_label('Remember me', $remember['id']); ?>
		</td>
	</div>
	</tr>
</table>
<div class="da-home-form-btn-big">
                        <input type="submit" value="Login" id="da-login-submit" class="btn btn-danger btn-block">
                    </div>
<?php echo form_close(); ?>
</div>
        </div>
    </div>
</div>

<!-- JS Libs -->
<script src="/assets/js/libs/jquery-1.8.3.min.js"></script>
<script src="/assets/js/libs/jquery.placeholder.min.js"></script>
<script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>

<!-- JS Login -->
<script src="/assets/js/core/dandelion.login.js"></script>

</body>
</html>