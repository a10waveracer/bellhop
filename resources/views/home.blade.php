@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    Status for this Week
                </div>

                <div class="w-full p-6">
                    <div class="">
                        @if($weeks->isEmpty())
                            <p>Well this is awkward... no one has put in values this week.</p>
                        @else
                            @foreach($weeks as $week)
                                <div class="text-center m-10 border-b-2 pb-2 text-2xl">
                                    <a href="{{$week->url}}">{{$week->user->name}}</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
