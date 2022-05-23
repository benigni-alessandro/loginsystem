<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h2>[*] Ciao {{$name}}, Benvenuto!!!</h2>
    <p>[*] Per confermare il tuo account clicca sul seguente link: </p>
    <a href="{{ url ('register/verify/' . $code_confirmation) }}">{{ url ('register/verify/' . $code_confirmation) }}</a>
</body>
</html>