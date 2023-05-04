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
                <div class="signup-img">
                    <img src="<?= base_url() ?>assets/images/reg-img.jpg" alt="" >
                </div>
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form" action="<?= base_url('Register/store') ?>" enctype="multipart/form-data">
                        <h2>formulir pendaftaran diri</h2>
                        <?php if ($this->session->flashdata('pesan')!=null):?><h3 style="background-color: #D9534F; color:white; padding:10px; border:1px solid #C9302C; border-radius:10px"><?=$this->session->flashdata('pesan');?></h3> <?php endif?>
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" name="nama" id="name" required/>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat :</label>
                            <input type="text" name="alamat" id="alamat" required/>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nohp">Nomor HP :</label>
                                <input type="number" name="nohp" id="nohp" required/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email :</label>
                                <input type="email" name="email" id="email" required/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nik">NIK :</label>
                                <input type="number" name="nik" id="nik" required/>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir :</label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir" required/>
                            </div>
                        </div>
                        
                        <div class="form-radio">
                            <label for="jk" class="radio-label">Jenis Kelamin :</label>
                            <div class="form-radio-item">
                                <input type="radio" name="jk" id="male" value="m" checked>
                                <label for="male">Laki-laki</label>
                                <span class="check"></span>
                            </div>
                            <div class="form-radio-item">
                                <input type="radio" name="jk" id="female" value="f">
                                <label for="female">Perempuan</label>
                                <span class="check"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file_ktp">Foto KTP :</label>
                            <input type="file" name="file_ktp" id="file_ktp" required/>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="tgl_periksa" id="tgl_periksa" required/>
                            <input type="hidden" name="no_antrian" id="no_antrian" value="<?= $antrian +1 ?>" required/>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="jenisperiksa">Jenis Periksa :</label>
                                <div class="form-select">
                                    <select name="jenisperiksa" id="jenisperiksa">
                                        <option value selected disabled></option>
                                        <option value="1">PCR SWAB</option>
                                        <option value="2">PCR ANTIGEN</option>
                                        <option value="3">RAPID ANTIGEN</option>
                                    </select>
                                    <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pembayaran">Pembayaran :</label>
                                <div class="form-select">
                                    <select name="pembayaran" id="pembayaran" onchange="pembFunction()">
                                        <option value selected disabled></option>
                                        <option value="1">TUNAI</option>
                                        <option value="2">DEBIT</option>
                                        <option value="3">CREDIT CARD</option>
                                        <option value="4">LAINNYA</option>
                                    </select>
                                    <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group" id="pemblainform" style="display:none">
                            <label for="pemblain">Pembayaran Lainnya :</label>
                            <input type="text" name="pemblain" id="pemblain"/>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Submit Form" class="submit" name="submit" id="submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script>
    //Pembayaran lainnya
    function pembFunction() {
        var x = document.getElementById("pembayaran").value;
        if(x==4){
            document.getElementById("pemblainform").style.display = 'inline';
        }
        else{
            document.getElementById("pemblainform").style.display = 'none';
        }
    }

    //Max(tanggal lahir) & min(tanggalperiksa)
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("tgl_lahir").setAttribute("max", today);
    document.getElementById("tgl_periksa").setAttribute("value", today);
    </script>
    
</body>
</html>