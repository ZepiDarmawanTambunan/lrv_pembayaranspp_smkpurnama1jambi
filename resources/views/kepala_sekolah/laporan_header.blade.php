<div class="d-flex flex-wrap">
    <div class="wrapper">
        @if (request('output') == 'pdf')
            <img src="{{ storage_path() . '/app/' . settings()->get('app_logo') }}" alt="" width="70"
                class="mt-3 mb-1">
        @else
            <img src="{{ \Storage::url(settings()->get('app_logo')) }}" alt="" width="70" class="mt-3 mb-1">
        @endif
    </div>
    <div class="wrapper px-3 py-2 flex-fill">
        <div class="fw-bold fs-3">{{ settings()->get('app_name', 'My App') }}</div>
        <div>{{ settings()->get('app_address') }}</div>
    </div>
    <div class="wrapper align-self-end">
        <div class=""> Email: {{ settings()->get('app_email') }}</div>
        <div class=""> Telp: {{ settings()->get('app_phone') }}</div>
    </div>
</div>
<hr>
