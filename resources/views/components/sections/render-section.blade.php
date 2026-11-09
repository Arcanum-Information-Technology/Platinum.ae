@props(['section'])

@php
    $componentName = str_replace('_', '-', $section->section_type);
    $data = app(\App\Services\PageBuilderService::class)->getSectionData($section);
@endphp

@if(view()->exists("components.sections.{$componentName}"))
    <x-dynamic-component :component="'sections.' . $componentName" :data="$data" />
@endif
