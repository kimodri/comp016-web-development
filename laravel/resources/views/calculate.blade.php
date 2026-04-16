<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite([
    'resources/sass/app.scss',
    'resources/js/app.js'
    ])

    <style>
        .body-cont {
            color: aquamarine;
            font-size: 30px;
        }

        #fNameLabel {
            border: solid;
            border-width: 2px;
        }

        p {
            font-family: monospace;
        }

        /* .body-cont .diff{
            color: red;
        } */
    </style>
</head>

<body class="body-cont">
    <h1 style="color: blue;">Calculate Page</h1>
    <p>Sum: {{ $sum }}</p>
    <p class="diff">Difference: {{ $difference }}</p>
    <p>Product: {{ $product }}</p>
    <p>Results: {{$sum . $difference . $product}}</p>

    <div class="div-label">
        <label id="fNameLabel">Sample Label 1</label>
        <button type="button" class="btn btn-danger">Danger</button>
    </div>

    <!-- shift + alt + f to prettify -->
    <div class="container"> <!-- provided by bootstrap -->
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
    </div>

    <!-- mobile responsiveness -->
    <!-- Grid System -->
    <div class="container">
        <div class="row">
            <!-- Ang column ko kapag medium ang size ng screen gagawin kong 4 -->
            <div class="col-lg-12 col-md-4 col-sm-6 col-xs-4 border border-danger">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-4 border border-danger bg-success">Col 4</div>
            <div class="col-md-4 col-sm-6 col-xs-4 border border-danger">Col 4</div>
        </div>
    </div>

    
    <!-- <img src="path/to/your/image.jpg" alt="Sample Image" class="card-img-top" style="width: 100%; height: auto;"> -->
    <!-- BootStrap Icons -->
    <i class="bi bi-airplane"></i>


</body>

</html>