@extends('layouts/app')

@section('title', 'editCollection')

@section('content')

        <x-header firstname="{{ $user->firstname }}" />

        <h1 class="card__title--headerThird">Edit Collection</h1>
        @if ($errors->any())
            @component('components/alert')
                @slot('type') danger @endslot
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endcomponent
        @endif

        <div class="form-group">
            <form method="POST" id="editNftForm" action="{{ '/collection/editCollection' }}" enctype='multipart/form-data'>
                @csrf

                <h2 class="form-group__title">Edit a new masterpiece</h2>
                <input type="hidden" name="id" value="{{ $collection->id }}">

                <label class="form-group__label" for="cTitle">Collection title</label><br>
                <input class="form-group__input" type="text" id="cTitle" value="{{ $collection->title }}"
                    name="collectionTitle"><br>

                <label class="form-group__label" for="cDescription">Collection description</label><br>
                <textarea class="form-group__input" type="text" id="cDescription"  name="collectionDescription">{{ $collection->description }}</textarea><br>

                <input type="submit" name="upload">

            </form>
        </div>
        <script>
            var path = "{{ url('homepage/action') }}";

            $('#search').typeahead({


                source: function(query, process) {

                    return $.get(path, {
                        term: query,
                        category: $("select#category").val()

                    }, function(data) {
                        return process(data);

                    });

                }

            });

            let option = document.getElementById("option");
            option.style.display = "none";

            function priceVisible() {
                option.innerHTML = `<option value="">Select</option>`;
                option.innerHTML += `<option id="PriceLH" value="PriceLH">Price LOW to HIGH</option>`;
                option.innerHTML += `<option id="HLPrice" value="PriceHL">Price HIGH to LOW</option>`;
            }

            function areaVisible() {
                option.innerHTML = `<option value="">Select</option>`;
                option.innerHTML += `<option id="AreaLH" value="AreaLH">Area LOW to HIGH</option>`;
                option.innerHTML += `<option id="HLArea" value="AreaHL">Area HIGH to LOW</option>`;
            }

            function typeVisible() {
                option.innerHTML = `<option value="">Select</option>`;
                option.innerHTML += `<option id="TypeAZ" value="TypeAZ">Object type title (A-Z)</option>`;
                option.innerHTML += `<option id="ZAType" value="TypeZA">Object type title (Z-A)</option>`;
            }


            let filter = document.getElementById("filter");

            filter.addEventListener("change", function(e) {
                let selectedIndex = filter.selectedIndex;
                let selectedValue = filter[selectedIndex].value;
                console.log(selectedValue);

                if (selectedValue == 'Price') {
                    option.style.display = "inline-block";
                    priceVisible();
                } else if (selectedValue == "Area") {
                    option.style.display = "inline-block";
                    areaVisible();
                } else if (selectedValue == "Type") {
                    option.style.display = "inline-block";
                    typeVisible();
                } else {
                    option.style.display = "none";
                }
            });
        </script>
    @endsection
