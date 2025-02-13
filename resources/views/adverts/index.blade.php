

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все товары</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{asset('images/Group 438.png')}}" type="image/x-icon">
</head>
<body class="font-sans flex flex-col items-center">

@include('components.header-seller')   
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script> 
<!-- Рекламный баннер -->
<div class="w-full md:w-3/4 mx-auto">
    <h1 class="hidden md:block"></h1>
    <img src="{{ asset('images/banner.png') }}" alt="Реклама" class="banner w-full rounded-2xl hidden md:block mt-28">
    <p class="hidden md:block"></p>
</div>

<div class="w-full md:w-3/4 mx-auto">
    <h2 class="text-2xl font-bold mt-8 mb-4 text-center">Поиск запчастей:</h2>
    @include('components.search-form')  
</div>

<div class="w-full md:w-3/4 mx-auto">
    @if($adverts->isEmpty())
        <p class="text-center text-lg mt-8">Нет доступных объявлений.</p>
    @else
        @php
            // Фильтруем коллекцию, исключая товар с id 1111
            $filteredAdverts = $adverts->reject(function($advert) {
                return $advert->id == 1111;
            });
        @endphp

        <!-- Для телефонов -->
        <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 sm:hidden">
            @foreach($filteredAdverts as $advert)
            <div class="bg-white rounded-lg shadow p-4" onclick="location.href='{{ route('adverts.show', $advert->id) }}'">
                <div class="relative">
                    @if ($advert->main_photo_url)
                        <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="w-full h-48 object-cover rounded-lg">
                    @else
                        <img src="{{ asset('images/dontfoto.jpg') }}" alt="Фото отсутствует" class="w-full h-48 object-cover rounded-lg">
                    @endif
                    <span class="absolute top-2 right-2 bg-[#FFE6C1] text-black text-xs font-normal px-2 py-1 rounded">
                        В наличии
                    </span>
                </div>
                <div class="mt-4">
                    <div class="text-lg font-bold">
                        {{ $advert->product_name }}
                    </div>
                    <div class="text-xl text-black font-semibold">
                        {{ $advert->price }} ₽
                    </div>
                    <div class="flex flex-wrap text-gray-500 text-sm mt-2">
                        <i class="fas fa-car mr-2"></i>
                        <span>{{ $advert->brand }}</span>
                        <span class="mx-1">|</span>
                        <span>{{ $advert->model }}</span>
                        <span class="mx-1">|</span>
                        <span>{{ $advert->year }}</span>
                    </div>
                    <div class="text-red-500 font-semibold mt-2">
                        {{ $advert->user->userAddress->city ?? 'Не указан' }}
                    </div>
                    <div class="text-gray-500 text-sm">
                        сегодня в 12:00
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Для больших и средних экранов -->
        <div class="hidden sm:flex w-full flex-col items-start justify-center">
            @foreach($filteredAdverts as $advert)
            <div class="bg-white rounded-lg shadow-md flex max-w-5xl w-full p-4 mt-8 cursor-pointer transition-colors duration-300 hover:bg-[#D8EAFF]" onclick="location.href='{{ route('adverts.show', $advert->id) }}'" tabindex="0" role="button">
                <!-- Вывод главного фото -->
                <div class="w-1/5 h-40 flex-shrink-0">
                    @if ($advert->main_photo_url)
                        <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="rounded-lg w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/dontfoto.jpg') }}" alt="Фото отсутствует" class="rounded-lg w-full h-full object-cover">
                    @endif
                </div>
            
                <div class="flex flex-col justify-between w-4/5 pl-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $advert->product_name }}</h2>
                            <p class="beg bg-gray-200 px-3 py-1 w-24 text-sm rounded-lg text-center">{{ $advert->number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-semibold">{{ $advert->price }} ₽</p>
                            <p class="text-red-500">{{ $advert->user->userAddress->city ?? 'Не указан' }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 mt-4 w-full justify-around">
                        <span class="bg-[#FFE6C1] text-black text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->brand }}</span>
                        <span class="bg-[#FFE6C1] text-black text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->model }}</span>
                        <span class="bg-[#FFE6C1] text-black text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->body }}</span>
                        <span class="bg-[#FFE6C1] text-black text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->engine }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="h-24">
            @include('components.pagination', ['adverts' => $adverts])
        </div>
    @endif
</div>
</body>
</html>