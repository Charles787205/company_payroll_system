<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Payrolls</h1>
  <x-payroll.employee-table :employees="$employees" title="Upcoming Payrolls" :payrolls="$payrolls" />

</x-app-layout>