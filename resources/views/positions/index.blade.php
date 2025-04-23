<x-app-layout>
  <div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Positions</h1>
    <a href="{{ route('positions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Position</a>
    <table class="table-auto w-full mt-4">
      <thead>
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Description</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($positions as $position)
        <tr>
          <td class="border px-4 py-2">{{ $position->title }}</td>
          <td class="border px-4 py-2">{{ $position->description }}</td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-app-layout>