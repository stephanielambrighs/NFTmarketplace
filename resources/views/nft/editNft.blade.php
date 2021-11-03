<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>




    <form method="POST" action="{{ url('/nft/editNft') }}" enctype='multipart/form-data'>>
        @csrf

        <input type="hidden" name="id" value="{{ $nft->id }}">

        <label for="cTitle">nft title</label><br>
        <input type="text" id="cTitle" value="{{ $nft->title }}" name="nftTitle"><br>


        <label for="cDescription">nft description</label><br>
        <input type="text" id="cDescription" value="{{ $nft->description }}" name="nftDescription"><br>

        <label class="form-group__label" for="nArea">Area</label><br>
        <input class="form-group__input" type="text" id="nArea" name="nftArea"><br>

        <label class="form-group__label" for="nObjectType">Object type</label><br>
        <input class="form-group__input" type="text" id="nObjectType" name="nftObjectType"><br>


        <label class="form-group__label" for="nPrice">Price (Euro)</label><br>
        <input class="form-group__input" type="text" id="nPrice" name="nftPrice"><br>

        <label for="nImage">nft image</label><br>
        <input type="file" name="nftImage"> <br>

        <label class="form-group__label" for="collections">choose collection</label><br>
        <select id="collections" name="collectionsId" form="editNftForm">
            @foreach ($collections as $collection)
                <option class="form-group__input" value="{{ $collection->id }}">{{ $collection->title }}e</option>
            @endforeach
        </select>
        <br>


        <input type="submit" name="upload" value="edit">

    </form>
</body>

</html>
