<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div class="panel border-orange-800">

    <div class="panel-body" id="subscriptionInvoice">

        <div class="container-fluid">
            <table class="table">
                <tr>
                    <td>
                        <img src="<?php echo $message->embed(public_path().'/logo.png'); ?>" alt="">
                    </td>
                    <td style="float: left;">
                        <ul class="list-unstyled pull-right">
                        </ul>
                    </td>
                </tr>
            </table>

            <div class="col-md-12">
                <h1 class="text-center">SALES INVOICE AND CONTRACT</h1>
                <hr>
                <div class="row">
                    <span class="pull-left">Invoice Number</span>
                    <span class="pull-right"></span>
                </div>
                <div class="row">
                    <h2>Subscription</h2>
                    <table class="table table-condensed" style="">
                        <tbody>
                        <tr>
                            <td style="margin-right: 4cm">
                                <strong>Subscriber</strong>
                            </td>
                            <td>
                                     {{ $data['user_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="margin-right: 4cm">
                                <strong>username</strong>
                            </td>
                            <td>
                                {{--{{ $data['email'] }}--}}
                            </td>
                        </tr>
                        <tr>
                            <td style="margin-right: 4cm">
                                <strong>Password</strong>
                            </td>
                            <td>
                               123 (consider Changing your password)
                            </td>
                        </tr>
                        <tr>
                            <td style="margin-right: 10cm">
                                <strong>Subscription Type</strong>
                            </td>
                            <td>
                                     {{$data['package_name']}}
                            </td>
                        </tr>
                        <tr style="margin-right: 4cm">
                            <td>
                                <strong>Subscription Period</strong>
                            </td>
                            <td>
                                     {{$data['current_date']}} - {{$data['expiration_date']}}
                            </td>
                        </tr>

                        <tr style="margin-right: 10cm">
                            <td>
                                <strong>Subscription Fee(Before VAT)</strong>
                            </td>
                            <td>     ETB {{$data['package_price']}}</td>
                        </tr>
                        <tr>
                            <td  style="margin-right: 10cm">
                                <strong>Subscription Fee including 15% VAT</strong>
                            </td>
                            <td>     ETB {{$data['package_price_with_VAT']}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <h2>Service Explanation</h2>
                    @if($data['package_name'] === 'Corporate')
                        <ul class="text-muted">
                            <li>Standard package Features plus.</li>
                            <li>Home Page Logo Advertisement updates</li>
                            <li>Vacancy Posting</li>
                            <li>Tender Posting</li>
                            <li>Contract & subcontracting</li>
                        </ul>
                    @elseif($data['package_name'] === 'Standard')
                        <ul class="text-muted">
                            <li>Proforma requesting & replying</li>
                            <li>Tender Access</li>
                            <li>CV Searching Access</li>
                            <li>Getting Listed In yegnacon directory</li>
                            <li>and more...</li>
                        </ul>
                    @elseif($data['package_name'] === 'Premium')
                        <ul class="text-muted">
                            <li>Corporate Package Features plus.</li>
                            <li>Company Profile Updating & Managing once a month</li>
                            <li>News Coverage</li>
                            <li>25% Discounts on Other Services</li>
                        </ul>
                    @endif
                </div>


                <div class="row">
                    <h2>Terms of Use and Agreement</h2>
                    <ul class="text-muted">
                        <li>Payment should be made inorder to be able to use service</li>
                        <li>The service provider shall render the specified service for the duration of the subscription period mentioned above as soon as the payment has been made</li>
                        <li>The service user must not pass on the username and password to a third party</li>
                        <li>By signing the sales invoice and agreement, you agreee to the yegnacon.com Terms of Use and Agreement.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>