@extends('templates.app')
@section('content')

    <div class="container">
        <div class="row py-5">

            {{--            Časť pre knihy --}}
            <div class="col-lg-12">
                <form class="row py-2 justify-content-between">
                    <a href="{{route('add_new_view')}}">Pridaj novú</a>
                    <div class="has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" placeholder="Vyhľadávaj">
                    </div>
                </form>
                <div class="row py-2">

                @foreach($books as $book)
                        <div class="card col-4 position-relative">
                            <button onclick="deleteConfirmation(this, '{{route("delete_Book", ['book' =>  $book->id] )}}', '{{csrf_token()}}')" class="position-absolute btn btn-icons btn-rounded btn-danger">X</button>

                            @if(!$book->resource)
                                <img class="card-img-top" src="{{asset('storage/no-img.jpg')}}" alt="Obrázok sa nenačítal">
                            @else
                                <img class="card-img-top" src="{{$book->resource->url}}" alt="Obal knihy">
                            @endif
                                <div class="card-body">
                                <h5 class="card-title">{{$book->name}}</h5>
                                <small class="card-title">Žáner: {{$book->genre->name}}</small> <br>
                                <small class="card-title">ISBN: {{$book->isbn}}</small> <br>
                                <small class="card-title">email: {{$book->email}}</small>
                                <p class="card-text">{{$book->abstract}}</p>
                            </div>
                        </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
