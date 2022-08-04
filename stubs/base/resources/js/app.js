import './bootstrap';
import Alpine from 'alpinejs'
import Intersect from '@alpinejs/intersect'
import Persist from '@alpinejs/persist'
import Focus from '@alpinejs/focus'
import Collapse from '@alpinejs/collapse'


/* Alpinejs */
window.Alpine = Alpine
Alpine.plugin(Collapse)
Alpine.plugin(Persist)
Alpine.plugin(Intersect);
Alpine.plugin(Focus);
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

