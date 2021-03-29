@extends('layouts.base')

@section('body')
    <div x-data="{ showInfoModal: false }">
        <div class="fixed h-full w-full flex flex-col items-center justify-center z-10">
            <div class="flex flex-col h-screen justify-center items-center">
                @yield('content')

                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>

            <div class="bottom-0 pb-6">
                <a class="text-sm cursor-pointer" @click="showInfoModal = true">Not sure what this is?</a>
            </div>
        </div>

        <!-- Info Modal -->
        <div @keydown.window.escape="showInfoModal = false"
             x-show="showInfoModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
             x-ref="dialog" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div x-show="showInfoModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showInfoModal = false"
                     aria-hidden="true"></div>


                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showInfoModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                About Phoenix Switch
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    This website will help drivers migrate their jobs from TrucksBook to the
                                    PhoenixBase.
                                    <br><br>
                                    If you're not a PhoenixVTC member, you probably ended up on the wrong website.
                                    <br>
                                    If you're looking to apply, please click <a class="font-bold"
                                                                                href="https://phoenixvtc.com/en/apply">here</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button"
                                class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm"
                                @click="showInfoModal = false">
                            Okay, thanks!
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animated Background -->
        <x-animated-background/>
    </div>
@endsection
