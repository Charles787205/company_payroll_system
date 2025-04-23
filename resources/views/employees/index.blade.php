<x-app-layout>
  <div class="flex flex-col h-full w-full gap-2">
    <div class="flex justify-end">
      <a href="/employees/create" class="btn">Add Employee</a>
    </div>
    @includeIf('components.employees.employee-table')
  </div>
</x-app-layout>