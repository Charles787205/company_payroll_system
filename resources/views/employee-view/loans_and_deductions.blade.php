<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Loans and Deductions</h1>

  <table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
      <tr>
        <th class="border border-gray-300 px-4 py-2">Type</th>
        <th class="border border-gray-300 px-4 py-2">Amount</th>
        <th class="border border-gray-300 px-4 py-2">Date</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($loansAndDeductions as $deduction)
      <tr>
        <!-- Loan/Deduction Type -->
        <td class="border border-gray-300 px-4 py-2">{{ $deduction->type }}</td>

        <!-- Amount -->
        <td class="border border-gray-300 px-4 py-2">₱{{ number_format($deduction->amount, 2) }}</td>

        <!-- Date -->
        <td class="border border-gray-300 px-4 py-2">{{ $deduction->created_at->format('Y-m-d') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="3" class="text-center border border-gray-300 px-4 py-2">No loans or deductions found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</x-app-layout>