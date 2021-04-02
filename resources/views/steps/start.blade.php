@extends('layouts.app')

@section('title', "Let's get started")

@section('content')
    <div class="text-center text-black space-y-4">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold">
            Awesome, let's do this!
        </h1>

        <h4 class="text-1xl md:text-3xl lg:text-4xl">
            First of all, sign in with the Steam account connected to your PhoenixBase account.
        </h4>
    </div>

    <div class="pt-6">
        <form method="POST" action="{{ route('auth.steam') }}">
            @csrf

            <button type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Authenticate
                <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"/>
                    <path fill-rule="evenodd"
                          d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
        </form>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/exclamation -->
                        <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-700">
                            {!! $error !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
