require('./bootstrap');
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import intersect from '@alpinejs/intersect'
import focus from '@alpinejs/focus'
import collapse from '@alpinejs/collapse'
import 'focus-visible'


// Alpinejs
// Call Alpine.
window.Alpine = Alpine
Alpine.plugin(collapse)
Alpine.plugin(persist)
Alpine.plugin(intersect);
Alpine.plugin(focus);
Alpine.start()


function makeScrollToEvent(listenerName = 'app:scroll-to') {
    window.addEventListener(listenerName, (ev) => {
        ev.stopPropagation();
        let selector = ev?.detail?.query;
        if (!selector) return;
        let el = window.document.querySelector(selector);
        if (!el) return;
        try {
            el.scrollIntoView({
                behavior: 'smooth',
            });
        } catch {
        }

    }, false);
}

makeScrollToEvent();

// LIVEWIRE EXAMPLE
// $this->dispatchBrowserEvent('app:scroll-to', [
//     'query' => '#section-billing-address',
// ]);

