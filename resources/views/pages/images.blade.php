@extends('layouts.app', ['title' => 'Images per page'])

@section('content')
    <div class="container">

        @include('layouts.titlesection', ['titular' => $page->namePage, 'showBack' => true])

        <div class="row row-cols-1 row-cols-md-6 g-2 mb-2" id="listado">
            @foreach ($page->images as $image)
                <div class="col mx-auto">
                    <div class="card h-100 shadow-sm">
                        <a href="/download/{{ $image->path_local }}" data-footer="false"
                            data-image="{{ config('app.url') }}/download/{{ $image->path_local }}" data-bs-toggle="modal"
                            data-bs-target="#myModal" title="{{ $image->path_local }}"
                            class="openModal position-absolute fs-1 pt-5 w-100 h-100 top-50 start-50 text-center translate-middle stretched-link">
                            <i class="mt-5 align-items-center fa-regular fa-image fa-2xl opacity-25"></i></a>
                        <img src="#" data-src="/download/{{ $image->path_local_thumbnail }}" class="card-img-top fade" alt="...">

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
            listado.find('img').each(function(index, value) {
                var $this = $(this)
                var dataSrc = $(this).attr('data-src');
                var divListado = $(this).parent().parent();

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

            });
        })
    </script>
@endsection
