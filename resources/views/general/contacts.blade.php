@extends("layout")

@section("main")
    <div class="px-6 py-24">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div class="relative left-1/2 -z-10 aspect-1155/678 w-144.5 max-w-none -translate-x-1/2 rotate-30 opacity-20 sm:left-[calc(50%-40rem)] sm:w-288.75"></div>
        </div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">Contact sales</h2>
            <p class="mt-2 text-lg/8 text-gray-400">Aute magna irure deserunt veniam aliqua magna enim voluptate.</p>
        </div>
        <form class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="first-name" class="block text-sm/6 font-semibold text-white">First name</label>
                    <div class="mt-2">
                        <input id="first-name" type="text" name="first-name" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-none placeholder:text-gray-500">
                    </div>
                </div>
                <div>
                    <label for="last-name" class="block text-sm/6 font-semibold text-white">Last name</label>
                    <div class="mt-2">
                        <input id="last-name" type="text" name="last-name" autocomplete="family-name" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-none placeholder:text-gray-500">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-semibold text-white">Email</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" autocomplete="email" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-none placeholder:text-gray-500">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm/6 font-semibold text-white">Message</label>
                    <div class="mt-2">
                        <textarea id="message" name="message" rows="4" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-none placeholder:text-gray-500"></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-emerald-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-emerald-700">Let's talk</button>
            </div>
        </form>
    </div>
@endsection