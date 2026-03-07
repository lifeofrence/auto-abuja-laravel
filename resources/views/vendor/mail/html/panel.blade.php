<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td class="panel-content"
            style="background-color: #f8fafc; padding: 20px; border-radius: 12px; border-left: 4px solid #F68B1E;">
            {!! Illuminate\Mail\Markdown::parse((string) $slot) !!}
        </td>
    </tr>
</table>