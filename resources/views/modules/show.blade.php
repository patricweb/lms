@extends("layout")

@section("main")
	<div class="min-h-screen py-8 sm:py-12 lg:py-16" x-data="{ openModules: {} }">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8">
			<div class="border border-gray-600 rounded-2xl bg-[#121517] shadow-2xl overflow-hidden">
				<div class="p-6 sm:p-8 lg:p-12 border-b border-gray-700">
					<div class="max-w-5xl mx-auto">
						<h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-3">
							<a href="{{ route('showCourse', $module->course) }}" class="text-[#7cdebe] hover:underline transition">
								{{ $module->course->title }}
							</a>
						</h1>
						<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mt-4 mb-6">
							{{ $module->title }}
						</h2>
						@if($module->description)
							<p class="text-lg sm:text-xl text-gray-300 leading-relaxed max-w-4xl">
								{{ $module->description }}
							</p>
						@endif
						<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-300">
							<div>
								<span class="text-gray-400">Ваш прогресс:</span>
								<span class="ml-2 font-bold text-2xl text-[#7cdebe]">
									{{ $progress ?? 0 }}%
								</span>
							</div>
							<div>
								<span class="text-gray-400">Порядок модуля:</span>
								<span class="ml-2 font-semibold text-white">
									{{ $module->order }}
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="p-6 sm:p-8 lg:p-12">
					@auth
						@if(!empty($canEdit) && $canEdit)
							<div class="flex flex-wrap gap-3 mb-10">
								<a href="{{ route('createLesson', ['course' => $module->course, 'module' => $module]) }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-black font-bold px-6 py-3 rounded-xl transition transform hover:scale-105">
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
									</svg>
									Добавить урок
								</a>
								<a href="{{ route('editModule', ['course' => $module->course, 'module' => $module]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-black font-bold px-6 py-3 rounded-xl transition">
									Редактировать модуль
								</a>
								<form method="POST" action="{{ route('deleteModule', ['course' => $module->course, 'module' => $module]) }}" onsubmit="return confirm('Удалить модуль и все уроки внутри?')" class="inline">
									@csrf @method('DELETE')
									<button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-xl transition">
										Удалить модуль
									</button>
								</form>
							</div>
						@endif
					@endauth
					@if($module->lessons->count() > 0)
						<div class="space-y-5">
							@foreach($module->lessons as $lessonIndex => $lesson)
								<div class="border border-gray-700 rounded-2xl bg-[#182023]/50 backdrop-blur hover:bg-[#1f2427] transition-all">
									<div class="p-5 sm:p-6">
										<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
											<a href="{{ route('showLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="flex-1 block">
												<div class="flex items-start gap-4">
													<div class="w-12 h-12 bg-gray-700 rounded-xl flex items-center justify-center">
														<span class="text-xl font-bold text-white">
															{{ $lesson->order ?? $lessonIndex + 1 }}
														</span>
													</div>
													<div class="flex-1 min-w-0">
														<h4 class="text-lg sm:text-xl font-semibold text-white truncate">
															{{ $lesson->title }}
														</h4>
														<p class="text-sm text-gray-400 mt-1">
															Порядок: {{ $lesson->order ?? $lessonIndex + 1 }}
															• Длительность: {{ $lesson->duration }} мин
														</p>
													</div>
												</div>
											</a>
											<div class="flex flex-wrap items-center gap-3">
												@auth
													@if(!$lesson->isCompletedByUser($user))
														<form method="POST" action="{{ route('completeLesson', ['course' => $module->course, 'lesson' => $lesson->id]) }}" class="inline">
															@csrf
															<button type="submit" class="bg-[#7cdebe] hover:bg-emerald-400 text-black font-bold px-5 py-2.5 rounded-xl text-sm transition transform hover:scale-105">
																Завершить
															</button>
														</form>
													@else
														<div class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm inline-flex items-center gap-2">
															<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
																<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
															</svg>
															Завершено
														</div>
													@endif
													@if(!empty($canEdit) && $canEdit)
														<a href="{{ route('editLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-black font-bold px-4 py-2 rounded-xl text-sm transition">
															Редактировать
														</a>
														<form method="POST" action="{{ route('deleteLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" onsubmit="return confirm('Удалить этот урок?')" class="inline">
															@csrf @method('DELETE')
															<button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded-xl text-sm transition">
																Удалить
															</button>
														</form>
													@endif
												@endauth
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@else
						<div class="text-center py-16">
							<div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
								<svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
								</svg>
							</div>
							<h3 class="text-2xl font-semibold text-white mb-3">Уроки не добавлены</h3>
							<p class="text-gray-400 mb-8 max-w-md mx-auto">
								Начните создавать контент для этого модуля
							</p>
							@auth
								@if(!empty($canEdit) && $canEdit)
									<a href="{{ route('createLesson', ['course' => $module->course, 'module' => $module]) }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-black font-bold px-8 py-4 rounded-xl transition transform hover:scale-105">
										<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
										</svg>
										Добавить первый урок
									</a>
								@endif
							@endauth
						</div>
					@endif
					<div class="mt-12 text-center">
						<a href="{{ route('showCourse', $module->course) }}" class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-600 text-white font-bold px-8 py-4 rounded-xl transition">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
							</svg>
							Назад к курсу
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection