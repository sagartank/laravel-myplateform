<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>MIPO</title>

    <!--PDF Stylesheet-->
    <style>
        @font-face {
            font-family: 'GeneralSans';
            src: url({{ storage_path('fonts/GeneralSans-Bold.ttf') }}) format('truetype');
            font-weight: bold;
            font-style: italic;
            font-display: swap;
        }

        @font-face {
            font-family: 'GeneralSans';
            src: url({{ storage_path('fonts/GeneralSans-Medium.ttf') }}) format('truetype');
            font-weight: normal;
            font-style: italic;
            font-display: swap;
        }

        @font-face {
            font-family: 'GeneralSans';
            src: url({{ storage_path('fonts/GeneralSans-Regular.ttf') }}) format('truetype');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @page {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
        }

        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        body {
            font-family: 'GeneralSans';
            font-size: 10px;
            color: #000;
            background: #fff;
            margin: 0px;
            padding: 0px;
        }

        .pdf-wrapper {
            width: 100%;
            position: relative;
        }

        header {
            position: relative;
            top: 0;
            left: 0;
            right: 0;
        }

        .pdf-header {
            padding: 0 20px 40px;
        }

        .pdf-header table {
            width: 100%;
        }

        .pdf-header .logo {
            width: 80px;
        }

        .pdf-header .logo img {
            width: 100%;
            height: auto;
        }

        .pdf-header .head-date {
            text-align: right;
        }

        .pdf-header .head-date .date-title {
            color: #ADADAD;
            font-size: 12px;
        }

        .pdf-header .head-date .pdf-date {
            font-size: 14px;
            color: #000;
            font-weight: 600;
        }

        .pdf-body {
            padding: 0 0 40px;
        }

        .pdf-body .h2 {
            font-size: 14px;
            padding: 0 20px 20px;
            font-weight: 600;
        }

        .pdf-body table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            margin: 0px;
            padding: 0px;
        }

        .pdf-body table tr {}

        .pdf-body table tr td {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #ADADAD;
            line-height: 18px;
            vertical-align: bottom;
            margin: 0px;
            padding: 2px 10px;
        }

        .pdf-body table tr td strong {
            display: inline-block;
            vertical-align: middle;
            color: #000;
            font-weight: normal;
        }

        .pdf-body table.content-table>tr>td {
            vertical-align: bottom;
        }

        .pdf-body table .rating {
            display: inline-block;
            vertical-align: middle;
            font-size: 0;
            line-height: 1;
        }

        .pdf-body table .rating ul {
            display: inline-block;
            vertical-align: middle;
            font-size: 0;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pdf-body table .rating ul li {
            display: inline-block;
            vertical-align: middle;
            font-size: 0;
            list-style: none;
            padding: 0 3px;
        }

        .pdf-body table .rating ul li.active path {
            fill: #FFC107;
        }

        .pdf-body table .cheque ul {
            display: inline-block;
            vertical-align: middle;
            font-size: 0;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pdf-body table .cheque ul li {
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 10px;
        }

        .pdf-body .document {
            margin-top: 30px;
        }

        .pdf-body .document img {
           /*  width: 100%;
            height: auto; */
            width: 150px;
            height: 150px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        footer table {
            width: 100%;
        }

        .pdf-footer {
            background: #13153B;
            padding: 14px 20px;
        }

        .pdf-footer p {
            color: #fff;
        }
    </style>
    <!--PDF Stylesheet-->
</head>

<body>
    <div class="pdf-wrapper">
        <header>
            <div class="pdf-header">
                <table>
                    <tr>
                        <td>
                            <div class="logo text-center">
                                <a href="#">
                                    <img alt="no-image"
                                        src="data:image/png;base64,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" />
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="head-date">
                                <div class="date-title">{{ __('Operation Report') }}</div>
                                <div class="pdf-date">{{ date('d-M-Y') }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </header>
        <div class="pdf-body">
            <div class="h2">{{ $operation->operation_type_number }}</div>
            <table class="content-table">
                <tr>
                    <td width="80%">
                        <table>
                            <tr>
                                <td>{{ __('Type of Document') }}</td>
                                <td><strong>{{ $operation->operation_type }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ __('Responsibility') }}</td>
                                <td><strong>
                                    @if($operation->responsibility == 'With')
                                    {{ __('Yes, I Act as Guarantor')}}
                                    @elseif($operation->responsibility == 'Without')
                                    {{ __('No, I dont act as Guarantor')}}
                                @endif
                                    {{-- {{ $operation->responsibility }} Resource --}}
                                </strong></td>
                            </tr>
                            <tr>
                                <td>{{ __('Preferred Payment Method') }}</td>
                                <td><strong>{{ $operation->preferred_payment_method }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ __('Seller') }}</td>
                                <td>
                                    <strong>{{ app('common')->lockOperationDetail($operation, []) }}</strong>
                                    <span class="rating">
                                        <ul>
                                            @if(!empty($operation->seller?->ratings_avg_rating_number))
                                            <li><img src="{{ app('common')->userRatingImage($operation->seller?->ratings_avg_rating_number) }}" alt="{{ __('user rating') }}"></li>
                                            @endif
                                        </ul>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Payer / Issuer') }}</td>
                                <td>
                                    <strong>{{ $operation->issuer->first()?->name }}</strong>
                                    <span class="rating">
                                        <ul>
                                            @if(!empty($operation->issuer?->ratings_avg_rating_number))
                                            <img src="{{ app('common')->issuerRatingImage($operation->issuer?->ratings_avg_rating_number) }}" alt="issuer">
                                            @endif
                                        </ul>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Document Amount') }}</td>
                                <td>
                                    <strong> {!! app('common')->currencyBySymbol($operation->preferred_currency) !!}{{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount_requested) }}</strong>
                                </td>
                            </tr>
                           {{--  <tr>
                                <td>{{ __('Amount Requested') }}</td>
                                <td><strong> {!! app('common')->currencyBySymbol($operation->preferred_currency) !!} {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</strong>
                                </td>
                            </tr> --}}
                            <tr>
                                <td>{{ __('Issuance Date') }}</td>
                                <td><strong>{{ $operation->issuance_date_iso }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ __('Expiration Date') }}</td>
                                <td><strong>{{ $operation->expire_date_iso }}</strong></td>
                            </tr>
                            @if ($operation->operation_type == 'Cheque')
                                <tr>
                                    <td>{{ __('Check Number') }}</td>
                                    <td><strong>{{ $operation->check_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Paying Bank') }}</td>
                                    <td><strong>{{ $operation->issuer_bank?->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Check Type') }}</td>
                                    <td><strong>{{ $operation->cheque_status }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Issuer Type') }}</td>
                                    <td><strong> Third Party / Self Document </strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Type of Cashing') }}</td>
                                    <td><strong>{{ $operation->cheque_type }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Payable Type') }}</td>
                                    <td><strong>{{ $operation->cheque_payee_type }}</strong></td>
                                </tr>
                            @endif
                            @if ($operation->operation_type != 'Cheque')
                                <tr>
                                    <td>{{ __('Invoice Number') }}</td>
                                    <td><strong>{{ $operation->invoice_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Timbrado') }}</td>
                                    <td><strong>{{ $operation->timbrado }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Tax ID Number:') }}</td>
                                    <td><strong>{{ $operation->tax_id }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Type of Company') }}</td>
                                    <td><strong>{{ $operation->issuer_company_type }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Retention') }}</td>
                                    <td><strong>{{ __('Available') }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Authorized Person') }}</td>
                                    <td><strong>{{ $operation->authorized_personnel }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Invoice Type') }}</td>
                                    <td><strong>{{ __('Service / Product') }}</strong></td>
                                </tr>
                            @endif
                            @if ($operation->references->count() > 0)
                                @foreach ($operation->references as $key => $reference)
                                    <tr>
                                        <td>{{ __('Commercial Reference') }} {{ $key + 1 }}</td>
                                        <td><strong>{{ $reference->name }}
                                                {{ $reference->company_name ? $reference->company_name . '/' : '' }}
                                                {{ $reference->email ? $reference->email . '/' : '' }}
                                                {{ $reference->phone_number ?? '' }}</strong></td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td>{{ __('Attachments Available') }}</td>
                                <td><strong>{{ $operation->operation_type }}</strong></td>
                            </tr>
                        </table>
                    </td>
                    <td width="20%" valign="bottom">
                        <div class="cheque">
                            <ul>
                                @php
                                    $active_img = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTEiIGhlaWdodD0iMTAiIHZpZXdCb3g9IjAgMCAxMSAxMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEgNS40NDQ0NEw0LjU1NTU2IDlMOS44ODg4OSAxIiBzdHJva2U9IiMxOTg3NTQiIHN0cm9rZS13aWR0aD0iMS41IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+Cg==';
                                    $inactive_img = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIHZpZXdCb3g9IjAgMCAxMCAxMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEgOUw5IDFNMSAxTDkgOSIgc3Ryb2tlPSIjREMzNTQ1IiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=';
                                @endphp
                                @if ($operation->bcp != '0' && !is_null($operation->bcp))
                                    <li><span><img src="{{ $operation->bcp == '1' ? $active_img : $inactive_img }}"
                                                alt="no-image"> </span>BCP</li>
                                @endif
                                @if ($operation->inforconf != '0' && !is_null($operation->inforconf))
                                    <li><span><img
                                                src="{{ $operation->inforconf == '1' ? $active_img : $inactive_img }}"
                                                alt="no-image"> </span>Inforconf</li>
                                @endif
                                @if ($operation->infocheck != '0' && !is_null($operation->infocheck))
                                    <li><span><img
                                                src="{{ $operation->infocheck == '1' ? $active_img : $inactive_img }}"
                                                alt="no-image"> </span>Infocheck</li>
                                @endif
                                @if ($operation->criterium != '0' && !is_null($operation->criterium))
                                    <li><span><img
                                                src="{{ $operation->criterium == '1' ? $active_img : $inactive_img }}"
                                                alt="no-image"> </span>Criterium</li>
                                @else
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="document">
                <tr>
                    @if ($operation->documents && $operation->documents->count() > 0)
                        @foreach ($operation->documents as $document)
                            @if ($document->document_url != '')
                                @php
                                    $file_ext = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                                @endphp
                                @if ($file_ext != 'pdf')
                                    <td><img width="150" src="{{ $document->document_url }}" alt="no-image" /></td>
                                @endif
                            @endif
                        @endforeach
                    @endif
                    @if ($operation->supportingAttachments && $operation->supportingAttachments->count() > 0)
                        @foreach ($operation->supportingAttachments as $attachments)
                            @if ($attachments->attachment_url != '')
                                @php
                                    $file_ext = strtolower(pathinfo($attachments->path, PATHINFO_EXTENSION));
                                @endphp
                                @if ($file_ext != 'pdf')
                                    <td><img  width="150" src="{{ $attachments->attachment_url }}" alt="no-image" />
                                    </td>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </tr>
               {{--  <tr>
                    @if ($operation->supportingAttachments && $operation->supportingAttachments->count() > 0)
                        @foreach ($operation->supportingAttachments as $attachments)
                            @if ($attachments->attachment_url != '')
                                @php
                                    $file_ext = strtolower(pathinfo($attachments->path, PATHINFO_EXTENSION));
                                @endphp
                                @if ($file_ext != 'pdf')
                                    <td><img width="100" src="{{ $attachments->attachment_url }}" alt="no-image" />
                                    </td>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </tr> --}}
            </table>
        </div>
        <footer>
            <div class="pdf-footer">
                <table>
                    <tr>
                        <td>
                            <p>{{ __('MIPORTAFOLIO') }}</p>
                            <p>Phone: +595 971 663 789</p>
                            <p>email: contacto@mipo.com.py</p>
                        </td>
                        <td>
                            <img alt="no-image"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAaCAYAAAD1wA/qAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAASaSURBVHgB7VddaFxFFJ659+5PdrP5s8bYhjbBtLUSLVUoIWKN+lQptah5UBGhxQcRi30RKoiL+tIHQy1YKAhFRYlBUKvYCtUEjVWCpQSCtIbUrWuy2+0mm929d+/OnT/P3br27t2buMI2NtDvZXfOfHNnzpzznZlBqI4wTbOrUKRj8m9wIf9IZ8getNpgFNhR6QIXInfkyHQAXWcoqI5QNLSpyoZxpH93SxtaTSCUv+GOCGNiDq02fP3zdJNuWMcpE3nOBbOoODeT1O9GqxmDgyMqWkHgZNp8JBjUcNnQHNZ+wRgvXp6n/aGQ8rCKeSulItbUGPgS7LEyb3z8fGTj5g27w2GlV1EVRUV4cujTX0++8NiW+8ocxhgKBjTE+LUJP/g+9kMXy6p9O+55KhJS7scStQiJY5cSuRNbulvHnIv7ZjIZ3ra+ebAt4u9nXK6RCOW4QKMzs+bJrT2RVIUnlHLmzOm5y/knTJOe8qg+gnMZtcdcWTSfF0Jm3BxisXln27K4myInL84/CamXkB4wCfspkzE3IClxTqcHwZTx4oHuDIPwtwYGRrUlHdELNCWXQaHITkD+c68+i1aavRyBsVm5DKB/Rjet92UNWMxbYyNn4g2l1LId0TSlLvkMKYh8PmXJdi2ASCNFwTXzDcIONwZ9BzxngTSa55y/ZxSKE0t9gBA6Cf3H4W8M/UfAYnVYwDvFonhNymvjbSewhw+gsW9NIl6BCI+4+xr86v6FnPlAVWpRyhKmlN1lomkWR90h1QvF74ZGzpRCCs0uWMBiranFIHdm0+TO8vc/G/29xTDpeKmPiSo+aOVt58JBv2+6OZYFnCpHGDvtHJjTrefcA9OZwuNOjl4wh70WvoQjH7p3NXnF2FWa27URcFcjoxOpDic3Gp3yQ8pWFBXYiB8VjzAuONvEomk355aWhgqOpvkWUI0oEn7WbaMYn0PS/leZVyCVuYe2tydRhSO9lqrhqUoevsNLI9LZ8KuqQP+Oq2Nq0KgQOOi2kQJvtT8Am+viSm2Z2ZxNva6XRvcEXmgIqDvdtts7GvpskdtidwKqV2csltlWMQVoEopRfwUPod/q60gNEdE0vCNnklcPHRqP2G1K6YMBVXm9NNyjZK1d1zQM75xS8YnHs22GyYY1VamIFBykp6rEDsZPnKRstrhTVmPAySla7N2SuGuoWmVQxg3GeMLNByF78oklpoFvue1Q6f6cmEp1aKieqCG1yoBdDcFPyGmzD08oBkhV1arzxO/DPe6Q25oqCnFwe297csVTC3TAl+u3uDh6KZHfA5dEuhwPfJDZvHWg0a+VyvmKix3OoL1wVg0xeK847XBmLMBh91Jz2P9i97qmL3SKN0GafSTdFQoM8IA7PZvObW5tDh4u23E8nupxEheIyG3t6fjnimwfQPv2ta93cjo7b03bV/1y+8KF2TWhkK+FEIQCTVef5xZBOOjDd629LfK5c2zOsJ5pbgx8bL9Xjh3b1VcQPJDPs4twhY8hD0SjUeXZvS/f2xjWWg2GUl+dTZzf/+hGglYScXgdusWZ1cnT6Dqgvqn1P+KmIzca/gLGWfiiEOqNZwAAAABJRU5ErkJggg==" />
                        </td>
                    </tr>
                </table>
            </div>
        </footer>
    </div>
</body>

</html>
