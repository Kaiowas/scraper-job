@extends('layouts.app', ['title' => 'show All Images'])

@section('content')
    <div class="container">

        @include('layouts.titlesection', ['titular' => 'show All Images', 'showBack' => true])
        {{ $images->links() }}
        <div class="row row-cols-1 row-cols-md-6 g-2 mb-2" id="listado">
            @foreach ($images as $image)
                <div class="col mx-auto">
                    <div class="card h-1001 shadow-sm">
                        <a href="/storage/download/{{ $image->path_local }}" data-footer="false"
                            data-image="{{ config('app.asset_url') }}storage/download/{{ $image->path_local }}" data-bs-toggle="modal"
                            data-bs-target="#myModal" title="{{ $image->path_local }}"
                            class="openModal position-absolute fs-1 pt-3 w-100 h-100 top-50 start-50 text-center translate-middle stretched-link">
                            <i class="mt-5 align-items-center fa-regular fa-image fa-sm opacity-50"></i></a>
                        <img src="#" data-pageid="{{ $image->page_id }}"
                            data-src="/storage/download/{{ $image->path_local_thumbnail }}" class="card-img fade h-25 w-50 mx-auto"
                            alt="...">

                        <div class="card-footer justify-content-between d-flex small align-items-center">
                            <small class="text-body-secondary lh-sm">
                                {{ $image->created_at->format('d/m/Y') }}</small>
                            <small class="text-body-secondary lh-sm">{{ $image->updated_at->format('d/m/Y') }}</small>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>


    </div>
@endsection
@section('js')
    <script type="module">
        $(function() {
            var listado = $('html body div#listado')

            function randomHexColor(pageId) {
                return '#' + Math.floor(Math.random() * 16777215).toString(16)
            }

            listado.find('img').each(function(index, value) {
                var $this = $(this)
                var dataSrc = $(this).attr('data-src');
                var dataPageId = $(this).data('pageid')
                var divListado = $(this).parent().parent();

                var getColor = randomHexColor(dataPageId);
                var img = new Image();

                //$(img).on('load', function() {
                img.onload = function() {
                    setTimeout(() => {
                        $this.addClass('show')

                    }, 200);
                };

                img.src = dataSrc;

                $(this).attr('src', dataSrc);
                $(this).removeAttr("data-src");
                //divListado.css({"background-color": getColor});
            });
        })
    </script>
@endsection
