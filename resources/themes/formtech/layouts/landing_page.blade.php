@extends('formtech::index')

@section('content')

    <div class="overflow-x-hidden">
        <div class="grid">
            @foreach($blocks['c1'] as $block)
                {!! $block !!}
            @endforeach
        </div>
        <div class="grid">
            <div class="w-1/3">

            </div>
            <div class="w-1/3">

            </div>
            <div class="w-1/3">

            </div>
        </div>
        <div class="grid">
            <div>

            </div>
        </div>
    </div>

@endsection