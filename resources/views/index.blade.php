<x-app-layout>
  <!-- General Report -->
  @include('index.generalReport')
  <!-- End General Report -->

  <!-- strat Analytics -->
  @include('index.analytics-1')
  <!-- end Analytics -->

  <!-- Sales Overview -->
  @include('index.salesOverview')
  <!-- end Sales Overview -->

  <!-- start numbers -->
  @include('index.numbers')
  <!-- end numbers -->

  <!-- start quick Info -->
  @include('index.quickInfo')
  <!-- end quick Info -->


</x-app-layout>