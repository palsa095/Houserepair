@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
     class="fixed top-5 right-5 bg-emerald-500 text-white px-4 py-2 rounded shadow">
    <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
</div>
@endif