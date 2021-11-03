@extends('layouts/app')

{{-- @extends('views/sass/app') --}}

@section('title', 'AddNft')

@section('content')

    <x-header firstname="{{ $user->firstname }}" />

    <h1>Add NFT</h1>


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="form-group">
        <form method="POST" action="/nft/addNft" id="editNftForm" enctype='multipart/form-data'>
            @csrf
            <h2 class="form-group__title">Upload a new masterpiece</h2>
            <input type="hidden" name='creator' value="{{ $user->id }}">

            <label class="form-group__label" for="nTitle"> title</label><br>
            <input class="form-group__input" type="text" id="nTitle" name="nftTitle"><br>

            <label class="form-group__label" for="nDescription">description</label><br>
            <input class="form-group__input" type="text" id="nDescription" name="nftDescription"><br>

            <label class="form-group__label" for="nArea">Area</label><br>
            <input class="form-group__input" type="text" id="nArea" name="nftArea"><br>

            <label class="form-group__label" for="nObjectType">Object type</label><br>
            <input class="form-group__input" type="text" id="nObjectType" name="nftObjectType"><br>

            <label class="form-group__label" for="nPrice">Price (Euro)</label><br>
            <input class="form-group__input" type="text" id="nPrice" name="nftPrice"><br>

            <label class="form-group__label" for="nImage">upload image</label><br>
            <input class="form-group__input--image" type="file" id="nImage" name="nftImage"><br>

            <label class="form-group__label" for="collections">choose collection</label><br>
            <select id="collections" name="collectionsId" form="editNftForm">
                @foreach ($collections as $collection)
                    <option class="form-group__input" value="{{ $collection->id }}">{{ $collection->title }}e</option>
                @endforeach
            </select>
            <br>

            <input class="btn-center" type="submit" name="upload" value="Add">

        </form>
    </div>

@endsection
