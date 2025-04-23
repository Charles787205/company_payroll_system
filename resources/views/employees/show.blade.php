<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Employee Details</h1>

  <!-- Employee Details -->
  <div class="mb-6">
    <h2 class="text-xl font-semibold">Personal Information</h2>
    <p><strong>Name:</strong> {{ $employee->user->first_name }} {{ $employee->user->middle_name }}
      {{ $employee->user->last_name }}</p>
    <p><strong>Email:</strong> {{ $employee->user->email }}</p>
    <p><strong>Position:</strong> {{ $employee->position->title }}</p>
    <p><strong>Salary:</strong> ₱{{ number_format($employee->salary, 2) }}</p>
    <p><strong>Hire Date:</strong> {{ $employee->hire_date }}</p>
    <p><strong>Birthdate:</strong> {{ $employee->birthdate }}</p>
    <p><strong>Address:</strong> {{ $employee->address }}</p>
    <p><strong>SSS Number:</strong> {{ $employee->sss_number }}</p>
    <p><strong>Pag-IBIG Number:</strong> {{ $employee->pagibig_number }}</p>
    <p><strong>PhilHealth Number:</strong> {{ $employee->philhealth_number }}</p>
    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary mt-4">Edit Employee Details</a>
  </div>

  <!-- Loans and Deductions -->
  <div class="mb-6">
    <h2 class="text-xl font-semibold">Loans and Deductions</h2>
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2">Name</th>
          <th class="border border-gray-300 px-4 py-2">Type</th>
          <th class="border border-gray-300 px-4 py-2">Amount</th>
          <th class="border border-gray-300 px-4 py-2">Remaining Balance</th>
          <th class="border border-gray-300 px-4 py-2">Frequency</th>
          <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($employee->loansAndDeductions as $item)
        <tr>
          <td class="border border-gray-300 px-4 py-2">{{ $item->name }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ ucfirst($item->type) }}</td>
          <td class="border border-gray-300 px-4 py-2">₱{{ number_format($item->amount, 2) }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ $item->remaining_balance ?? 'N/A' }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ ucfirst($item->frequency) }}</td>
          <td class="border border-gray-300 px-4 py-2 flex justify-center w-full gap-4">
            <a href="{{ route('loans_and_deductions.edit', $item->id) }}"
              class=" flex-1 btn btn-sm btn-warning">Edit</a>
            <form class="flex w-full flex-1" action="{{ route('loans_and_deductions.destroy', $item->id) }}"
              method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="flex w-full justify-center btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center border border-gray-300 px-4 py-2">No loans or deductions found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Add Loan or Deduction -->
  <div class="w-[40em] bg-white shadow p-4 rounded ">
    <h2 class="text-xl font-semibold">Add Loan or Deduction</h2>
    <form action="{{ route('loans_and_deductions.store') }}" method="POST">
      @csrf
      <input type="hidden" name="employee_id" value="{{ $employee->id }}">
      <div class="mb-4">
        <label for="type" class="block font-medium">Type</label>
        <select name="type" id="type"
          class="rounded shadow-inner px-2 shadow-neutral-700 border form-select mt-1 block w-full" required>
          <option value="loan">Loan</option>
          <option value="deduction">Deduction</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="name" class="block font-medium">Name </label>
        <input type="text" name="name" id="name"
          class="rounded shadow-inner px-2 shadow-neutral-700 border form-input mt-1 block w-full"
          placeholder="Enter name (e.g., Car Loan, Health Deduction)">
      </div>
      <div class="mb-4">
        <label for="amount" class="block font-medium">Amount</label>
        <input type="number" name="amount" id="amount"
          class="rounded shadow-inner px-2 shadow-neutral-700 border form-input mt-1 block w-full" required>
      </div>
      <div class="mb-4">
        <label for="remaining_balance" class="block font-medium">Remaining Balance</label>
        <input type="number" name="remaining_balance" id="remaining_balance"
          class="rounded shadow-inner px-2 shadow-neutral-700 border form-input mt-1 block w-full">
      </div>
      <div class="mb-4">
        <label for="frequency" class="block font-medium">Frequency</label>
        <select name="frequency" id="frequency"
          class="rounded shadow-inner px-2 shadow-neutral-700 border form-select mt-1 block w-full" required>
          <option value="monthly">Monthly</option>
          <option value="bi-weekly">Bi-Weekly</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
</x-app-layout>