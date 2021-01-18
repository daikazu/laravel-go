require('./bootstrap');

require('alpinejs');

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
