<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex justify-center">
        <div class="py-3 px-4">
            <a href="{{ route('posts.index') }}"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                View Posts
            </a>
        </div>
    </div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-200 px-4 py-6">
                <h2 class="text-xl font-semibold text-gray-800">View Post</h2>
                <p class="text-gray-600">View post details.</p>
            </div>
            <div class="px-6 py-8">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $post->title }}</h3>
                    <p class="text-gray-600">{{ $post->created_at->format('M d, Y') }}</p>
                </div>
                <div class="mt-4">
                    <h4 class="text-lg font-semibold text-gray-800">Description</h4>
                    <p class="text-gray-700">{{ $post->content }}</p>
                </div>
                @if ($post->images)
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-800">Images</h4>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            @foreach (explode(',', $post->images) as $image)
                                <div>
                                    <img src="{{ asset('postImages/' . $image) }}" alt="Post Image"
                                        class="w-full h-auto">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
