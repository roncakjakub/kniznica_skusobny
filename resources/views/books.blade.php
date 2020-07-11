@extends('templates.app')
@section('content')

    <div class="container">
        <div class="row py-5">
            <div class="col-lg-12 mb-3">
                <a href="{{route('add_new_view')}}">Pridaj novú</a>
            </div>

            <form class="col-lg-3">
                <input type="text" class="mb-2 form-control" @if (request()->search_word) value="{{request()->search_word}}" @endif name="search_word" placeholder="Názov">
                <input type="date" class="mb-2 form-control" @if (request()->date_from) value="{{request()->date_from}}" @endif name="date_from" placeholder="Dátum od">
                <input type="date" class="mb-2 form-control" @if (request()->date_to) value="{{request()->date_to}}" @endif name="date_to" placeholder="Dátum do">

                <div class="has-search">
                    <label for="inputSort" onchange="this.form.submit()">Zoraď podĺa<br>
                        <select name="sort_by" id="inputSort">
                            <option value="name" @if (request()->sort_by)@if (request()->sort_by == 'name') selected @endif @endif>Názvu</option>
                            <option value="date" @if (request()->sort_by)@if (request()->sort_by == 'date') selected @endif @endif>Dátumu</option>
                        </select>
                </div>
                <button class="btn btn-secondary" type="submit">
                    Filtruj
                </button>
            </form>
            {{--            Časť pre knihy --}}
            <div class="col-lg-9">

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
                                    <div class="border p-2 text-primary mb-2">

                                <small class="card-title">Žáner: {{$book->genre->name}}</small> <br>
                                <small class="card-title">ISBN: {{$book->isbn}}</small> <br>
                                <small class="card-title">email: {{$book->email}}</small><br>
                                <small class="card-title">Počet strán: {{$book->pages}}</small><br>
                                <small class="card-title">Dátum vydania: {{$book->published_at}}</small>
                                    </div>

                                    <p class="card-text">{{$book->abstract}}</p>
                            </div>
                        </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
