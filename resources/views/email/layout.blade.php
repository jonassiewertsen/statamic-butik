@include('butik::email._htmlHeader')

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
        <!-- BEGIN BODY -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
            <tr>
                <td valign="top" class="bg_white" style="padding: 1em 2.5em;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="logo" style="text-align: center;">
                                <h1><a href="#">{{ config('butik.name', '') }}</a></h1>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr><!-- end tr -->
            <tr>
                <td class="bg_white">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="bg_white email-section">
                                <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                    <h2 style="margin-bottom: -15px;">{{ $heading ?? 'Information' }}</h2>
                                    @isset($subheading)
                                        <p style="margin-bottom: 40px;">{{ $subheading }}</p>
                                    @endisset
                                </div>

                                @yield('content')

                            </td>
                        </tr><!-- end: tr -->

                    </table>

                </td>
            </tr><!-- end:tr -->
            <!-- 1 Column Text + Button : END -->
        </table>

        @include('butik::email._footer')

    </div>
</center>
</body>
</html>
