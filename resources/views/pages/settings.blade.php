@extends('layouts.app',['title'=>'Settings'])

@section('content')
<div class="container">

    @include('layouts.titlesection',['titular'=>'Settings','showBack'=>true])


    <form method="POST" action="{{route('settings.update',['setting'=>1])}}" id="settingForm" class="w-50 mx-auto mt-5 d-block shadow-sm bg-secondary rounded bg-opacity-25">
        @csrf
        <div class="container">
            <div class="row pb-3 g-3">

                <div class="col-8">
                    <div class="my-0">
                        <label for="url_default" class="form-label d-none">URL</label>
                        <div class="input-group input-group-sm">
                          <span class="input-group-text" id="basic-addon3">URL</span>
                          <input required type="text" class="form-control @error('url_default') is-invalid @enderror" id="url_default" name="url_default" aria-describedby="basic-addon3 basic-addon4" value="{{ old('url_default',$settings->url_default) }}">
                        </div>
                        <div class="form-text" id="basic-addon4">Url a rastrear si no se especifica.</div>
                      </div>
                </div>
                <div class="col-4">
                    <div class="my-0">
                        <label for="limit" class="form-label d-none">Limit</label>
                        <div class="input-group input-group-sm">
                          <input required type="number" class="form-control text-center @error('limit') is-invalid @enderror" id="limit" name="limit" aria-describedby="basic-addon3 basic-addon4" value="{{ old('limit',$settings->limit) }}">
                          <span class="input-group-text" id="basic-limit">Limit</span>

                        </div>
                        <div class="form-text text-end" id="basic-addon4">Cantidad de paginas a buscar.</div>
                      </div>
                </div>


                <div class="col-4 ms-auto me-2 justify-content-center d-flex align-items-center @if($settings->save) bg-warning @else bg-secondary @endif bg-opacity-50 rounded shadow-sm">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" value="1" role="switch" name="save" id="flexSwitchCheckChecked" @checked(old('save', $settings->save))>
                        <label class="form-check-label small" for="flexSwitchCheckChecked">Activar proceso</label>
                      </div>
                </div>
                <div class="col-4 d-grid gap-2">
                    <button type="submit" class="btn btn-primary text-uppercase fw-bold" disabled><i class="fa-solid fa-floppy-disk me-2"></i>Guardar</button>
                  </div>

            </div>
        </div>


    </form>

</div>
@endsection
@section('js')
<script type="module">
    $(function() {


        $('html body main form#settingForm input').on('change keyup', function(e) {
            if($(this).hasClass('form-check-input')){
                $(this).parent().parent('div.col-4').toggleClass('bg-secondary bg-warning')
            }
            $('html body main form#settingForm button').removeAttr('disabled')
        })

    });
</script>
@endsection


















