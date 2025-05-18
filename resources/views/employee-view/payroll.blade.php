<x-app-layout>
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-2">My Payroll History</h1>
    <p class="text-gray-500 text-sm">View your payment history, download payslips, and check attendance details</p>
  </div>
  
  <x-employee-view.payroll-table title="Payroll Records" :payrolls="$payrolls" />

</x-app-layout>