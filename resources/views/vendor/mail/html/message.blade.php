<x-mail::layout>
    <x-slot:header>
        <x-mail::header :url="config('app.url')">
            A.R.T.S.P
        </x-mail::header>
    </x-slot:header>

    {!! (string) $slot !!}

    @isset($subcopy)
        <x-slot:subcopy>
            <x-mail::subcopy>
                {!! (string) $subcopy !!}
            </x-mail::subcopy>
        </x-slot:subcopy>
    @endisset

    <x-slot:footer>
        <x-mail::footer>
            © {{ date('Y') }} Automotive Resource & Technical Service Platform (A.R.T.S.P). All rights reserved.
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>