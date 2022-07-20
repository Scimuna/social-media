@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('user_index') }}">POST</a>
    </div>
    <div class="row">

        <div class="col">

        </div>

        <div class="col mt-5">
            @if (@$posts)
                {{-- {{ dd($posts) }} --}}
                @forelse ($posts as $post)
                    <div class="row">
                        <div class="col">
                            {{-- {{ dd($post) }} --}}


                            @forelse ($post as $_post)
                                {{-- {{ dd($_post) }} --}}
                                <p>{{ $_post['post'] }}

                                    @can('check_user', $_post)
                                        @if (Session::has('post_del'))
                                            <p class="alert alert-info">{{ session('post_del') }}</p>
                                        @endif
                                    <form method="POST" action="{{ route('del_post') }}">
                                        @csrf
                                        @method('delete')

                                        <button value="{{ $_post->id }}" type="submit" class="btn btn-danger"
                                            name="id">Delete Post</button>
                                    </form>
                                @endcan


                                </p>

                                <hr>
                                <form method="post" action='{{ route('user_comment') }}'>
                                    @csrf
                                    <textarea class="form-control" name="post" cols="2" rows='2'></textarea>
                                    <input name="post_id" type="hidden" value="{{ $_post->id }}">
                                    <button class="btn btn-primary">Comment</button>
                                </form>

                                @forelse ($_post->comments as $comment)
                                    <p>{{ $comment->comments }}</p>

                                @empty
                                @endforelse
                            @empty      
                                <p>No post</p>
                            @endforelse



                        </div>
                    </div>


                @empty
                    <p>There is no post available for now!</p>
                @endforelse
            @else
            @endif

        </div>

        <div class="col">

        </div>


    </div>



@endsection
