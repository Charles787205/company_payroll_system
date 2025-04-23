@props(['disabled' => false])

<input @disabled($disabled)
  {{ $attributes->merge(['class' => 'px-2 border-gray-500 focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm']) }}>