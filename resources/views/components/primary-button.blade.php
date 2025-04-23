<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-bs-primary']) }}>
    {{ $slot }}
</button>