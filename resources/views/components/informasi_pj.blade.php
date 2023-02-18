Mengetahui,
@if (settings('pj_ttd') != null && Storage::exists(settings('pj_ttd')))
    @if (request('output') == 'pdf')
        <div>
            <img src="{{ storage_path() . '/app/' . settings()->get('pj_ttd') }}" alt="" width="130">
        </div>
    @else
        <div>
            <img src="{{ Storage::url(settings()->get('pj_ttd')) }}" alt="" width="130">
        </div>
    @endif
@else
    <br>
    <br>
    <br>
@endif
<div>
    {{ settings()->get('pj_nama') }}
</div>
<div>
    {{ settings()->get('pj_jabatan') }}
</div>
