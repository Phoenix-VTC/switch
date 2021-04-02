@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="text-center text-black space-y-4">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold">
            Welcome to Phoenix Switch, {{ Auth::user()->username }}!
        </h1>

        <h4 class="text-1xl md:text-3xl lg:text-4xl">
            Now, let's configure your TrucksBook account.
        </h4>
    </div>

    <div class="bg-gray-50 shadow overflow-hidden sm:rounded-md mt-6">
        <ul class="divide-y divide-gray-200">
            <li class="px-4 py-4 sm:px-6">
                <h1 class="text-2xl font-bold">Step 1.</h1>

                <p class="prose">
                    Head over to your TrucksBook account settings page:
                    <a href="https://trucksbook.eu/settings" target="_blank">https://trucksbook.eu/settings</a>
                </p>
            </li>

            <li class="px-4 py-4 sm:px-6">
                <h1 class="text-2xl font-bold">Step 2.</h1>

                <p class="prose">
                    Open the <b>Profile Data</b> tab, and paste the following value in the <b>Description</b> field:
                    <br>
                    <span class="bg-red-200 px-3">{{ $identifier }}</span>
                    <br>
                    After this, make sure to press save.
                </p>
            </li>

            <li class="px-4 py-4 sm:px-6">
                <h1 class="text-2xl font-bold">Step 3.</h1>

                <p class="prose">
                    At the top right of the TrucksBook page, click on your username and then <b>My Profile</b>.
                    <br>
                    Just above your profile picture, you should see your User Profile ID. This will be something like <b>User Profile #214478</b>.
                    <br><br>
                    Copy the string of numbers after <b>#</b>, and paste them in the input field below.
                </p>
            </li>
        </ul>
    </div>

    <div class="text-center">
        <form method="POST" action="{{ route('steps.find-trucksbook-account') }}" class="space-y-4">
            @csrf

            <div class="py-4 space-y-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">
                        TrucksBook User Profile ID
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">
                            #
                        </span>
                        </div>
                        <input type="number" name="user_id" id="user_id" min="1" value="{{ old('user_id') }}" required
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-6 sm:text-sm border-gray-300 rounded-md"
                               placeholder="214478">
                    </div>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">
                        TrucksBook Username
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">
                            Phoenix
                        </span>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="Your Username" style="padding-left: 4.3rem">
                    </div>
                </div>
            </div>


            <button type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Continue
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
                        <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                  clip-rule="evenodd"/>
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
