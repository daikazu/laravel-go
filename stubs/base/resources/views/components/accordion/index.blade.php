@props(['active'])
<div x-data="{ active: {{$active}} }" class="space-y-4">
   {{$slot}}
</div>
