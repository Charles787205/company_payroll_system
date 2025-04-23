<x-app-layout>
  <div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add Position</h1>
    <form method="POST" action="{{ route('positions.store') }}">
      @csrf
      <div class="mb-4">
        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
        <input type="text" name="title" id="title" class="border border-gray-300 rounded-md w-full" required>
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea name="description" id="description" class="border border-gray-300 rounded-md w-full"></textarea>
      </div>
      <div class="mb-4">
        <label for="base_salary" class="block text-gray-700 text-sm font-bold mb-2">Base Salary</label>
        <input type="number" name="base_salary" id="base_salary" class="border border-gray-300 rounded-md w-full"
          required>
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
    </form>
  </div>
</x-app-layout>