@php $prefix = $prefix ?? '' @endphp

<div class="mb-4">
    <label for="{{ $prefix }}name" class="block mb-1 text-sm font-medium text-gray-700">Name</label>
    <input type="text" name="name" id="{{ $prefix }}name" class="w-full px-3 py-2 border rounded" required>
</div>

<div class="mb-4">
    <label for="{{ $prefix }}major" class="block mb-1 text-sm font-medium text-gray-700">Major</label>
    <input type="text" name="major" id="{{ $prefix }}major" class="w-full px-3 py-2 border rounded" required>
</div>

<div class="mb-4">
    <label for="{{ $prefix }}email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
    <input type="email" name="email" id="{{ $prefix }}email" class="w-full px-3 py-2 border rounded" required>
</div>

<div class="mb-4">
    <label for="{{ $prefix }}phone" class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
    <input type="text" name="phone" id="{{ $prefix }}phone" class="w-full px-3 py-2 border rounded" required>
</div>

<div class="mb-4">
    <label for="{{ $prefix }}description" class="block mb-1 text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="{{ $prefix }}description" class="w-full px-3 py-2 border rounded"></textarea>
</div>