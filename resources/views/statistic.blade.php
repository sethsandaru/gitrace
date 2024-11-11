@extends('app')

@php
$positionColor = [
    0 => 'bg-lime-50',
    1 => 'bg-blue-50',
    2 => 'bg-yellow-50',
];
@endphp

@section('body')
    <section class="h-[100vh] ">
        <div class="relative py-16 px-4 mx-auto max-w-screen-xl lg:py-32 xl:px-0 z-1">
            <div class="mb-6 max-w-screen-md lg:mb-0 mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-12">GitRace: Summary for today {{ $today }}</h1>

                <ul role="list" class="divide-y divide-gray-100">
                    @foreach ($userContributions as $position => $userInfo)
                        <li
                            class="flex justify-between gap-x-6 py-5 px-4 rounded-xl {{ $positionColor[$position] ?? '' }}"
                        >
                            <div class="flex min-w-0 gap-x-4 items-center">
                                <h2 class="text-3xl font-bold text-gray-900 mr-4">
                                    #{{$position + 1}}
                                </h2>
                                <img class="h-16 w-16 flex-none rounded-full bg-gray-50" src="{{ $userInfo['avatarUrl'] }}" alt="">
                                <div class="min-w-0 flex-auto">
                                    <a
                                        href="{{ $userInfo['githubUrl'] }}"
                                        target="_blank"
                                        class="text-lg font-semibold text-gray-900">
                                        {{ $userInfo['username'] }}
                                    </a>
                                    <p class="mt-1 truncate text-base text-gray-700 font-medium flex items-center gap-2">
                                        Today contributions: <strong class="text-xl text-primary-600">{{ $userInfo['total'] }}</strong>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <p class="mt-6 text-sm text-gray-500">Results are cached for 10 mins</p>
            </div>
        </div>
    </section>
@endsection
