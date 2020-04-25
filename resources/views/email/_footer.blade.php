<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
    <tr>
        <td valign="middle" class="bg_black footer email-section">
            <table>
                <tr>
                    <td valign="top" width="50%" style="padding-top: 20px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="text-align: left; padding-left: 5px; padding-right: 5px;">
                                    <h3 class="heading">Contact Info</h3>
                                    <ul>
                                        <li style="color: white;">
                                            <div class="text">{{ config('butik.address1', '') }}</div>
                                            @if (config('butik.address2') !== null)
                                                <div class="text">{{ config('butik.address2', '') }}</div>
                                            @endif
                                            <div class="text">{{ config('butik.zip_city', '') }}</div>
                                            <div class="text">{{ config('butik.country', '') }}</div>
                                        </li>
                                        <li><span class="text"><a href="tel:{{ config('butik.phone', '') }}">{{ config('butik.phone', '') }}</span></a></li>
                                        <li><span class="text"><a href="mailto:{{ config('butik.mail', '') }}">{{ config('butik.mail', '') }}</span></a></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                    @if (count(config('butik.useful-links')) > 0)
                        <td valign="top" width="50%" style="padding-top: 20px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: left; padding-left: 10px;">
                                        <h3 class="heading">Useful Links</h3>
                                        <ul>
                                            @foreach(config('butik.useful-links') as $link => $name)
                                                <li><a target="_blank" href="{{ $link }}">{{ $name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endif
                </tr>
            </table>
        </td>
    </tr><!-- end: tr -->
    <tr>
        <td valign="middle" class="bg_black footer email-section">
            <table>
                <tr>
                    <td valign="top" width="100%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="text-align: left; padding-right: 10px; color: white;">
                                    <p>&copy; {{ now()->format('Y') }} {{ config('butik.name') }}. All Rights Reserved</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
