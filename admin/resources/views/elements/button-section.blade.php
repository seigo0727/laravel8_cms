@if(isset($section) && !$section->isEmpty())
@php
$buttons = $section->getButtons();
@endphp
@foreach($buttons as $button)
    @php
        $attrs = [];
        if(!empty($button['attr'])){
            foreach($button['attr'] as $key => $value){
                $attrs[] = sprintf('%s="%s"', e($key), e($value));
            }
        }
    @endphp
        <a {!! implode(' ', $attrs) !!}>{!! $button['label'] !!}</a>
    @endforeach
@endif
