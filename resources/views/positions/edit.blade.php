<x-app-layout>
  <form action="{{ route('positions.update', $position->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- ...existing form fields... -->

    <div class="flex items-center justify-between">
      <button type="submit"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
        <span class="material-symbols-outlined mr-1">edit</span>
        Update Position
      </button>
      <a href="{{ route('positions.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
        <span class="material-symbols-outlined mr-1">arrow_back</span>
        Back to Positions
      </a>
    </div>
  </form>
</x-app-layout>