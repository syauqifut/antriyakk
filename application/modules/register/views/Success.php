<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Antriyakk Sign Up Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>
<body>

    <div class="main">
        <div class="container">
            <div class="signup-content">
                <div class="success-form">
                    <div class="success-text">
                        <h1>
                            <img src="<?= base_url() ?>assets/images/check.png" alt=""><br>
                            TERIMA KASIH
                        </h1>
                        <h3>Pendaftaran Anda telah kami terima, untuk informasi lebih lanjut Anda dapat download pdf di bawah ini atau melalui email yang kami kirimkan kepada Anda</h3><br><br>
                        <a style="border: 1px solid white; border-radius:7px; background-color:#FECD04; padding: 5px; text-decoration:none; font-size: 125%; color:black" href="<?= base_url() ?>register/pdf/<?php echo $pendaftar->id ?>">Download pdf</a><br><br>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/main.js"></script>
</body>
</html>