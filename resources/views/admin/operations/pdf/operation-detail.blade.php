<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MIPO</title>
    <style>


        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #000;
            background: #fff;
            margin: 0px;
            padding: 0 25px 0 25px !important;
        }
        .pdf-wrapper {
            width: 100%;
            position: relative;
			      font-size: 13px;
			      color: #000;
            background: #fff;
            margin: 30px 0;
        }	
         table + table{margin-top: 6px;}
        /*  */
        .rightdatatable:last-child{border-bottom: none;}
    </style>
</head>
<body>
    <div class="pdf-wrapper">

      {{-- pdf head --}}
      <table style="width: 100%;">
				<tr style="border-bottom: 1px solid #707070">
					<th style="text-align: left;"><p>{{__('Operation') }}<span style="color: #707070;padding:0 0 0 11px;">{{ $operation->operation_type_number }}</span></p></th>
				</tr>
				<table class="" style="width:100%;">
					<tr>
						<td style="text-align:left;">{{ date('d-M-Y') }}</td>
						<td style="text-align:right;">
             <img alt="no-image" src="data:image/png;base64,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"/>
            </td>
					</tr>
				</table>
			</table>

    {{-- first table --}}
    <table style="width: 100%; border: 1px solid #707070;border-collapse: collapse;">
        <tr>
          <td style="border-collapse: collapse;border-right:1px solid #707070;padding:5px 12px;">
           <table style="width:50%;">
              <tr>
                <td>Name: {{ app('common')->lockOperationDetail($operation, []) }}  {{ round($operation->seller?->ratings_avg_rating_number, 2) }}/5</td>
              </tr>
              <tr>
                <td>Document’s Seller</td>
              </tr>
              <tr>
                <td>RUC/CI/DV: {{ $operation->seller?->issuer?->ruc_text_id  ?? ''}}</td>
              </tr>
              <tr>
                <td>Account Status: {{ $operation->seller?->user_level }}</td>
              </tr>
              <tr>
                <td>Mipo+: {{ __($operation->mipo_verified) }}</td>
              </tr>
            </table>
          </td>
          <td style="border-collapse: collapse;border-right:1px solid #707070;width:50%;">
            <table style="width:100%;border-collapse: collapse;">

              <tr style="border-bottom: 1px solid #707070;">
                <td style="text-align:left; padding:3px 12px">{{ __('BCP') }}</td>
                @if ($operation->bcp != '0' && !is_null($operation->bcp))
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->bcp == '1' ?  __('Yes')  :  __('No') }}</td>
                @else
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
                @endif
              </tr>

              <tr style="border-bottom: 1px solid #707070;">
                <td style="text-align:left; padding:3px 12px">{{ __('Infocheck') }}</td>
                @if ($operation->infocheck != '0' && !is_null($operation->infocheck))
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->infocheck == '1' ?  __('Yes')  :  __('No') }}</td>
                @else
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
                @endif
              </tr>

              <tr style="border-bottom: 1px solid #707070;">
                <td style="text-align:left; padding:3px 12px">{{__('Inforconf') }}</td>
                @if ($operation->inforconf != '0' && !is_null($operation->inforconf))
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->inforconf == '1' ?  __('Yes')  :  __('No') }}</td>
                @else
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
                @endif
              </tr>

              <tr>
                <td style="text-align:left; padding:3px 12px">{{__('Criterium') }}</td>
                @if ($operation->criterium != '0' && !is_null($operation->criterium))
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->criterium == '1' ?  __('Yes')  :  __('No') }}</td>
                @else
                <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
                @endif
              </tr>
            </table>
          </td>
        </tr>
    </table>

    {{-- second table --}}
    <table style="width: 100%; border: 1px solid #707070;border-collapse: collapse;">
      <tr>
        <td style="border-collapse: collapse;border-right:1px solid #707070;padding:5px 12px;">
         <table style="width:50%;">
            <tr>
              <td>Nombre: {{ $operation->issuer->company_name }}  {{ round($operation->issuer?->ratings_avg_rating_number, 2) }}</td>
            </tr>
            <tr>
              <td>Pagador del Documento</td>
            </tr>
            <tr>
              <td>RUC/CI/DV: {{ $operation->issuer->ruc_text_id }}</td>
            </tr>
           {{--  <tr>
              <td>Account Status: Bronze</td>
            </tr> --}}
            <tr>
              <td>Mipo+: {{ __($operation->issuer->registry_in_mipo) }}</td>
            </tr>
          </table>
        </td>
        <td style="border-collapse: collapse;border-right:1px solid #707070;width:50%;">
          <table style="width:100%;border-collapse: collapse;">
            
            <tr style="border-bottom: 1px solid #707070;">
              <td style="text-align:left; padding:3px 12px">{{ __('BCP') }}</td>
              @if ($operation->issuer->bcp != '0' && !is_null($operation->issuer->bcp))
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->issuer->bcp == '1' ?  __('Yes')  :  __('No')  }}</td>
              @else
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
              @endif
            </tr>

            <tr style="border-bottom: 1px solid #707070;">
              <td style="text-align:left; padding:3px 12px">{{ __('Inforconf') }}</td>
              @if ($operation->issuer->inforconf != '0' && !is_null($operation->issuer->inforconf))
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->issuer->inforconf == '1' ?  __('Yes')  :  __('No')  }}</td>
              @else
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
              @endif
            </tr>
            <tr style="border-bottom: 1px solid #707070;">
              <td style="text-align:left; padding:3px 12px">{{ __('Infocheck') }}</td>
              @if ($operation->issuer->infocheck != '0' && !is_null($operation->issuer->infocheck))
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->issuer->infocheck == '1' ?  __('Yes')  :  __('No')  }}</td>
              @else
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
              @endif
            </tr>

            <tr>
              <td style="text-align:left; padding:3px 12px">{{ __('Criterium') }}</td>
              @if ($operation->issuer->criterium != '0' && !is_null($operation->issuer->criterium))
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->issuer->criterium == '1' ?  __('Yes')  :  __('No')  }}</td>
              @else
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ __('N/A')}}</td>
              @endif
            </tr>
          </table>
        </td>
      </tr>
  </table>
      {{-- information table --}}
      <table style="width: 100%;border: 1px solid #707070;border-collapse: collapse;">
				<tr style="border-bottom: 1px solid #707070">
					<th style="text-align: left;padding:6px 0 8px 12px">{{ __('Information') }}</th>
				</tr>
				<table style="width:100%;border-collapse: collapse;border-left:1px solid #707070;border-right:1px solid #707070;border-bottom:1px solid #707070;">
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Type of Document')}}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">
              {{ ($operation->operation_type == 'Cheque') ? __('Check') : __($operation->operation_type) }}
            </td>
					</tr>
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('With or Without Recurso')}}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">
              {!! app('common')->responsibility($operation->responsibility) !!}
            </td>
					</tr>
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Payment Preferences') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ __($operation->preferred_payment_method)}}</td>
					</tr>
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Check Details') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">Post-Dated, Crossed, To The Carrier </td>
					</tr>
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">
              {{-- {{ __('Check’s Nominal Value') }} --}}
              @if ($operation->operation_type == 'Cheque')
                {!! __('Nominal Value of Check') !!}
              @else
                {!! __('Document’s Nominal Value') !!}
              @endif
            </td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{!! app('common')->currencyBySymbolPDF($operation->preferred_currency) !!} {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</td>
					</tr>
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Date of Issuance') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->issuance_date_iso }}</td>
					</tr>
          @if(!empty($operation->expire_date_iso))
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Expiration Date') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->expire_date_iso }}</td>
					</tr>
          @endif
          @if(!empty($operation->extra_expiration_days))
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Days for Expiration') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ ($operation->extra_expiration_days) }} {{ __('days') }}</td>
					</tr>
          @endif
          @if ($operation->operation_type == 'Cheque')
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Check Number')}}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->check_number }}</td>
					</tr>
          @endif
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Payer’s Bank') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->issuer_bank?->name }}</td>
					</tr>
          @if(!empty($operation->legal_direction))
					<tr style="border-bottom: 1px solid #707070;">
						<td style="text-align:left; padding:3px 12px">{{ __('Legal Address') }}</td>
						<td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->legal_direction }}</td>
					</tr>
          @endif

          @if(!empty($operation->legal_telephone))
            <tr style="border-bottom: 1px solid #707070;">
              <td style="text-align:left; padding:3px 12px">{{ __('Declared Phone') }}</td>
              <td style="text-align:right; padding:3px 12px;color:#707070;">{{ $operation->legal_telephone }}</td>
            </tr>
            @endif
				</table>
			</table>
      
   

      {{-- commercial reference --}}
      @if ($operation->references->count() > 0)
      <table style="width: 100%;border: 1px solid #707070;border-collapse: collapse;">
        <tr style="border-bottom: 1px solid #707070">
          <th style="text-align: left;padding:6px 0 8px 12px">{{ __('Commercial References')}}</th>
        </tr>
        <table style="width:100%;border-collapse: collapse;border-left:1px solid #707070;border-right:1px solid #707070;">
          <tr style="border-bottom: 1px solid #707070;">
            <th style="text-align: left;padding:3px 0 3px 12px">{{ __('Name and Last Name / Business') }}</th>
            <th style="text-align: left;padding:3px 0 3px 12px">{{ __('Email') }}</th>
            <th style="text-align: left;padding:3px 0 3px 12px">{{ __('Phone') }}</th>
            <th style="text-align: left;padding:3px 0 3px 12px">{{ __('Observation') }}</th>
          </tr>
          @if ($operation->references->count() > 0)
            @foreach ($operation->references as $key => $reference)
            <tr style="border-bottom: 1px solid #707070;">
                <td style="padding:3px 0 3px 12px">{{ $reference->name }}</td>
                <td style="padding:3px 0 3px 12px">{{ $reference->email }}</td>
                <td style="padding:3px 0 3px 12px">{{ $reference->phone_number }}</td>
                <td style="padding:3px 0 3px 12px">{{ $reference->company_name }}</td>
            </tr>
            @endforeach
          @endif
        </table>
      </table>
      @endif

      <table class="content-table" style="max-width: 100%; margin: 0 auto; margin-top: 10px; page-break-before:always; padding-top: 40px;">
        @if ($operation->documents && $operation->documents->count() > 0)
            @foreach ($operation->documents->chunk(2) as $documents)
                <tr style="width: 100% padding-top: 10px;">
                  @foreach ($documents as $document)
                    @if ($document->path != '')
                      @php
                        $file_ext = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                      @endphp
                      @if ($file_ext != 'pdf')
                        <td style="width: 50%"><img width="250" src="{{  app('common')->pdfImagePath($document->path) }}" alt="no-image" /></td>
                      @endif
                    @endif
                @endforeach
              </tr>
            @endforeach
        @endif
        @if ($operation->supportingAttachments && $operation->supportingAttachments->count() > 0)
            @foreach ($operation->supportingAttachments->chunk(2) as $supportingAttachments)
              <tr style="width: 100% padding-top: 10px;">
                  @foreach ($supportingAttachments as $attachment)
                    @if ($attachment->path != '')
                      @php
                        $file_ext = strtolower(pathinfo($attachment->path, PATHINFO_EXTENSION));
                      @endphp
                      @if ($file_ext != 'pdf')
                        <td  style="width: 50%"><img width="250" src="{{ app('common')->pdfImagePath($attachment->path) }}" alt="no-image" /></td>
                      @endif
                    @endif
                  @endforeach
              <tr>
            @endforeach
          @endif
      </table>
      
      {{-- bottom --}}
      <table class="footer" style="width: 100%;margin:24px 0 0 0;text-align:center;padding:8px 0;">
        <tr>
          <td><a href="javascript:;" style="color: #11295A;text-decoration:none;text-transform:uppercase;display:block">www.mipo.com.py</a></td>
        </tr>
      </table>
    </div>
</body>
</html>