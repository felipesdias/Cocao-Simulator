@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Olá!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
<strong>
    {{ $actionText }}
</strong>
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Obrigado, Equipe MedYes
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
Se você teve problemas ao clicar no botão "{{ $actionText }}", copie e cole o link abaixo
em seu navegador:  [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
