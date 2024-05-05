<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .custom-btn {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        text-decoration: none;
        color: #fff;
    }

    .custom-btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .custom-btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .custom-btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex justify-center">
        <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-md rounded-lg mt-4 ">
            @if ($errors->any())
                <div id="errorMessage" class="bg-red-500 text-white py-2 px-4 rounded mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    setTimeout(function() {
                        var errorMessage = document.getElementById('errorMessage');
                        errorMessage.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                </script>
            @endif


            @if (session('success'))
                <div id="successMessage"
                    class="bg-green-500 text-white py-2 px-4 rounded mt-4 w-50 justify-content-center">
                    {{ session('success') }}
                </div>
                <script>
                    // Automatically hide the success message after 5 seconds
                    setTimeout(function() {
                        var successMessage = document.getElementById('successMessage');
                        successMessage.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                </script>
            @endif


            <div id="postsBox">
                <div class="flex justify-center">
                    <div class="py-3 px-4">
                        <button onclick="toggleNewPostForm()"
                            class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Add New Post
                        </button>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-md rounded-lg mt-4">
                        @if ($posts->isEmpty())
                            <p class="text-center text-gray-600 dark:text-gray-400 py-4">You still not posted any thing
                            </p>
                        @else
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-white">ID</th>
                                        <th class="px-4 py-2 text-white">Title</th>
                                        <th class="px-4 py-2 text-white">Content</th>
                                        <th class="px-4 py-2 text-white">Image</th>
                                        <th class="px-4 py-2 text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td class="border px-4 py-2 text-white">{{ $count++ }}</td>
                                            <td class="border px-4 py-2 text-white">{{ $post->title }}</td>
                                            {{-- <td class="border px-4 py-2 text-white">{{ str_limit($post->content, 10, '...') }}</td> --}}
                                            <td class="border px-4 py-2 text-white">{{ $post->content }}</td>

                                            <td class="border px-4 py-2 text-white">
                                                @php
                                                    $images = explode(',', $post->images);
                                                @endphp
                                          <div class="flex flex-wrap">
                                            @foreach ($images as $image)
                                                <img src="{{ asset('postImages/' . $image) }}" alt="Post Image"
                                                    class="border rounded-full m-2" width="100" height="100">
                                            @endforeach
                                        </div>
                                            </td>
                                            <td class="border px-4 py-2 text-white">
                                                <a href="{{ route('posts.show', $post->id) }}"
                                                    class="custom-btn custom-btn-secondary"><i
                                                        class="fa-solid fa-eye"></i></a>
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="custom-btn custom-btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete?');"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                </form>
                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                    class="custom-btn custom-btn-success"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- New Post Form -->
    <div id="newPostForm" class="hidden">
        <div class="flex justify-center">
            <div class="py-3 px-4">
                <button onclick="togglePostsBox()"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    View Posts
                </button>
            </div>
        </div>
        <form action="{{ route('posts.store') }}" enctype="multipart/form-data" method="POST"
            class="max-w-lg mx-auto p-4 bg-white dark:bg-gray-800 shadow-md rounded-lg mt-4">
            @csrf

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md text-white">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                <textarea name="content" id="content" rows="3"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md text-white"></textarea>
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

    <script>
        function togglePostsBox() {
            var postsBox = document.getElementById('postsBox');
            var newPostForm = document.getElementById('newPostForm');

            postsBox.classList.toggle('hidden');
            newPostForm.classList.add('hidden');
        }

        function toggleNewPostForm() {
            var postsBox = document.getElementById('postsBox');
            var newPostForm = document.getElementById('newPostForm');

            postsBox.classList.add('hidden');
            newPostForm.classList.toggle('hidden');
        }
    </script>

</x-app-layout>
