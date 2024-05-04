<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex justify-center">
        <div class="py-3 px-4">
            <button onclick="togglePostsBox()"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                View Posts
            </button>
        </div>
    </div>
    <form action="{{ route('posts.update', ['post' => $post->id]) }} }}" enctype="multipart/form-data" method="POST"
        class="max-w-lg mx-auto p-4 bg-white dark:bg-gray-800 shadow-md rounded-lg mt-4">

        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}"
                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md text-white">
        </div>
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
            <textarea name="content" id="content" rows="3"
                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md text-white">{{ $post->content }}</textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
            <input type="file" name="images[]" multiple id="images"
                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md text-white">
        </div>
        <div class="flex justify-end">
            <button type="submit"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Submit
            </button>
        </div>
    </form>

    </div>

</x-app-layout>
