<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Employees with Loans and Deductions</h1>

  <table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
      <tr>
        <th class="border border-gray-300 px-4 py-2">Employee Name</th>
        <th class="border border-gray-300 px-4 py-2">Number of Loans/Deductions</th>
        <th class="border border-gray-300 px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employeesWithLoansAndDeductions as $employee)
      <tr>
        <td class="border border-gray-300 px-4 py-2">{{ $employee->user->getFullName() }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ $employee->loans_and_deductions_count }}</td>
        <td class="border border-gray-300 px-4 py-2">
          <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-primary">View</a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="3" class="text-center border border-gray-300 px-4 py-2">No employees with loans or deductions
          found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</x-app-layout>