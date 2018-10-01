<div id="block-{{ $block->id}} "
     class="block-container gallery-block">

    <div class="header mb-8">
        {{ $block->getData('heading') }}
    </div>

    <div class="flex flex-wrap justify-center -m-3">
        @foreach($block->images as $image)

            <div class="p-3 flex-1">
                <img src="{{ $image->media->url() }}"/>
            </div>

        @endforeach
    </div>

    <div>
        {{ $block->getData('description') }}
    </div>

</div>