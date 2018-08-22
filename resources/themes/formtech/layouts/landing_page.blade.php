@extends('formtech::index')

@section('content')

    <div class="page:landing-page overflow-x-hidden">
        <div class="bg-brand-dark">
            <div class="container mx-auto grid py-16">
                <div class="w-full text-white">
                    @foreach($blocks['c1'] as $block)
                        {!! $block !!}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="">
            <div class="container mx-auto grid py-16">
                <div class="w-1/3">
                    @foreach($blocks['c2'] as $block)
                        {!! $block !!}
                    @endforeach
                </div>
                <div class="w-1/3">
                    @foreach($blocks['c3'] as $block)
                        {!! $block !!}
                    @endforeach
                </div>
                <div class="w-1/3">
                    @foreach($blocks['c4'] as $block)
                        {!! $block !!}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="">
            <div class="container mx-auto grid py-16">
                <div class="w-full">
                    @foreach($blocks['c5'] as $block)
                        {!! $block !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection