
<div x-data="{ open: false }">
    <!-- Button -->
    <button @click="open = true" type="button" class="bg-white border border-black px-4 py-2 focus:outline-none focus:ring-4 focus:ring-aqua-400">
        Open dialog
    </button>

    <!-- Modal -->
    <div
        x-show="open"
        @keydown.escape.prevent.stop="open = false"
        role="dialog"
        aria-modal="true"
        x-id="['modal-title']"
        :aria-labelledby="$id('modal-title')"
        class="fixed inset-0 overflow-y-auto"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Panel -->
        <div
            x-show="open" x-transition
            @click="open = false"
            class="relative min-h-screen flex items-center justify-center p-4"
        >
            <div
                @click.stop
                x-trap.noscroll.inert="open"
                class="relative max-w-2xl w-full bg-white border border-black p-8 overflow-y-auto"
            >
                <!-- Title -->
                <h2 class="text-3xl font-medium" :id="$id('modal-title')">Confirm</h2>
                <!-- Content -->
                <p class="mt-2 text-gray-600">Are you sure you want to learn how to create an awesome modal?</p>
                <!-- Buttons -->
                <div class="mt-8 flex space-x-2">
                    <button type="button" @click="open = false" class="bg-white border border-black px-4 py-2 focus:outline-none focus:ring-4 focus:ring-aqua-400">
                        Confirm
                    </button>
                    <button type="button" @click="open = false" class="bg-white border border-black px-4 py-2 focus:outline-none focus:ring-4 focus:ring-aqua-400">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
