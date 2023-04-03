<?php
    $images = [
        'error_bg_1',
        'error_bg_2',
        'error_bg_3',
        'error_bg_4',
        'error_bg_5',
        'error_bg_6',
        'error_bg_7',
    ];
    $which = rand(0, 6);
    $img = $images[$which];
?>
<!doctype html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=News+Cycle|Raleway&display=swap" rel="stylesheet">
        <style>
            #error-background {
                background: url('../../application/views/errors/html/images/<?php echo $img; ?>.jpg');
                background-size: cover;
                position: fixed;
                height: 100%;
                width: 100%;
            }
            #error-content {
                background-color: #ffffff;
                opacity: 0.85;
                border: 4px solid #00cc00;
                border-radius: 48px;
                padding: 24px;
                font-family: Arial, sans-serif;
                margin: 32px auto;
                width: 720px;
            }
            #error-content p {
                color: #333333;
                font-size: 14px;
                text-align: left;
            }
            #error-content h2 {
                margin: 32px 0;
                color: #00cc00 !important;
                font-size: 20px;
                font-style: italic;
                text-align: center;
                font-family: 'News Cycle', cursive;
                font-size: 18px;
            }
            #error-content h1 {
                font-family: 'News Cycle', cursive;
                font-size: 24px;
                font-style: italic;
                color: #00cc00;
                text-align: center;
            }
            span.error_key {
                font-weight: bold;
                text-transform: uppercase;
                font-family: 'Raleway', sans-serif;
                font-size: 14px;
            }
            span.error_val {
                font-weight: normal;
                font-family: Arial, sans-serif;
                font-size: 13px;
            }
            body {
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
        <div id="error-background">
            <div id="error-content">
                <h1><?php echo $heading; ?></h1>
                <p><?php echo $error; ?></p>
                <h2>But please do not be concerned. We have it under control.</h2>
            </div>
        </div>
    </body>
</html>