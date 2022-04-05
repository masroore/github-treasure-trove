<x-layout.app>

    @section('og_meta')
    <meta property="og:site_name" content="Hellen Dutch Art.">
    <meta property="og:title" content="Hellen Dutch Art : Home">
    <meta property="og:description" content="Contemporary expressionist: Paintings, mixed media & paper Sculptures from Borneo">
    <meta property="og:image" content="https://d32wdolnlcperg.cloudfront.net/172/IMG_7029.JPG">
    <meta property="og:url" content="https://hellendutch.art">
    <meta name="twitter:card" content="summary_large_image">
    <title>Hellen Dutch Art : Home</title>
    @endsection


    @section('title', 'Home')


    <x-layout.pageheader  :cat="$cat" />

    <div class="container mx-auto pb-4">
        <div class="flex flex-col md:flex-row justify-between">
            <x-layout.dash-left />

            <x-dashboard.dash_main :products='$products' />

        </div>
    </div>
</x-layout.app>