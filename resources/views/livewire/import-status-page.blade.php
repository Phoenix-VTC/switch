{{-- Close your eyes. Count to one. That is how long forever feels. --}}

<div class="flex flex-col h-screen justify-center items-center" wire:poll>
    <div class="text-center text-black space-y-4">

        <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold">
            @if(!$import->failed)
                Nice work, {{ Auth::user()->username }}!
            @else
                Well, this is awkward...
            @endif
        </h1>

        <h4 class="text-1xl md:text-3xl lg:text-4xl">
            @if(!$import->completed && !$import->failed)
                Now we'll let Kenji perform some magic.
            @elseif($import->completed)
                Kenji has successfully performed his magic show!
            @elseif($import->failed)
                It looks like Kenji did an oopsie.
            @endif
        </h4>
    </div>

    @if(!$import->failed)
        @switch($import->completed)
            @case(false)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/information-circle -->
                        <svg class="h-6 w-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700">
                            <strong>
                                We're currently processing your Switch request.
                            </strong>
                            <br><br>
                            Feel free to keep this page open, this should only take a few seconds.
                            <br>
                            We will let you know on this page if anything changes!
                        </p>
                    </div>
                </div>
            </div>
            @break
            @case(true)
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/check-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700">
                            <strong>
                                We've successfully imported your jobs!
                            </strong>
                            <br><br>
                            All your jobs have successfully been <i>switched</i> over to the PhoenixBase, and you're
                            ready
                            to start logging new jobs!
                            <br>
                            Feel free to close this page.
                        </p>
                    </div>
                </div>
            </div>
            @break
        @endswitch

        @if($import->completed)
            <div class="pt-6">
                <a href="https://base.phoenixvtc.com"
                   class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Go to PhoenixBase
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
        @endif
    @endif

    @if($import->failed)
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
                        <strong>
                            Something went wrong while trying to import your jobs.
                        </strong>
                        <br><br>
                        Our Development Team has been notified about this issue.
                        <br>
                        Additionally, please reach out to us in the
                        <a class='font-medium underline text-red-700 hover:text-red-600'
                           href='https://discord.gg/PhoenixVTC' target='_blank'>#member-support channel on Discord</a>.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
