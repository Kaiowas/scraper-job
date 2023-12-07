@extends('layouts.app', ['title' => 'List of routes'])

@section('content')
    <div class="container">

        @include('layouts.titlesection', ['titular' => 'Listando routes', 'showBack' => true])

        <div class="btn-group button-group-sm ms-auto text-end me-0 d-block">
            <a href="{{route('runPagesJob')}}" target="_blank" class="btn btn-warning btn-sm ms-auto">run Pages Job</a>
            <a href="{{route('runImagesJob')}}" target="_blank" class="btn btn-danger btn-sm">run Images Job</a>
        </div>

        <div class="accordion w-50 mx-auto shadow rounded" id="accordionExample">
            @foreach ($routes as $route)
                @php
                    $idx = "collapse{$loop->iteration}";
                    $params = implode(' | ', $route['params']);
                @endphp

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold @if (!$loop->first) collapsed @endif"
                            type="button" data-bs-toggle="collapse" data-bs-target="#{{ $idx }}" aria-expanded="true"
                            aria-controls="{{ $idx }}">
                            {{ $route['title'] }}
                        </button>
                    </h2>
                    <div id="{{ $idx }}"
                        class="accordion-collapse collapse @if ($loop->first) show @endif"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>{{ $route['description'] }}</p>
                            <ul class="list-group text-uppercase1 w-75 mx-auto lh-sm">
                                <li class="list-group-item d-flex justify-content-center align-items-center">
                                    <a href="{{ $route['endpoint'] }}" target="_blank"
                                        class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ $route['endpoint'] }}</a>

                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center text-uppercase fw-bold">
                                     <span>method</span>
                                    <span class="badge bg-primary rounded-pill">{{ $route['method'] }}</span>
                                </li>
                                @if(count($route['params'])>0)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center text-uppercase fw-bold">
                                     <span>params</span>
                                    <span class="badge bg-primary rounded-pill">{{ $params }}</span>
                                </li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
