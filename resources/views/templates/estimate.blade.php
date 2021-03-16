<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $estimate['customer_name'] }}</title>
    
    <style>
    .invoice-box {
        max-width: 1000px;
        height: 100%;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                                Estimate #: {{ $estimate['estimate_id'] }}<br>
                                Created Date : {{ $estimate['created_date'] }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td style="text-align:right">
                                From
                            </td>
                            <td>:</td>
                            <td style="text-align:left">
                                @lang('owner.name')<br>
                                @lang('owner.mobile')<br>
                                @lang('owner.email')<br>
                                @lang('owner.address')
                            </td>
                            <td style="text-align:right">
                                To
                            </td>
                            <td>:</td>
                            <td>
                                {{ $estimate['customer_name'] }}<br>
                                {{ $estimate['customer_mobile'] }}<br>
                                {{ ($estimate['customer_email'])?$estimate['customer_email']    :'-' }}<br>
                                {{ $estimate['customer_address'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>   
            <tr class="heading">
                <td>
                    Item Name
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            @foreach ($estimate['data'] as $e)
            <tr class="item">
                <td>
                        {{ ($e->name)?$e->name:'-' }} <br>
                        <small> - {{ ($e->description)?$e->description:'-' }}</small>
                </td>
                
                <td>
                    {{ ($e->price)?$e->price.".00 / ".$e->maap."":'-' }}
                </td>
            </tr>    
            @endforeach
            <tr class="total">
                <td></td><td></td>
            </tr>
            @if($estimate['note'] != "")
            <tr><td></td></tr>
            <tr class="heading">
                <td colspan="2">
                    Note : 
                </td>
            </tr>
            <tr class="item">
                <td colspan="2">
                    @foreach (explode(',',$estimate['note']) as $sent)
                        - {{$sent}}<br>
                    @endforeach
                </td>
            </tr>
            @endif
        </table>
        
    </div>
</body>
</html>