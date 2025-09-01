<DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <title>
            Home Page
        </title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&amp;family=Roboto&amp;display=swap"
            rel="stylesheet" />
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background-color: #f3ede4;
            }

            h1 {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>

    <body
        class="relative min-h-screen overflow-x-hidden bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-[length:2500px_auto]">
        <!-- Top left logo and wave lines -->
        <div class="absolute top-6 left-6 z-20 flex flex-col items-start">
            <img alt="Logo with a shield shape and text below" class="w-[60px] h-[80px] object-contain mb-4"
                height="80" src="/ukdw.png" width="60" />
            
        </div>
        <main class="max-w-7xl mx-auto py-12 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-12">
            <!-- Left column images -->
            <div class="flex flex-col gap-y-12">
                <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="Woman in white dress holding two woven bags with flowers around"
                        class="w-full aspect-square object-cover" height="220"
                        src="https://storage.googleapis.com/a1aa/image/406ddebd-344b-4d61-7f12-7fd9b1a0df15.jpg"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600">
                        </i>
                        <i class="fas fa-thumbs-down text-orange-500">
                        </i>
                        <i class="fas fa-comment text-sky-500">
                        </i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="Wire sculpture of a swan made with copper wire on a dark surface"
                        class="w-full aspect-square object-cover" height="220"
                        src="https://storage.googleapis.com/a1aa/image/7a2688e0-1456-4c5b-7277-613ed3d72356.jpg"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600">
                        </i>
                        <i class="fas fa-thumbs-down text-orange-500">
                        </i>
                        <i class="fas fa-comment text-sky-500">
                        </i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="Handmade shelf made of woven material with flower embroidery and shoes drawn on shelves"
                        class="w-full aspect-square object-cover" height="220"
                        src="https://storage.googleapis.com/a1aa/image/13c1ce83-8956-4009-c3c2-9439c224cb17.jpg"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600">
                        </i>
                        <i class="fas fa-thumbs-down text-orange-500">
                        </i>
                        <i class="fas fa-comment text-sky-500">
                        </i>
                    </figcaption>
                </figure>
            </div>
            <div class="flex flex-col items-center">
                <!-- Center login box -->
                <div class="shadow-md relative w-full max-w-3xl mx-auto" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <section class="bg-[#d3ecfc] rounded-xl px-12 pt-10 pb-8 w-full shadow-md">
                        <h1 class="text-4xl font-extrabold text-center mb-6 leading-tight">
                            WELCOME <br /> BACK!
                        </h1>
                        <form action="{{ url('/homeMhs') }}" method="get" class="w-full space-y-5">
                            <div>
                                <input
                                    class="w-full rounded-lg py-3 px-4 text-sm placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-400"
                                    placeholder="Username" type="text" />
                            </div>
                            <div>
                                <input
                                    class="w-full rounded-lg py-3 px-4 text-sm placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-400"
                                    placeholder="Password" type="password" />
                                <p class="text-xs italic text-right mt-1 text-slate-600">
                                    Forgot Password?
                                </p>
                            </div>
                            <button
                                class="w-full bg-sky-400 hover:bg-sky-500 text-white font-bold py-3 rounded-lg shadow-md transition-colors"
                                type="submit">
                                Login
                            </button>
                        </form>
                    </section>
                </div>
                <!-- Center bottom image with reactions and show more -->
                <div class="col-span-1 sm:col-span-2 flex flex-col items-center mt-6">
                    <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                        style="box-shadow: 2px 2px 6px #b8b8b8;">
                        <img alt="Person painting a wooden craft with paintbrushes and red paint"
                            class="w-full h-[300px] object-cover" height="220"
                            src="https://storage.googleapis.com/a1aa/image/c9ae5c06-8585-4cbb-3497-4bee06fabea4.jpg"
                            width="320" />
                        <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                            <i class="fas fa-heart text-red-600">
                            </i>
                            <i class="fas fa-thumbs-down text-orange-500">
                            </i>
                            <i class="fas fa-comment text-sky-500">
                            </i>
                        </figcaption>
                    </figure>
                    <button aria-label="Show more content"
                        class="mt-6 text-sm font-semibold italic text-slate-700 hover:text-slate-900">
                        SHOW MORE &gt;&gt;
                    </button>
                </div>
            </div>

            
            </div>
            <!-- Right column images -->
            <div class="flex flex-col gap-y-12">
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="Black round bag with white abstract design and gold chain strap on light gray background"
                        class="w-full aspect-square object-cover" height="220"
                        src="https://storage.googleapis.com/a1aa/image/6ccd0738-e0ac-4b94-f005-c7d156052e83.jpg"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600">
                        </i>
                        <i class="fas fa-thumbs-down text-orange-500">
                        </i>
                        <i class="fas fa-comment text-sky-500">
                        </i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="Pink ZARA perfume bottle labeled Pink Flambé surrounded by pink and white flowers"
                        class="w-full aspect-square object-cover" height="220"
                        src="https://storage.googleapis.com/a1aa/image/8f58d82c-5a07-4673-8760-f7b9791b62bb.jpg"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600">
                        </i>
                        <i class="fas fa-thumbs-down text-orange-500">
                        </i>
                        <i class="fas fa-comment text-sky-500">
                        </i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="Brown and white lace bag with wooden circular handle on a fabric background"
                        class="w-full aspect-square object-cover" height="220"
                        src="https://storage.googleapis.com/a1aa/image/16162614-50a6-4fa4-683f-d7fc690a0977.jpg"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600">
                        </i>
                        <i class="fas fa-thumbs-down text-orange-500">
                        </i>
                        <i class="fas fa-comment text-sky-500">
                        </i>
                    </figcaption>
                </figure>
            </div>
        </main>
    </body>

    </html>
