@extends('layouts.app',['title'=>'Short Urls'])

@section('content')
<div class="container">

    @include('layouts.titlesection',['titular'=>'Short Urls','showBack'=>true])

    <div class="d-flex1 text-end flex-column justify-content-end align-items-center mt-0">
    <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa-solid fa-link me-2"></i>Add Short Url
      </button>

      <div class="collapse" id="collapseExample">

        <div class="pt-4">
            <form method="POST" action="{{route('shorts.store')}}" id="addShortUrlForm" class="w-50 mx-auto mt-0 shadow-sm bg-secondary rounded bg-opacity-25">
                @csrf
                <div class="container">
                    <div class="row pb-3 g-3">

                        <div class="col-8">
                            <div class="my-0">
                                <label for="url" class="form-label d-none">URL</label>
                                <div class="input-group input-group-sm">
                                  <span class="input-group-text" id="basic-addon3">* URL</span>
                                  <input required type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url" aria-describedby="basic-addon3 basic-addon4" value="{{ old('url') }}">
                                </div>
                                <div class="form-text" id="basic-addon4">Destination URL.</div>
                              </div>
                        </div>
                        <div class="col-4">
                            <div class="my-0">
                                <label for="key" class="form-label d-none">key</label>
                                <div class="input-group input-group-sm">
                                  <input type="text" class="form-control text-center @error('key') is-invalid @enderror" id="key" name="key" aria-describedby="basic-addon3 basic-addon4" value="{{ old('key') }}">
                                  <span class="input-group-text" id="basic-limit">key</span>

                                </div>
                                <div class="form-text text-end" id="basic-addon4">Custom path.</div>
                              </div>
                        </div>


                        <div class="col-12 d-grid gap-2">
                            <button type="submit" class="btn btn-primary text-uppercase fw-bold"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar</button>
                          </div>

                    </div>
                </div>


            </form>
        </div>
      </div>
    </div>
    <div class="table-responsive mt-3">
    <table class="table table-secondary table-hover align-middle table-sm table-striped-columns text-center">
        <thead class="table-dark">
          <tr class="text-uppercase">
            <th scope="col">id</th>
            <th scope="col">destination</th>
            <th scope="col">key</th>
            <th scope="col">short url</th>
            <th scope="col">visits</th>
            <th scope="col">created at</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($data as $item)
            @if($item->visits->count()>0)
            @php $visitsTable = ""; @endphp
            @foreach ($item->visits as $visit)
            @php $visitsTable .= "<ul class='list-group'>
                <li class='list-group-item d-flex justify-content-between align-items-center'>id<span class='badge bg-primary rounded-pill'>{$visit->id}</span></li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>ip<span class='badge bg-primary rounded-pill'>{$visit->ip_address}</span></li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>os<span class='badge bg-primary rounded-pill'>{$visit->operating_system}</span></li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>browser<span class='badge bg-primary rounded-pill'>{$visit->browser}</span></li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>device<span class='badge bg-primary rounded-pill'>{$visit->device_type}</span></li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>visited at<span class='badge bg-primary rounded-pill'>{$visit->visited_at->format('d/m/Y')}</span></li>
              </ul>"; @endphp
              @endforeach
              @endif
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td>{{$item->destination_url}}</td>
                <td>{{$item->url_key}}</td>
                <td><a href="{{$item->default_short_url}}" target="_blank" class="btn-link">{{$item->default_short_url}}</a></td>
                <td>@if($item->visits->count()>0) <button  class="btn btn-warning btn-sm" data-bs-trigger="hover focus" data-bs-customClass="w-100" data-bs-html="true" data-bs-template='<div class="popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-inner">{{$visitsTable}}</div></div>' data-bs-content="Top popover" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left"><i class="fa-solid fa-chart-line"></i></button> @endif</td>
                <td>{{$item->created_at->format('d/m/Y')}}</td>
              </tr>
            @endforeach

        </tbody>
      </table>
    </div>


</div>
@endsection
@section('js')
<script type="module">
    $(function() {



        // getOrCreateInstance example


        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


    });
</script>
@endsection


















