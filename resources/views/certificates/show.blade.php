@extends('layout')

@section('main')
    <div class="min-h-screen bg-[#182023] py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="mb-6 certificate-actions">
                    <a href="{{ route('certificates.index') }}" class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 transition group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Назад к сертификатам
                    </a>
                </div>
                <div class="certificate-preview bg-white rounded-3xl shadow-2xl overflow-hidden mb-6 border-4 border-[#f4d03f]" style="aspect-ratio: 16/9; min-height: 500px;">
                    <div class="p-8 md:p-12 relative h-full flex items-center">
                        <div class="absolute top-6 left-6 right-6 bottom-6 border-4 border-blue-500"></div>
                        <div class="text-center relative z-10 w-full">
                            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2 uppercase tracking-wider">
                                СЕРТИФИКАТ
                            </h1>
                            <p class="text-base md:text-lg text-gray-600 mb-6 italic">о завершении курса</p>
                            <div class="max-w-2xl mx-auto">
                                <p class="text-sm md:text-base text-gray-700 mb-3">Настоящим подтверждается, что</p>
                                <div class="mb-5">
                                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 inline-block border-t-4 border-b-4 border-blue-500 px-6 py-3">
                                        {{ $certificate->user->name }}
                                    </h2>
                                </div>
                                <p class="text-sm md:text-base text-gray-700 mb-2">успешно завершил(а) курс</p>
                                <h3 class="text-xl md:text-2xl font-bold text-red-600 mb-4 italic">
                                    "{{ $certificate->course->title }}"
                                </h3>
                                <div class="w-36 h-0.5 bg-blue-500 mx-auto mb-4"></div>
                                <div class="flex items-center justify-center gap-4 md:gap-6 mt-6 pt-4 border-t-2 border-gray-200">
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Дата выдачи</div>
                                        <div class="text-sm md:text-base font-semibold text-gray-900">
                                            {{ $certificate->issued_at->format('d.m.Y') }}
                                        </div>
                                    </div>
                                    <div class="w-px h-8 bg-gray-300"></div>
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500 mb-1">Номер сертификата</div>
                                        <div class="text-sm md:text-base font-mono font-semibold text-gray-900">
                                            {{ $certificate->certificate_number }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="certificate-info bg-[#18181b] rounded-2xl border border-gray-700 p-6 mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Информация о курсе
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm text-gray-400 mb-1">Преподаватель</div>
                            <div class="text-white font-medium">
                                {{ $certificate->course->teacher->name ?? 'Не указан' }}
                            </div>
                        </div>
                        @if($certificate->course->category)
                        <div>
                            <div class="text-sm text-gray-400 mb-1">Категория</div>
                            <div class="text-white font-medium">
                                {{ $certificate->course->category->name }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="certificate-actions flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('showCourse', $certificate->course) }}" class="flex-1 group flex items-center justify-center gap-3 px-6 py-4 bg-gray-800 hover:bg-gray-700 text-white rounded-xl font-semibold transition border border-gray-700">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        К курсу
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection