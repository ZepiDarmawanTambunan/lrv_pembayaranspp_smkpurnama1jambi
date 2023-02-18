<tr>
    <td class="title" width="80" style="margin-bottom: 0; padding-bottom: 0;">

        @if (request('output') == 'pdf')
            <img src="{{ storage_path() . '/app/' . settings()->get('app_logo') }}" alt="" width="70">
        @else
            <img src="{{ \Storage::url(settings()->get('app_logo')) }}" alt="" width="70">
        @endif

    </td>
    <td style="text-align:left; vertical-align:middle;">
        <div style="font-size:20px; font-weight:bold">{{ settings()->get('app_name', 'MYAPP') }}
        </div>
        <div>
            {{ settings()->get('app_address', 'MYAPP') }}
        </div>
    </td>
</tr>
<tr>
    <td colspan="3">
        <hr>
    </td>
</tr>
