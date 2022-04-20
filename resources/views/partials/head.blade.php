<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<link href="https://unpkg.com/tabulator-tables@5.1.8/dist/css/tabulator.min.css" rel="stylesheet">


<script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
<!-- js xlsx style -->
<script type="text/javascript" src="{{ URL::asset('dist/xlsx.bundle.js') }}"></script>


<!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<!-- Scripts -- Check 'defer' -->
<script src="{{ mix('js/app.js') }}" defer></script>

