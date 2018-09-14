<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/formtech.css">

    <title>Formtech</title>
</head>
<body class="h-full bg-grey-lightest page:landing-page font-sans text-primary">

<header id="header" class="w-full">
    <div class="container mx-auto flex justify-between items-center">
        <div class="">
            <a href="#" class="block p-4 uppercase tracking-wide text-4xl no-underline text-grey-lighter">
                Formtech
            </a>
        </div>
        <nav class="navigation">
            <ul class="list-reset">
                <li>
                    <a href="#" class="no-underline inline-block p-4 text-grey-lighter">About</a>
                    <a href="#" class="no-underline inline-block p-4 text-grey-lighter">About</a>
                    <a href="#" class="no-underline inline-block p-4 text-grey-lighter">About</a>
                    <a href="#" class="no-underline inline-block p-4 text-grey-lighter">About</a>
                    <a href="#" class="no-underline inline-block p-4 text-grey-lighter">About</a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="h-screen-80 landing-page-parallax flex items-center">
    <div class="w-full bg-smoke-lighter">
        <div class="container mx-auto py-8">
            <div class="text-primary-inverse text-2xl leading-normal text-center">
                Main contributer to smart energy management in glove manufacturing
            </div>
        </div>
    </div>
</div>

<div class="overflow-x-hidden bg-grey-lightest">
    <div class="">
        <div class="container mx-auto grid py-16">
            <div class="w-1/3">
                <p class="text-secondary leading-normal">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at, consectetur consequuntur dolore
                    earum expedita impedit maiores natus pariatur, quas, sit veniam vitae. Animi consequuntur eaque, error
                    hic recusandae vero!
                </p>
            </div>
            <div class="w-1/3">
                <p class="text-secondary leading-normal">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at, consectetur consequuntur dolore
                    earum expedita impedit maiores natus pariatur, quas, sit veniam vitae. Animi consequuntur eaque, error
                    hic recusandae vero!
                </p>
            </div>
            <div class="w-1/3">
                <p class="text-secondary leading-normal">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at, consectetur consequuntur dolore
                    earum expedita impedit maiores natus pariatur, quas, sit veniam vitae. Animi consequuntur eaque, error
                    hic recusandae vero!
                </p>
            </div>
        </div>
    </div>

    <div class="">
        <div class="container mx-auto grid py-16">
            <div class="w-full">
                <p class="text-secondary leading-normal">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at, consectetur consequuntur dolore
                    earum expedita impedit maiores natus pariatur, quas, sit veniam vitae. Animi consequuntur eaque, error
                    hic recusandae vero!
                </p>
            </div>
        </div>
    </div>
</div>

<div class="py-16 bg-red-darkest">

</div>
</body>
</html>
