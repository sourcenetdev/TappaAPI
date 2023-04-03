<h2><?php echo $title; ?></h2>
<p>Hello, <?php $name; ?></p>
<p>Welcome to the <?php echo $system_name; ?> system! You have been registered as a user.</p>
<p>Please save your username and password for future reference:</p>
<p>
    <strong>Username: </strong><?php echo $username; ?><br />
    <strong>Password: </strong><?php echo $password; ?>
</p>
<?php if (isset($toactivate) && $toactivate == 1): ?>
    <p>Click <a href="<?php echo $system_url; ?>">here</a> to view the site, or <a href="<?php echo $activate_url; ?>">activate your account</a>.</p>
<?php else: ?>
    <p>Click <a href="<?php echo $system_url; ?>">here</a> to view the site, or <a href="<?php echo $system_login; ?>">log in</a>.</p>
<?php endif; ?>
<p>Kind regards</p>
<p><strong>The <?php echo $system_name; ?> team</strong></p>
