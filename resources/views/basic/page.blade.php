<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 760px;
            margin: 48px auto;
            padding: 32px;
            background: #ffffff;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
        }

        h1 {
            margin-top: 0;
            color: #0f766e;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        ul {
            padding-left: 24px;
            font-size: 18px;
            line-height: 1.8;
        }

        a {
            color: #0f766e;
        }
    </style>
</head>

<body>
    <main class="container">
        <h1>{{ $title }}</h1>

        @isset($description)
            <p>{{ $description }}</p>
        @endisset

        @isset($items)
            <ul>
                @foreach ($items as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endisset
    </main>
</body>

</html>
