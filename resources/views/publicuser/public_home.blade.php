@extends('layouts.app')

@section('content')


<div class="row">
        <div class="col">
                <div>
                        <a href="{{ route('feed') }}">FEED</a> 
                </div>
        </div>
        <div class="col mb-3">
                @error('search')
                        <p class="alert alert-danger">{{ $message}}</p>
                @enderror


                @error('followError')
                <p class="alert alert-danger">{{ $message}}</p>
                 @enderror
                
                
                <form method="POST" action="{{ route('user_search') }}">
                        @csrf
                        <div class="form-div">
                                <input name="search" type="text"  class="form-control" placeholder=" Type the user name here to search, then click the name to follow"> 
                        </div>
                        <button type="submit" class="btn btn-primary">SEARCH</button>
                </form>


                @if (Session::has('search'))
                <p class="mt-4"><span class="alert  alert-success">
                        {{ Session::get('search') }}
                </span></p>
                @endif


                @if (Session::has('users'))
                       @forelse ( Session::get('users')  as $user)
                       <div>
                                <form method="POST" action="{{ route('follow') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button class="btn btn-info">{{ $user->name }}</button>
                                </form>
                        </div>  
                       @empty
                               
                       @endforelse 
                @endif
                
        </div>

        <div class="col">
                
        </div>

       </div>

        <div class="row">

               
                <div class="col">

                </div>

                <div class="col">
                        @if (Session::has('create'))
                               <p class="alert alert-success">{{ session('create')}}</p>
                        @endif
                    <form action="{{ route('user_create') }}" method="post">
                        @csrf
                            <textarea name="post" class="form-control" cols="10" rows="5">
                                        {{ old('post') }}
                            </textarea>

                            <button class="btn btn-success" type="submit">MAKE A POST</button>
                    </form>

                </div>

                <div class="col">
                                
                </div>
                

        </div>

        <div class="row">

                <div class="col">

                </div>

                <div class="col mt-5">
                    {{-- <form action="" method="post">
                        @csrf
                
                            <button class="btn btn-success" type="submit">MAKE A COMMENT</button>
                    </form> --}}

                </div>

                <div class="col">
                                
                </div>
                

        </div>

        
        <script>

        </script>
@endsection