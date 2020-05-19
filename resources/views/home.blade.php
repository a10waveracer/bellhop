@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
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
                                <div class="" style="margin-bottom:15px">
                                    <a href="{{$week->url}}" target="_blank">
                                        <div class="md:mx-auto max-w-sm rounded overflow-hidden shadow-lg"
                                             style="cursor:pointer; border-radius:15px;">
                                            <img id="{{$week->user->name}}_img" class="w-full"
                                                 src=""
                                                 alt="" style="object-fit:cover">
                                            <div class="px-6 py-4">
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    Last updated: {{$week->lastUpdated}}
                                                </p>
                                                <div class="font-bold text-xl mb-2"
                                                     style="margin-top:10px;">{{$week->user->name}}</div>
                                                <p id="{{$week->user->name}}_pattern" class="text-gray-700 text-base"
                                                   style="padding-bottom:0">-- -- --</p>
                                            </div>
                                            <div class="px-6 py-4" style="padding-top:0">
                                                <span id="{{$week->user->name}}_price_max"
                                                      class="text-gray-900 inline-block px-3 py-1 text-sm font-semibold text-gray-700 mr-2">-- -- --</span>
                                                <span id="{{$week->user->name}}_price_min"
                                                      class="text-gray-600 inline-block px-3 py-1 text-sm font-semibold text-gray-700 mr-2">-- -- --</span>
                                                <span id="{{$week->user->name}}_price_now"
                                                      class="text-gray-300 inline-block px-3 py-1 text-sm font-semibold text-gray-700 mr-2">-- -- --</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="stalk-data" style="display:none">
                                        <div class="user">{{$week->user->name}}</div>
                                        <div class="prices">{{$week->prices}}</div>
                                        <div class="timezone">{{$week->user->timezone}}</div>
                                        <div class="first_buy">{{$week->first_buy}}</div>
                                        <div class="previous_trend">{{$week->previous_trend}}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
