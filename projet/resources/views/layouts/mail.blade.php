<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentMatcher' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ea530c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .btn-primary:hover {
            background-color: #d44a0b;
        }
        h1 {
            color: #ea530c;
            margin-bottom: 20px;
        }
        ul {
            list-style-position: inside;
            margin: 15px 0;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            color: #ea530c;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>