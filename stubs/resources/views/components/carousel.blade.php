@once
<script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
@endonce
<div
    x-data="{
        skip: 3,
        next() {
            this.to((current, offset) => current + (offset * this.skip))
        },
        prev() {
            this.to((current, offset) => current - (offset * this.skip))
        },
        to(strategy) {
            let slider = this.$refs.slider
            let current = slider.scrollLeft
            let offset = slider.firstElementChild.getBoundingClientRect().width
            slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
        },
        focusableWhenVisible: {
            'x-intersect:enter'() {
                this.$el.removeAttribute('tabindex')
            },
            'x-intersect:leave'() {
                this.$el.setAttribute('tabindex', '-1')
            },
        }
    }"
    class="flex flex-col w-full"
>
    <div
        @keydown.right="next"
        @keydown.left="prev"
        tabindex="0"
        role="region"
        aria-labelledby="carousel-label"
        class="flex space-x-6"
    >
        <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

        <button @click="prev" class="text-6xl">
            <span aria-hidden="true">❮</span>
            <span class="sr-only">Skip to previous slide</span>
        </button>

        <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>

        <ul
            x-ref="slider"
            tabindex="0"
            role="listbox"
            aria-labelledby="carousel-content-label"
            class="flex w-full overflow-x-scroll snap-mandatory snap-x"
        >
            <li class="w-1/3 flex-shrink-0 flex flex-col items-center justify-center p-2 snap-start" role="option">
                <img class="mt-2 w-full" src="https://picsum.photos/400/200?random=1" alt="placeholder image">

                <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>
            </li>

            <li class="w-1/3 flex-shrink-0 flex flex-col items-center justify-center p-2 snap-start" role="option">
                <img class="mt-2 w-full" src="https://picsum.photos/400/200?random=2" alt="placeholder image">

                <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>
            </li>

            <li class="w-1/3 flex-shrink-0 flex flex-col items-center justify-center p-2 snap-start" role="option">
                <img class="mt-2 w-full" src="https://picsum.photos/400/200?random=3" alt="placeholder image">

                <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>
            </li>

            <li class="w-1/3 flex-shrink-0 flex flex-col items-center justify-center p-2 snap-start" role="option">
                <img class="mt-2 w-full" src="https://picsum.photos/400/200?random=4" alt="placeholder image">

                <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>
            </li>

            <li class="w-1/3 flex-shrink-0 flex flex-col items-center justify-center p-2 snap-start" role="option">
                <img class="mt-2 w-full" src="https://picsum.photos/400/200?random=5" alt="placeholder image">

                <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>
            </li>

            <li class="w-1/3 flex-shrink-0 flex flex-col items-center justify-center p-2 snap-start" role="option">
                <img class="mt-2 w-full" src="https://picsum.photos/400/200?random=6" alt="placeholder image">

                <button x-bind="focusableWhenVisible" class="px-4 py-2 text-sm">Do Something</button>
            </li>
        </ul>

        <button @click="next" class="text-6xl">
            <span aria-hidden="true">❯</span>
            <span class="sr-only">Skip to next slide</span>
        </button>
    </div>
</div>
