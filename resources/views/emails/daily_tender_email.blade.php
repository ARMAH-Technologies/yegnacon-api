<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Welcome new user</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
        /* Client-specific Styles */
        div, p, a, li, td {
            -webkit-text-size-adjust: none;
        }

        #outlook a {
            padding: 0;
        }

        /* Force Outlook to provide a "view in browser" menu link. */
        html {
            width: 100%;
        }

        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }

        /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        /* Force Hotmail to display normal line spacing. */
        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }

        img {
            outline: none;
            text-decoration: none;
            border: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        .image_fix {
            display: block;
        }

        p {
            margin: 0px 0px !important;
        }

        table td {
            border-collapse: collapse;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        a {
            color: #33b9ff;
            text-decoration: none;
            text-decoration: none !important;
        }

        /*STYLES*/
        table[class=full] {
            width: 100%;
            clear: both;
        }

        /*IPAD STYLES*/
        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #33b9ff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #33b9ff !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 440px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 420px !important;
                text-align: center !important;
            }

            img[class=banner] {
                width: 440px !important;
                height: 220px !important;
            }

            img[class=col2img] {
                width: 440px !important;
                height: 220px !important;
            }

        }

        /*IPHONE STYLES*/
        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #33b9ff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #33b9ff !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 280px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 260px !important;
                text-align: center !important;
            }

            img[class=banner] {
                width: 280px !important;
                height: 140px !important;
            }

            img[class=col2img] {
                width: 280px !important;
                height: 140px !important;
            }

        }
    </style>
</head>

<body>
<!-- Start of preheader -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="preheader">
    <tbody>
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                <tbody>
                <tr>
                    <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center"
                               class="devicewidth">
                            <tbody>
                            <!-- Spacing -->
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
                            <!-- Spacing -->
                            <tr>
                                <td width="100%" align="left" valign="middle"
                                    style="font-family: Helvetica, arial, sans-serif; font-size: 13px;color: #282828"
                                    st-content="preheader">
                                    Can't see this Email? View it in your <a href="#"
                                                                             style="text-decoration: none; color: #eacb3c">Browser </a>
                                </td>
                            </tr>
                            <!-- Spacing -->
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
                            <!-- Spacing -->
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- End of preheader -->
<!-- Start of header -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="header">
    <tbody>
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                <tbody>
                <tr>
                    <td width="100%">
                        <table width="600" bgcolor="#eacb3c" cellpadding="0" cellspacing="0" border="0" align="center"
                               class="devicewidth">
                            <tbody>
                            <tr>
                                <td>
                                    <!-- logo -->
                                    <table bgcolor="#ffffff" width="140" align="left" border="0" cellpadding="0"
                                           cellspacing="0" class="devicewidth">
                                        <tbody>
                                        <tr>
                                            <td width="300" height="50" align="center">
                                                <div class="imgpop">
                                                    <a href="http://www.yegnacon.com"target="_blank" href="#">
                                                        <img src="<?php echo $message->embed(public_path() . '/logo.png'); ?>"
                                                             alt="Logo" border="0" width="140" height="50"
                                                             style="display:block; border:none; outline:none; text-decoration:none;">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- end of logo -->
                                    <!-- start of menu -->
                                    <table bgcolor="#eacb3c" width="250" height="50" border="0" align="right"
                                           valign="middle" cellpadding="0" cellspacing="0" border="0"
                                           class="devicewidth">
                                        <tbody>
                                        <tr>
                                            <td height="50" align="center" valign="middle"
                                                style="font-family: Helvetica, arial, sans-serif; font-size: 13px;color: #282828"
                                                st-content="menu">
                                                <a href="http://www.yegnacon.com/app/#/main/public/home"
                                                   style="color: #282828;text-decoration: none;">Home</a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="http://www.yegnacon.com/app/#/main/public/vacancy"
                                                   style="color: #282828;text-decoration: none;">Jobs</a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="http://www.yegnacon.com/app/#/main/public/contact"
                                                   style="color: #282828;text-decoration: none;">Contact</a>
                                                &nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- end of menu -->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- End of Header -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="seperator">
    <tbody>
    <tr>
        <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                <tbody>
                <tr>
                    <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- End of seperator -->

<!-- Start of table -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="full-text">
    <tbody>
    <tr>
        <td>
        
        <table style="font-family: arial, sans-serif; border-collapse: collapse;" align="center" width="600"
                       id="table_id">
                <thead>
                <tr>
      			<th style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                    href="http://www.yegnacon.com/app/#/main/public/tender"
                                    style="color: #282828;text-decoration: none;">Category</a></th>
                        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                    href="http://www.yegnacon.com/app/#/main/public/tender"
                                    style="color: #282828;text-decoration: none;">Title</a></th>
                        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                    href="http://www.yegnacon.com/app/#/main/public/tender"
                                    style="color: #282828;text-decoration: none;">Document Price</a></th>
                        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                    href="http://www.yegnacon.com/app/#/main/public/tender"
                                    style="color: #282828;text-decoration: none;">Opening Date</a></th>
                        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                    href="http://www.yegnacon.com/app/#/main/public/tender"
                                    style="color: #282828;text-decoration: none;">Closing Date</a></th>
                                   
                   </tr>
                   </thead>
                   
            @foreach($categories as $category) 
                   <tbody>
                            <tr>
                            	<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                            href="http://www.yegnacon.com/app/#/main/public/tender"
                                            style="color: #282828;text-decoration: none;">{{$category['details']['category']}}</a>
                                </td>
                                <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                            href="http://www.yegnacon.com/app/#/main/public/tender"
                                            style="color: #282828;text-decoration: none;">{{$category['title']}}</a>
                                <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                            href="http://www.yegnacon.com/app/#/main/public/tender"
                                            style="color: #282828;text-decoration: none;">ETB{{$category['document_price']}}</a>
                                </td>
                                           
                                <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                            href="http://www.yegnacon.com/app/#/main/public/tender"
                                            style="color: #282828;text-decoration: none;">{{$category['opening_date']}}</a>
                                </td>
                                <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a
                                            href="http://www.yegnacon.com/app/#/main/public/tender"
                                            style="color: #282828;text-decoration: none;">{{$category['closing_date']}}</a>
                                </td>
                            </tr>
                    </tbody>
            @endforeach
        </td>
    </tr>
    </tbody>
</table>

<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="seperator">
    <tbody>
    <tr>
        <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                <tbody>
                <tr>
                    <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- End of seperator -->
<!-- Start of footer -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
       st-sortable="footer">
    <tbody>
    <tr>
        <td>
            <table width="600" bgcolor="#eacb3c" cellpadding="0" cellspacing="0" border="0" align="center"
                   class="devicewidth">
                <tbody>
                <tr>
                    <td width="100%">
                        <table bgcolor="#eacb3c" width="600" cellpadding="0" cellspacing="0" border="0" align="center"
                               class="devicewidth">
                            <tbody>
                            <!-- Spacing -->
                            <tr>
                                <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
                            <!-- Spacing -->
                            <tr>
                                <td>
                                    <!-- Social icons -->
                                    <table width="150" align="center" border="0" cellpadding="0" cellspacing="0"
                                           class="devicewidth">
                                        <tbody>
                                        <tr>
                                            <td width="43" height="43" align="center">
                                                <div class="imgpop">
                                                    <a target="_blank" href="https://www.facebook.com/yegnacon">
                                                        <img src="<?php echo $message->embed(public_path() . '/facebook.png'); ?>"
                                                             alt="Facebook Page" border="0" width="43" height="43"
                                                             style="display:block; border:none; outline:none; text-decoration:none;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td align="left" width="20" style="font-size:1px; line-height:1px;">
                                                &nbsp;</td>
                                            <td width="43" height="43" align="center">
                                                <div class="imgpop">
                                                    <a target="_blank" href="#">
                                                        <img src="<?php echo $message->embed(public_path() . '/twitter.png'); ?>"
                                                             alt="Twitter Page" border="0" width="43" height="43"
                                                             style="display:block; border:none; outline:none; text-decoration:none;">
                                                    </a>
                                                </div>
                                            </td>
                                            <td align="left" width="20" style="font-size:1px; line-height:1px;">
                                                &nbsp;</td>
                                            <td width="43" height="43" align="center">
                                                <div class="imgpop">
                                                    <a target="_blank" href="#">
                                                        <img src="<?php echo $message->embed(public_path() . '/linkedin.png'); ?>"
                                                             alt="LinkedIn Page" border="0" width="43" height="43"
                                                             style="display:block; border:none; outline:none; text-decoration:none;">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- end of Social icons -->
                                </td>
                            </tr>
                            <!-- Spacing -->
                            <tr>
                                <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                    &nbsp;</td>
                            </tr>
                            <!-- Spacing -->
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- End of footer -->

</body>
</html>
