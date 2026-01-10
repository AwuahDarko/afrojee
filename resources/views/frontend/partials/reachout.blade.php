<section class="bg-cream py-16 px-4 md:px-8">
    <div class="container mx-auto text-center">
        <div class="mb-16">
            <div class="flex flex-col md:flex-row items-center justify-items-start">
                <h1 class="text-5xl min-w-[26%] font-bold text-gray-700  text-left">
                    <span class="block">{{ __('common.reachout.title') }}</span>
                    <span class="text--gray-700 font-medium text-5xl w-full">{{ __('common.reachout.title_bold') }}</span>
                </h1>
                <div class="w-full h-1 bg-gray-300 mt-4 md:mt-0"></div>
            </div>
        </div>
        <p class="text-lg text-gray-700 mb-12 text-left">
            {{ __('common.reachout.subtitle') }}
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- 1. Email Card -->
            <div class="bg-white p-8 rounded-xl shadow-md text-left relative">
                <div class="absolute top-6 right-6 w-12 h-12 flex items-center justify-center bg-pink-100 rounded-full">
                    <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22.5.5h-20A2.497 2.497 0 0 0 .013 3L0 18c0 1.375 1.125 2.5 2.5 2.5h20c1.375 0 2.5-1.125 2.5-2.5V3C25 1.625 23.875.5 22.5.5m0 5-10 6.25-10-6.25V3l10 6.25L22.5 3z"
                            fill="#ef380d" />
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('common.reachout.email.title') }}</h3>
                <p class="text-gray-700 mb-2">{{ __('common.reachout.email.description') }}</p>
                <p class="font-semibold text-gray-800">info@afrojee.store</p>
            </div>

            <!-- 2. WhatsApp Card (NEW) -->
            <a href="https://wa.me/+34602181565" target="_blank" rel="noopener noreferrer" class="block">
                <div class="bg-white p-8 rounded-xl shadow-md text-left relative h-full">
                    <div
                        class="absolute top-6 right-6 w-12 h-12 flex items-center justify-center bg-pink-100 rounded-full">
                        <!-- WhatsApp SVG Icon -->

                        <svg fill="#ef380d" width="31" height="30" viewBox="-2 -2 24 24"
                            xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-whatsapp">
                            <path
                                d="M9.516.012C4.206.262.017 4.652.033 9.929a9.798 9.798 0 0 0 1.085 4.465L.06 19.495a.387.387 0 0 0 .47.453l5.034-1.184a9.981 9.981 0 0 0 4.284 1.032c5.427.083 9.951-4.195 10.12-9.58C20.15 4.441 15.351-.265 9.516.011zm6.007 15.367a7.784 7.784 0 0 1-5.52 2.27 7.77 7.77 0 0 1-3.474-.808l-.701-.347-3.087.726.65-3.131-.346-.672A7.62 7.62 0 0 1 2.197 9.9c0-2.07.812-4.017 2.286-5.48a7.85 7.85 0 0 1 5.52-2.271c2.086 0 4.046.806 5.52 2.27a7.672 7.672 0 0 1 2.287 5.48c0 2.052-.825 4.03-2.287 5.481z" />
                            <path
                                d="M14.842 12.045l-1.931-.55a.723.723 0 0 0-.713.186l-.472.478a.707.707 0 0 1-.765.16c-.913-.367-2.835-2.063-3.326-2.912a.694.694 0 0 1 .056-.774l.412-.53a.71.71 0 0 0 .089-.726L7.38 5.553a.723.723 0 0 0-1.125-.256c-.539.453-1.179 1.14-1.256 1.903-.137 1.343.443 3.036 2.637 5.07 2.535 2.349 4.566 2.66 5.887 2.341.75-.18 1.35-.903 1.727-1.494a.713.713 0 0 0-.408-1.072z" />
                        </svg>

                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('common.reachout.whatsapp.title') }}</h3>
                    <p class="text-gray-700 mb-2">{{ __('common.reachout.whatsapp.description') }}</p>
                    <p class="font-semibold text-gray-800">+34 602 18 15 65</p>
                </div>
            </a>

            <!-- 3. Instagram Card -->
            <a href="https://www.instagram.com/afro_jeee/" target="_blank" rel="noopener noreferrer" class="block">
                <div class="bg-white p-8 rounded-xl shadow-md text-left relative h-full">
                    <div
                        class="absolute top-6 right-6 w-12 h-12 flex items-center justify-center bg-pink-100 rounded-full">
                        <!-- Instagram SVG Icon -->
                        <svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.786 2.5c1.406.004 2.12.011 2.736.029l.243.009c.28.01.556.022.89.037 1.33.063 2.237.272 3.033.581a6.1 6.1 0 0 1 2.215 1.442 6.1 6.1 0 0 1 1.442 2.215c.308.796.518 1.703.58 3.035.016.332.028.608.038.89l.008.242c.018.615.026 1.329.029 2.735v2.57q.006 1.367-.028 2.735l-.008.242c-.01.282-.022.558-.037.89-.062 1.332-.275 2.238-.582 3.035a6.1 6.1 0 0 1-1.442 2.215 6.1 6.1 0 0 1-2.215 1.442c-.796.308-1.703.518-3.033.581l-.89.037-.243.008c-.616.018-1.33.026-2.736.029l-.933.001h-1.636a98 98 0 0 1-2.736-.029l-.243-.007a80 80 0 0 1-.89-.039c-1.33-.062-2.237-.273-3.035-.581A6.1 6.1 0 0 1 5.1 25.402a6.1 6.1 0 0 1-1.442-2.215c-.309-.796-.519-1.703-.581-3.035l-.038-.89-.006-.242a99 99 0 0 1-.031-2.735v-2.57a99 99 0 0 1 .027-2.735l.009-.242c.01-.282.022-.558.037-.89.063-1.332.273-2.238.582-3.036A6.1 6.1 0 0 1 5.1 4.599a6.1 6.1 0 0 1 2.212-1.442c.798-.308 1.704-.518 3.035-.581.333-.015.61-.028.89-.038l.243-.007a99 99 0 0 1 2.735-.029zM15.5 8.75a6.25 6.25 0 1 0 0 12.5 6.25 6.25 0 0 0 0-12.5m0 2.5a3.749 3.749 0 1 1-.001 7.498 3.749 3.749 0 0 1 .002-7.498m6.562-4.375a1.563 1.563 0 1 0 0 3.125 1.563 1.563 0 0 0 0-3.125"
                                fill="#ef380d" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('common.reachout.instagram.title') }}</h3>
                    <p class="text-gray-700 mb-2">{{ __('common.reachout.instagram.description') }}</p>
                    <p class="font-semibold text-gray-800">@afro_jeee</p>
                </div>
            </a>
        </div>
    </div>
</section>