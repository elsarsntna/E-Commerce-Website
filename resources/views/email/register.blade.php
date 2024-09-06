<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pendaftaran Anda</title>
</head>

<body>
    <h2>Dear, {{ $customer->name }}</h2>
    <p>
        Selamat datang di ElsaEcommerce!
        <br> Kami senang menyambut Anda sebagai bagian dari komunitas kami. Terima kasih telah mendaftar.
        <br> Untuk menyelesaikan proses registrasi Anda, silakan verifikasi alamat email Anda dengan mengklik tautan di
        bawah ini:<br><br>


        <a href="{{ route('customer.verify', $customer->activate_token) }}">Verifikasi</a><br> <br>

        Sebagai informasi, berikut adalah detail akun Anda:<br> <br>

        <strong>Email: </strong>{{ $customer->email }}<br>
        <strong>Password: </strong>{{ $password }}<br>

        <br> <strong>Penting:</strong> Kami sarankan untuk merahasiakan password Anda dan tidak membagikannya kepada
        siapa pun. Kami hanya akan meminta Anda memasukkan password ini ketika Anda melakukan login di
        ElsaEcommerce.<br>
        <br> Jika Anda tidak merasa melakukan pendaftaran di ElsaEcommerce, mohon abaikan email ini. Namun, jika Anda
        mengalami kesulitan atau memiliki pertanyaan, jangan ragu untuk menghubungi tim dukungan kami di
        elsarsntna12@gmail.com atau melalui 08123456789 <br> <br>

        Terima kasih atas kepercayaan Anda kepada kami. Kami berharap Anda dapat menikmati pengalaman bersama
        ElsaEcommerce.<br>
    </p>
</body>

</html>
