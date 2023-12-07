<div
    class="lh-sm rounded-top mb-4 py-2 px-3 bg-secondary bg-opacity-25 border-bottom border-secondary fw-bold justify-content-between d-flex align-items-center">
    <span class="w-25">
        @if ($showBack)
            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="{{ url()->previous() }}"><i class="fa-solid fa-angles-left fa-2xs me-1"></i>back</a>
        @else
            <div class="filter position-relative">



                <input type="range" class="form-range h-100" min="{{$defaultCantPages}}" max="{{$pages->total()}}" step="{{$defaultCantPages}}" value="{{$limit}}"
                    id="customRange2">
                    <span class="position-absolute start-100 badge text-bg-info ms-2 shadow-sm" id="infoPages">{{$limit}}</span>
            </div>
        @endif
    </span><span class="text-uppercase">{{ $titular }}</span>
</div>
