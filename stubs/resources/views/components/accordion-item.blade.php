@props(['id', 'title'])
<div x-data="{
        id: {{$id}},
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            this.active = value ? this.id : null
        }
    }" role="region" class="border border-black">
    <h2>
        <button
            @click="expanded = !expanded"
            :aria-expanded="expanded"
            class="flex items-center justify-between w-full font-bold text-xl px-6 py-3"
        >
            <span>{{ $title }}</span>
            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse>
        {{$slot}}
    </div>
</div>
