@extends('formtech::index')

@section('content')

    <div class="page:landing-page overflow-x-hidden">
        <div class="">
            <div class="container mx-auto grid py-16">
                <div class="w-full">
                    @foreach($page->blocksInContainer('c1') as $block)
                        {!! $builder->buildBlock($block) !!}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="bg-grey-darkest text-secondary-inverse">
            <div class="container mx-auto grid py-16">
                <div class="w-1/3">
                    @foreach($page->blocksInContainer('c2') as $block)
                        {!! $builder->buildBlock($block) !!}
                    @endforeach
                </div>
                <div class="w-1/3">
                    @foreach($page->blocksInContainer('c3') as $block)
                        {!! $builder->buildBlock($block) !!}
                    @endforeach
                </div>
                <div class="w-1/3">
                    @foreach($page->blocksInContainer('c4') as $block)
                        {!! $builder->buildBlock($block) !!}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="">
            <div class="container mx-auto grid py-16">
                <div class="w-full">
                    @foreach($page->blocksInContainer('c5') as $block)
                        {!! $builder->buildBlock($block) !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection