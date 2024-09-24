<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>
<body>
<header>
    <h1>Выбранный город: {{ $selectedCitySlug ? ucfirst($selectedCitySlug) : 'Не выбран' }}</h1>
</header>

<main>
    <h2>Список городов</h2>
    <ul>
        @foreach ($cities as $city)
            <li>
                <a href="{{ route('cities.show', $city->slug) }}">{{ ucfirst($city->name) }}</a>
            </li>
        @endforeach
    </ul>
</main>
</body>
</html>
