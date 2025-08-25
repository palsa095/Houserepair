@props(['id' => null, 'maxWidth' => 'md'])

<div x-data="{ open: false }"
     x-show="open"
     x-on:open-modal.window="if ($event.detail.id === '{{ $id }}') open = true"
     x-on:close-modal.window="open = false"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div @click.outside="open = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-{{ $maxWidth }} p-6">
        {{ $slot }}
    </div>
</div>
