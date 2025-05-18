<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Edit Loan or Deduction</h1>

  @if ($errors->any())
  <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('loans_and_deductions.update', $loansAndDeduction->id) }}" method="POST"
    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md">
    @csrf
    @method('PATCH')

    <div class="mb-4">
      <label for="employee_id" class="block text-gray-700 text-sm font-bold mb-2">Employee</label>
      <select name="employee_id" id="employee_id" class="form-select w-full border rounded px-3 py-2" required>
        @foreach ($employees as $employee)
        <option value="{{ $employee->id }}" {{ $loansAndDeduction->employee_id == $employee->id ? 'selected' : '' }}>
          {{ $employee->user->getFullName() }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
      <select name="type" id="type" class="form-select w-full border rounded px-3 py-2" required>
        @foreach ($types as $type)
        <option value="{{ $type }}" {{ $loansAndDeduction->type == $type ? 'selected' : '' }}>
          {{ ucfirst($type) }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
      <input type="text" name="name" id="name" value="{{ old('name', $loansAndDeduction->name) }}"
        class="form-input w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
      <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount</label>
      <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $loansAndDeduction->amount) }}"
        class="form-input w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
      <label for="remaining_balance" class="block text-gray-700 text-sm font-bold mb-2">Remaining Balance</label>
      <input type="number" step="0.01" name="remaining_balance" id="remaining_balance"
        value="{{ old('remaining_balance', $loansAndDeduction->remaining_balance) }}"
        class="form-input w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
      <label for="frequency" class="block text-gray-700 text-sm font-bold mb-2">Frequency</label>
      <select name="frequency" id="frequency" class="form-select w-full border rounded px-3 py-2" required>
        @foreach ($frequencies as $frequency)
        <option value="{{ $frequency }}" {{ $loansAndDeduction->frequency == $frequency ? 'selected' : '' }}>
          {{ ucfirst($frequency) }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="flex items-center justify-between">
      <button type="submit"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
        <span class="material-symbols-outlined mr-1">save</span>
        Update
      </button>
      <a href="{{ route('employees.show', $loansAndDeduction->employee_id) }}"
        class="text-blue-500 hover:text-blue-700 flex items-center">
        <span class="material-symbols-outlined mr-1">arrow_back</span>
        Back to Employee
      </a>
    </div>
  </form>
</x-app-layout>