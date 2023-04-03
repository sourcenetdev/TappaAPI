<h2>You have requested to reset your password.</h2>
<p>Hello!</p>
<p><?php echo $title; ?></p>
<p>If this was not you, do not be alarmed. Your old password will still work, and this temporary password was emailed only to the email address associated with the account you have registered with.</p>
<p>Furthermore, this temporary password is only valid for <?php echo _cfg('temp_password_validity'); ?> hours, after which it will be rendered useless. If you keep receiving this mail on a frequent basis without requesting a password change, please alert your system administrator to investigate.</p>
<p>For best results, please copy and paste the new password into the system</p>
<p>Your new password is: "<strong><?php echo $password; ?>" (Without the quotes)</strong>
<p>Click <a href="<?php echo $system_url; ?>">here</a> to view the site, or <a href="<?php echo $system_login; ?>">log in</a>.</p>
<p>Kind regards</p>
<p><strong>The <?php echo $system_name; ?> team</strong></p>