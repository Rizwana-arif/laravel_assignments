<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
 
        body {
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #3498db;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar h1 {
            float: left;
            margin: 0;
            padding: 14px 20px;
            color: #f2f2f2;
        }

        .container {
            padding: 20px;
            margin: 0 auto; /* Center the container */
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff; /* Add background color to distinguish from navbar */
            width: 80%; /* Adjust width as needed */
            max-width: 1000px; /* Set maximum width */
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
        }
        .post-images img {
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <h1>Move on the page</h1>
    <a href="{{ route('register') }}">Register</a>
    <a href="{{ route('login') }}">Login</a>
</nav>
@if(isset($errorMessage))
    <div class="alert alert-danger">
        {{ $errorMessage }}
    </div>
@endif
<div class="container">
    <table id="dataTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->title }}</td>
                    {{-- <td>{{ str_limit($post->content, 10, '...') }}</td> --}}
                    <td>{{ $post->content }}</td>

                    <td>
                        @php
                            $images = explode(',', $post->images);
                        @endphp
                  <div class="flex flex-wrap post-images">
                    @foreach ($images as $image)
                        <img src="{{ asset('postImages/' . $image) }}" alt="Post Image"
                             width="60" height="50">
                    @endforeach
                </div>
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary btn-sm"><i
                                class="fa-solid fa-eye"></i></a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete?');">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success btn-sm"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

</body>
</html>
