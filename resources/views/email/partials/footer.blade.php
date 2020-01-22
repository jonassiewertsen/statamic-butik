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
                                        <li>
                                            <div class="text">{{ config('statamic-butik.address_1', '') }}</div>
                                            @if (config('statamic-butik.address_2') !== null)
                                                <div class="text">{{ config('statamic-butik.address_2', '') }}</div>
                                            @endif
                                            <div class="text">{{ config('statamic-butik.zip_city', '') }}</div>
                                            <div class="text">{{ config('statamic-butik.country', '') }}</div>
                                        </li>
                                        <li><span class="text"><a href="tel:{{ config('statamic-butik.phone', '') }}">{{ config('statamic-butik.phone', '') }}</span></a></li>
                                        <li><span class="text"><a href="mailto:{{ config('statamic-butik.mail', '') }}">{{ config('statamic-butik.mail', '') }}</span></a></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                    @if (count(config('statamic-butik.useful_links')) > 0)
                        <td valign="top" width="50%" style="padding-top: 20px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: left; padding-left: 10px;">
                                        <h3 class="heading">Useful Links</h3>
                                        <ul>
                                            @foreach(config('statamic-butik.useful_links') as $link => $name)
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
                                <td style="text-align: left; padding-right: 10px;">
                                    <p>&copy; {{ now()->format('Y') }} {{ config('statamic-butik.name') }}. All Rights Reserved</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>