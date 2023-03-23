<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/x-icon" href="img/fixed/favicon.png">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="wrap-all">
        <div class="wrap-background">
            <img src="https://t3.ftcdn.net/jpg/02/81/48/32/360_F_281483212_fafo0892wj9fOuR6V3NOLMuXkMSWVNJ1.jpg" alt="">
        </div>
        <div class="filter-blur"></div>
        <div class="wrap-login">
            <div class="top">
                <img src="img/fixed/login.png" alt="login">
            </div>
            <div class="main">
                <form action="" method="post">
                    <div class="field-item">
                        <div class="icon"><i class="fa-solid fa-user"></i></div>
                        <input type="text" placeholder="Email Identifier" required>
                    </div>
                    <div class="field-item">
                        <div class="icon"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" placeholder="Password" required>
                    </div>
                </form>
            </div>
            <div class="bottom">
                <div class="login-submit" id="submit-login-form">
                    <div>LOGIN</div>
                    <div class="icon-login"><i class="fa-solid fa-right-to-bracket"></i></div>
                </div>
                <div class="login-submit" id="submit-login-face">
                    <div>FACE LOGIN</div>
                    <div class="icon-login"><i class="fa-sharp fa-solid fa-face-smile"></i></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>