<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="{{$scriptUrl}}"></script>
        <script type="text/javascript">
            window.onload = function () {

            var styles = {
                'input-background-color' : '#453454',
                'input-text-color': '#B22222',
                'input-border-color' : '#CCCCCC',
                'input-placeholder-color' : '#999999',
                'button-background-color' : '#5CB85C',
                'button-text-color' : '#FFFFFF',
                'button-border-color' : '#4CAE4C',
                'form-background-color' : '#999999',
                'form-border-color' : '#DDDDDD',
                'header-background-color' : '#F5F5F5',
                'header-text-color' : '#333333',
                'hr-border-color' : '#B22222'
            };

            options = {
                styles: styles
            }

            Bancard.Checkout.createForm('iframe-container', '{{$processId}}', options);
            };
        </script>
    </head>
    <body>
        <h1>iFrame vPos</h1>

        <div style="height: 130px; width: 100%; margin: auto" id="iframe-container"/>
    </body>
</html>
