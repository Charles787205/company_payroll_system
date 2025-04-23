<x-app-layout>
  <!-- General Report -->
  <x-general-report :total-employees="$totalEmployees" :approved-payrolls="$approvedPayrolls"
    :pending-payrolls="$pendingPayrolls" />
  <!-- End General Report -->

  <!-- Start Analytics -->
  @include('index.analytics-1')
  <!-- End Analytics -->

  <!-- Sales Overview -->
  @include('index.salesOverview')
  <!-- End Sales Overview -->

  <!-- Start Numbers -->
  @include('index.numbers')
  <!-- End Numbers -->

  <!-- Start Quick Info -->
  @include('index.quickInfo')
  <!-- End Quick Info -->
</x-app-layout>