@extends('layouts.app',['title'=>'List of pages'])

@section('content')
<div class="container">

    @include('layouts.titlesection',['titular'=>'Listando carpetas','showBack'=>false])

    <div class="row row-cols-1 row-cols-md-6 g-2 mb-2">
        @foreach ($pages as $page)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="position-absolute top-50 start-50 translate-middle fw-bold fs-2 opacity-25">( {{$page->images_count}} )</div>
              <div class="card-body text-center">
                <h5 class="card-title text-center fw-bold mb-3 h6 small text-truncate">{{$page->namePage}} </h5>
                <p class="card-text d-none"></p>
                <a href="{{route('page.show',['page'=>$page->id])}}" title="{{$page->namePage}}" class="fs-1 text-warning text-center stretched-link"><i class="fa-solid fa-folder fa-2xl"></i></a>
              </div>
              <div class="card-footer justify-content-between d-flex small align-items-center">
                <small class="text-body-secondary lh-sm">
                     {{$page->created_at->format('d/m/Y')}}</small>
                     <small class="text-body-secondary lh-sm">{{$page->updated_at->format('d/m/Y')}}</small>
              </div>

            </div>
          </div>
        @endforeach

    </div>
    {{ $pages->links() }}


</div>
@endsection
