<?php
    require_once('Dating.php');
    $hielo = new Dating();
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        {{{headtags}}}
        {{{templatedata:head}}}
    </head>
    <body>
        <header id="header">
            <div class="logo"><a href="/">Flingles</a></div>
            <a href="#menu">Menu</a>
        </header>
        <nav id="menu">
            <ul class="links">
                <li><a href="/">Home</a></li>
                <li><a href="/view/my_profile">My Profile</a></li>
            </ul>
        </nav>
        <?php $hielo->show_slider('dating_main_slider'); ?>
        <?php $hielo->show_info_blocks('dating_main_info_blocks'); ?>
        <?php $hielo->show_parallax_div('dating_main_parallax_div'); ?>
        <?php
            $xfields['form_open'] = [
                'id' => 'add_user_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $xfields['form_close'] = [];
            $xfields['fields'] = [
                'dating_profile_nickname' => [
                    'name' => 'nickname',
                    'id' => 'nickname',
                    'input_class' => 'input-group width-100',
                    'label' => 'Nickname',
                    'hint' => 'Enter at least 6 characters',
                    'placeholder' => 'Nickname',
                    'validation' => ['rules' => 'required|validate_username_unique'],
                    'value' => _choose(@$xdata['data']['posts']['nickname'], 'nickname', ''),
                    'type' => 'text'
                ],
                'dating_profile_submit' => [
                    'id' => 'submit',
                    'name' => 'submit',
                    'label' => 'Create profile',
                    'input_class' => 'btn-primary',
                    'bootstrap_row' => 'row',
                    'bootstrap_col' => 'col-sm-12'
                ]
            ];
            $xdata['messages'] = [
                'heading' => lang('dating_profile_dating_profile_add_heading'),
                'prompt' => lang('dating_profile_dating_profile_add_prompt'),
            ];
            $xdata['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to profile',
                        'link' => 'user/dating_profile/my_profile'
                    ]
                ]
            ];
        ?>
        <?php if (!empty($xdata)): ?>
        <section id="one" class="wrapper style3" style="background-image: url(/application/views/themes/dating/images/header.jpg);">
            <div class="inner">
                <div class="card">
                    <div class="p-t-0 p-l-25 p-r-25 p-b-25">
                        <?php $xdata['data']['posts'] = $this->input->post(); ?>
                        <?php echo kcms_form_fieldset($xfields); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <footer id="footer">
            <div class="container">
                <ul class="icons">
                    <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
                </ul>
            </div>
            <div class="copyright">
                &copy; <?php echo date('Y'); ?>, Flingles. All rights reserved.
            </div>
        </footer>
        {{{templatedata:body}}}
    </body>
</html>
