<title>Setup Password - <?php echo $this->config->item('web_name'); ?></title>
<style>
.footer {
    display: none;
}
</style>
<script>
$(function() {
    var form = $(".login-form");
    form.css({
        opacity: 1,
        "-webkit-transform": "scale(1)",
        "transform": "scale(1)",
        "-webkit-transition": ".5s",
        "transition": ".5s"
    });
});
</script>
</head>
<body>
<body class="bg-darkTeal">
<div class="login-form padding20 block-shadow">
    <?php echo form_open($this->uri->uri_string()); ?>
        <h1 class="text-light">Setup Password</h1>
        <hr class="thin">
        <br>
		<?php if (validation_errors() || !empty($errors)): ?>
			<div class="padding10 bg-red fg-white text-accent">
				<?php echo validation_errors(); ?>
				<?php echo (!empty($errors)?$errors:NULL); ?>
			</div>
			<br>
		<?php endif ?>
        <div class="input-control text full-size" data-role="input">
            <label for="password">Password</label>
            <?php echo form_password('password', set_value('password'), 'placeholder="Your Password"'); ?>
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br>
        <br>
        <div class="input-control password full-size" data-role="input">
            <label for="passconf">Password Confirmation</label>
            <?php echo form_password('passconf', '', 'placeholder="Your Password Confirmation"'); ?>
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br>
        <br>
        <div class="form-actions">
            <div class="fc">
                <button type="submit" class="button primary">Setup Password</button>
                <hr class="thin">
                <a href="<?php echo base_url('auth/sign_up'); ?>" class="button success"><span class="mif-user-plus"></span> Sign Up</a>
                <a style="margin-top: 5px;" href="<?php echo base_url('log/in'); ?>" class="button success"><span class="mif-enter"></span> Log In</a>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>