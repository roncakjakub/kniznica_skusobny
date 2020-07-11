@extends('templates.app')
@section('content')

    <div class="container">
        <div class="row py-5">
            {{--            Časť pre formulár --}}
            <div class="col-lg-12">
                    <a href="{{route('index')}}">Návrat ku kolekcii</a>
                    <h5>Formulár</h5>

                <form class="border rounded p-3" action="{{route('add_book')}}" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="inputImage">Titulný obrázok diela</label>
                        <input type="file" class="form-control" id="inputImage" name="image">
                    </div>
                    <div class="form-group">
                        <label for="inputname">Názov</label>
                        <input type="text" class="form-control" id="inputname" required name="name" max="255" placeholder="Jankove dobrodružstvá">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email autora</label>
                        <input type="email" class="form-control" id="inputEmail" required name="email" value="@">
                    </div>
                    <div class="form-group">
                        <label for="inputPages">Strany knihy</label>
                        <input type="number" class="form-control" id="inputPages" min="1" required name="pages">
                    </div>
                    <div class="form-group">
                        <label for="inputISBN">ISBN</label>
                        <input type="text" class="form-control" id="inputISBN" name="isbn" max="40" required placeholder="SK-80-...">
                    </div>
                    <div class="form-group">
                        <label for="inputAbstract">Abstrakt</label>
                        <textarea type="text" class="form-control" id="inputAbstract" required name="abstract"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputDate">Dátum publikácie</label>
                        <input type="date" class="form-control" id="inputDate" required name="date">
                    </div>
                    <div class="form-group">
                        <label for="inputTime">Čas publikácie</label>
                        <input type="time" class="form-control" id="inputTime" required name="time">
                    </div>
                    <div class="form-group">
                        <label for="inputGenre">Žáner <br>
                        <small>Vyber zo zoznamu alebo vytvor nový</small></label>

                        <select type="text" required class="form-control" id="inputGenre" onchange="checkGenreSelect(this)" name="genre_id">
                            <option value="default" selected>Vyber...</option>

                        @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->name}}</option>
                            @endforeach
                        </select>
                        @csrf
                        <input type="text" required oninput="checkGenreInput(this)" class="form-control" id="inputNewGenre" name="genre" placeholder="Nový žáner">
                    </div>

                    <button type="submit" class="btn btn-primary">Nahraj</button>
                </form>
            </div>

        </div>
    </div>

@endsection
