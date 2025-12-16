@php
  $confirmUrl = $confirmUrl ?? '#';
  $logoUrl = $logoUrl ?? asset('img/logoppid.png');
  $expireMinutes = $expireMinutes ?? 60;
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      lang="id">
<head>
  <title>Reset Password</title>
  <meta charset="UTF-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!--[if !mso]>-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!--<![endif]-->
  <meta name="x-apple-disable-message-reformatting" content="" />
  <meta content="target-densitydpi=device-dpi" name="viewport" />
  <meta content="true" name="HandheldFriendly" />
  <meta content="width=device-width" name="viewport" />
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no" />

  <style type="text/css">
    table { border-collapse: separate; table-layout: fixed; mso-table-lspace: 0pt; mso-table-rspace: 0pt }
    table td { border-collapse: collapse }
    .ExternalClass { width: 100% }
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100% }
    body, a, li, p, h1, h2, h3 { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
    html { -webkit-text-size-adjust: none !important }
    body { min-width: 100%; Margin: 0px; padding: 0px; }
    body, #innerTable { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale }
    #innerTable img+div { display: none; display: none !important }
    img { Margin: 0; padding: 0; -ms-interpolation-mode: bicubic }
    h1, h2, h3, p, a { line-height: inherit; overflow-wrap: normal; white-space: normal; word-break: break-word }
    a { text-decoration: none }
    a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important }
    u + #body a { color: inherit; text-decoration: none; font-size: inherit; font-family: inherit; font-weight: inherit; line-height: inherit; }
    a[href^="mailto"], a[href^="tel"], a[href^="sms"] { color: inherit; text-decoration: none }
  </style>

  <style type="text/css">
    @media (min-width: 481px) { .hd { display: none!important } }
  </style>
  <style type="text/css">
    @media (max-width: 480px) { .hm { display: none!important } }
  </style>
  <style type="text/css">
    @media (max-width: 480px) {
      .spacer-top,.spacer-bottom{mso-line-height-alt:0px!important;line-height:0!important;display:none!important}
      .card-pad{padding:40px!important;border-radius:0!important}
      .content-w{max-width:398px!important}
      .btn-wrap,.btn-cell{vertical-align:top!important;width:auto!important;max-width:100%!important}
    }
  </style>

  <!--[if !mso]>-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&amp;family=Sofia+Sans:wght@700&amp;family=Open+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet" type="text/css" />
  <!--<![endif]-->

  <!--[if mso]>
  <xml>
    <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
</head>

<body id="body" style="min-width:100%;Margin:0px;padding:0px;background-color:#FFFFFF;">
  <span style="display:none!important;opacity:0;color:transparent;height:0;width:0;max-height:0;max-width:0;overflow:hidden;mso-hide:all;visibility:hidden;">
    Reset password akun Anda. Tautan berlaku {{ $expireMinutes }} menit.
  </span>

  <div style="background-color:#FFFFFF;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
      <tr>
        <td style="font-size:0;line-height:0;mso-line-height-rule:exactly;background-color:#FFFFFF;" valign="top" align="center">

          <!--[if mso]>
          <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false">
            <v:fill color="#FFFFFF"/>
          </v:background>
          <![endif]-->

          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" id="innerTable">
            <tr>
              <td>
                <div class="spacer-top" style="mso-line-height-rule:exactly;mso-line-height-alt:50px;line-height:50px;font-size:1px;display:block;">&nbsp;&nbsp;</div>
              </td>
            </tr>

            <tr>
              <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" style="Margin-left:auto;Margin-right:auto;">
                  <tr>
                    <td width="600" style="width:600px;">
                      <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                        <tr>
                          <td class="card-pad" style="border:1px solid #EBEBEB;overflow:hidden;background-color:#FFFFFF;padding:44px 42px 32px 42px;border-radius:3px;">

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="width:100% !important;">

                              {{-- Logo --}}
                              <tr>
                                <td align="left">
                                  <table role="presentation" cellpadding="0" cellspacing="0" style="Margin-right:auto;">
                                    <tr>
                                      <td width="200" style="width:200px;">
                                        <div style="font-size:0px;">
                                          <img
                                            style="display:block;border:0;height:auto;width:100%;Margin:0;max-width:100%;"
                                            width="200" height="100"
                                            alt="PPID"
                                            src="{{ $logoUrl }}" />
                                        </div>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                              <tr><td><div style="mso-line-height-rule:exactly;mso-line-height-alt:42px;line-height:42px;font-size:1px;display:block;">&nbsp;&nbsp;</div></td></tr>

                              {{-- Title --}}
                              <tr>
                                <td align="center">
                                  <table role="presentation" cellpadding="0" cellspacing="0" style="Margin-left:auto;Margin-right:auto;">
                                    <tr>
                                      <td width="514" class="content-w" style="width:600px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                          <tr>
                                            <td style="border-bottom:1px solid #EFF1F4;padding:0 0 18px 0;">
                                              <h1
                                                style="margin:0;font-family:Montserrat,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:28px;font-weight:700;font-size:24px;letter-spacing:-1px;color:#141414;text-align:left;mso-line-height-rule:exactly;mso-text-raise:1px;">
                                                Reset Password
                                              </h1>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                              <tr><td><div style="mso-line-height-rule:exactly;mso-line-height-alt:18px;line-height:18px;font-size:1px;display:block;">&nbsp;&nbsp;</div></td></tr>

                              {{-- Content --}}
                              <tr>
                                <td align="center">
                                  <table role="presentation" cellpadding="0" cellspacing="0" style="Margin-left:auto;Margin-right:auto;">
                                    <tr>
                                      <td width="514" class="content-w" style="width:600px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                          <tr>
                                            <td>
                                              <p style="margin:0;font-family:Open Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:25px;font-weight:400;font-size:15px;letter-spacing:-0.1px;color:#141414;text-align:left;mso-line-height-rule:exactly;mso-text-raise:3px;">
                                                Yth. {{ $user->name ?? 'Pengguna' }},
                                                <br/><br/>
                                                Kami menerima permintaan untuk mereset password akun Anda.
                                                Silakan klik tombol di bawah ini untuk membuat password baru.
                                                <br/><br/>
                                                Tautan ini berlaku <strong>{{ $expireMinutes }} menit</strong>.
                                              </p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                              <tr><td><div style="mso-line-height-rule:exactly;mso-line-height-alt:24px;line-height:24px;font-size:1px;display:block;">&nbsp;&nbsp;</div></td></tr>

                              {{-- Button --}}
                              <tr>
                                <td align="left">
                                  <table class="btn-wrap" role="presentation" cellpadding="0" cellspacing="0" style="Margin-right:auto;max-width:514px;">
                                    <tr>
                                      <td class="btn-cell" style="width:auto;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" style="width:auto;max-width:514px;">
                                          <tr>
                                            <td style="overflow:hidden;background-color:#0666EB;text-align:center;line-height:34px;mso-line-height-rule:exactly;mso-text-raise:5px;padding:0 23px;border-radius:40px;">
                                              <a href="{{ $confirmUrl }}"
                                                 target="_blank"
                                                 rel="noopener"
                                                 style="display:block;margin:0;font-family:Sofia Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:34px;font-weight:700;font-size:16px;letter-spacing:-0.2px;color:#FFFFFF;text-align:center;">
                                                Reset Password
                                              </a>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                              {{-- Fallback link --}}
                              <tr><td><div style="mso-line-height-rule:exactly;mso-line-height-alt:14px;line-height:14px;font-size:1px;display:block;">&nbsp;&nbsp;</div></td></tr>
                              <tr>
                                <td align="center">
                                  <table role="presentation" cellpadding="0" cellspacing="0" style="Margin-left:auto;Margin-right:auto;">
                                    <tr>
                                      <td width="514" class="content-w" style="width:600px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                          <tr>
                                            <td>
                                              <p style="margin:0;font-family:Open Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:400;font-size:14px;letter-spacing:-0.1px;color:#555555;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;">
                                                Jika tombol tidak berfungsi, buka tautan ini:
                                                <br/>
                                                <a href="{{ $confirmUrl }}" target="_blank" rel="noopener" style="color:#0666EB;text-decoration:underline;">
                                                  {{ $confirmUrl }}
                                                </a>
                                              </p>
                                              <p style="margin:14px 0 0 0;font-family:Open Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:22px;font-weight:400;font-size:14px;letter-spacing:-0.1px;color:#555555;text-align:left;mso-line-height-rule:exactly;mso-text-raise:2px;">
                                                Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Demi keamanan, jangan bagikan tautan kepada siapa pun.
                                              </p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                              <tr><td><div style="mso-line-height-rule:exactly;mso-line-height-alt:40px;line-height:40px;font-size:1px;display:block;">&nbsp;&nbsp;</div></td></tr>

                              {{-- Footer --}}
                              <tr>
                                <td align="center">
                                  <table role="presentation" cellpadding="0" cellspacing="0" style="Margin-left:auto;Margin-right:auto;">
                                    <tr>
                                      <td width="514" class="content-w" style="width:600px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                          <tr>
                                            <td style="border-top:1px solid #DFE1E4;padding:24px 0 0 0;">
                                              <p style="margin:0;font-family:Open Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:20px;font-weight:600;font-size:14px;color:#222222;text-align:left;">
                                                PPID PTUN Bandung
                                              </p>
                                              <p style="margin:6px 0 0 0;font-family:Open Sans,BlinkMacSystemFont,Segoe UI,Helvetica Neue,Arial,sans-serif;line-height:20px;font-weight:400;font-size:13px;color:#7A7A7A;text-align:left;">
                                                Email ini dikirim otomatis, mohon tidak membalas.
                                              </p>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>

                            </table>

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td>
                <div class="spacer-bottom" style="mso-line-height-rule:exactly;mso-line-height-alt:50px;line-height:50px;font-size:1px;display:block;">&nbsp;&nbsp;</div>
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>
  </div>

  <div class="gmail-fix" style="display:none; white-space:nowrap; font:15px courier; line-height:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
  </div>
</body>
</html>
