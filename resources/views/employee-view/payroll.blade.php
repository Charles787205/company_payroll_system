<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Payrolls</h1>
  <x-employee-view.payroll-table title="My Payroll" :payrolls="$payrolls" />

</x-app-layout>