@extends('layouts.app')

@section('title', "Let's get started")

@section('content')
    <div class="text-center text-black space-y-4">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold">
            You're almost done!
        </h1>

        <h4 class="text-1xl md:text-3xl lg:text-4xl">
            Let's confirm that we have the correct account.
            <br>
            We've selected your 10 most recent jobs. Does this look good?
        </h4>
    </div>

    <div class="flex flex-col mt-6">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                TrucksBook Username
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                From
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                To
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cargo
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recent_jobs as $job)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $job->trucksbook_username }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $job->from }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $job->to }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $job->cargo }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="pt-6">
        <form method="POST" action="">
            @csrf

            <button type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Yes, start the transfer!
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
