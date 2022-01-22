<?php

$sendgrid_api_key = get_option('SENDGRID_API_KEY');
$change_api_key = filter_input(INPUT_GET, 'change_api_key', FILTER_SANITIZE_SPECIAL_CHARS);

$sendgrid_ip = filter_input(INPUT_POST, 'SENDGRID_IP', FILTER_VALIDATE_IP);

if ($sendgrid_ip) {
  $whitelisted = \RSWpSendgrid\WpSendgridApiAdmin::whitelistIP($sendgrid_ip);
}
?>
<div class="wrap">
	<h1>SendGrid API</h1>

  <hr />
  <?php if (empty($sendgrid_api_key) || !empty($change_api_key)): ?>
  <form method="post" action="options.php">
    <?php
      settings_fields('wpsendgridapi');
      do_settings_sections('wpsendgridapi');
      submit_button();
    ?>
  </form>
  <?php else: ?>
    <label for="SENDGRID_API_KEY">SENDGRID API KEY</label>
    <input type="text" disabled value="<?= $sendgrid_api_key; ?>" />
    <a href="<?php echo admin_url('options-general.php?page=wpsendgridapi&change_api_key=1'); ?>">Change API KEY</a>
  <hr />
  <h3>Whitelist your IP address</h3>
  <form method="post" action="<?php echo admin_url('options-general.php?page=wpsendgridapi'); ?>">
    <label for="SENDGRID_IP">Enter IP address:</label>
    <input type="text" name="SENDGRID_IP" />
    <?php submit_button(); ?>
  </form>
  <?php endif; ?>
</div>