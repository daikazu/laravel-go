require('./bootstrap');

window.domready = require('domready');

// Disable Body Scroll
const bodyScrollLock = require('body-scroll-lock');
window.disableBodyScroll = bodyScrollLock.disableBodyScroll;
window.enableBodyScroll = bodyScrollLock.enableBodyScroll;

// Alpinejs
import Alpine from 'alpinejs'
window.Alpine = Alpine;

//Alpine Plugins
import intersect from '@alpinejs/intersect'
Alpine.plugin(intersect);

import persist from '@alpinejs/persist'
Alpine.plugin(persist);

import trap from '@alpinejs/trap'
Alpine.plugin(trap);


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

