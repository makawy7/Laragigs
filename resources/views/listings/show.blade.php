<x-layout>
    @include('partials._search')
    @if (isset($listing))
        <a href="{{ route('home') }}" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back
        </a>
        <div class="mx-4">
            <x-card class='p-10'>
                <div class="flex flex-col items-center justify-center text-center">
                    <img class="w-48 mr-6 mb-6"
                        src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/no-image.png') }}"
                        alt="" />

                    <h3 class="text-2xl mb-2">{{ $listing->title }}</h3>
                    <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>
                    <x-listing-tags :tagsCsv="$listing->tags" />
                    <div class="text-lg my-4">
                        <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
                    </div>
                    <div class="border border-gray-200 w-full mb-6"></div>
                    <div>
                        <h3 class="text-3xl font-bold mb-4">
                            Job Description
                        </h3>
                        <div class="text-lg space-y-6">
                            <p>
                                {{ $listing->description }}
                            </p>
                            <a href="{{ $listing->email }}"
                                class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80"><i
                                    class="fa-solid fa-envelope"></i>
                                Contact Employer</a>

                            <a href="{{ url($listing->website) }}" target="_blank"
                                class="block bg-black text-white py-2 rounded-xl hover:opacity-80"><i
                                    class="fa-solid fa-globe"></i> Visit
                                Website</a>
                        </div>
                    </div>
                </div>
            </x-card>
            @auth
                @if ($listing->user_id === auth()->user()->id)
                    <x-card class="mt-4 p-2 flex space-x-6">
                        <a href="{{ route('editListing', $listing->id) }}">
                            <li class="fa-solid fa-pencil"></li> Edit
                        </a>
                        <form method="POST" action="{{ route('destroyListing', $listing->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500">
                                <li class="fa-solid fa-trash"></li> Delete
                            </button>
                        </form>
                    </x-card>
                @endif
            @endauth
        </div>
    @endif
</x-layout>
