@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="text-center text-black space-y-4">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold">
            Hooray, you made it! 🎉
        </h1>

        <h1 class="text-2xl md:text-4xl lg:text-5xl">
            It's time to get you settled into our custom job logging system.
        </h1>
    </div>

    <div class="pt-6">
        <a href="#"
           class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Let's do this!
            <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"/>
                <path fill-rule="evenodd"
                      d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"/>
            </svg>
        </a>
    </div>
@endsection
