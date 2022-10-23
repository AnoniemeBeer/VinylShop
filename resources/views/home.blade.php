<x-vinylshop-layout>
    <x-slot name="description">New description</x-slot>
    <x-slot name="title">The Vinyl Shop</x-slot>
    <h1>The Vinyl Shop</h1>

    <p>Welcome to the website of The Vinyl Shop, a large online store with lots of (classic) vinyl records.</p>
    <hr class="my-4">
    <h2>heading 2</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, ipsum similique ullam, ratione accusamus officia harum excepturi perspiciatis, perferendis eum corrupti beatae voluptatibus incidunt explicabo ex qui debitis iure. Quos?</p>
    <h3>heading 3</h3>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minima voluptatem, recusandae eveniet ipsum dicta cupiditate reprehenderit error, inventore at unde quas saepe animi non similique qui! Cum quasi ab debitis?</p>
    @push('script')
        <script>
            console.log('The Vinyl Shop JavaScript works! 🙂')
        </script>
    @endpush
</x-vinylshop-layout>
