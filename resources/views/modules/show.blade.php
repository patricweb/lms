@extends("layout")
@section("main")
<div class="min-h-screen py-8" x-data="{ openModules: {} }">
	<div class="border border-gray-600 rounded-xl container mx-auto px-4">
		<div class="rounded-2xl p-8 mb-8">
			<div class="flex gap-8 items-center">
				<div>
					<h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">
						<a href="{{ route('showCourse', $module->course) }}" class="text-[#7cdebe] hover:underline">{{ $module->course->title }}</a>
					</h1>
					<h2 class="text-2xl md:text-3xl font-bold mb-4 text-white">{{ $module->title }}</h2>
					@if($module->description)
						<p class="text-lg text-gray-300 mb-6 leading-relaxed">{{ $module->description }}</p>
					@endif
                    <p class="mt-2 text-gray-300">Ваш прогресс: <span class="font-semibold text-[#7cdebe]">{{ $progress ?? 0 }}%</span><br></p>
                    <br>
					<p class="text-gray-400 mb-2">Порядок модуля: <span class="text-white font-medium">{{ $module->order }}</span></p>
				</div>
			</div>

			<!-- Lessons Section -->
			<div class="rounded-2xl p-8 mt-16">
				<h2 class="text-3xl font-bold mb-8 text-white">Уроки модуля</h2>
				
				@auth
					@if(!empty($canEdit) && $canEdit)
						<div class="mb-6 flex gap-3">
							<a href="{{ route('createLesson', ['course' => $module->course, 'module' => $module]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
								</svg>
								Добавить урок
							</a>
                            <a href="{{ route('editModule', ['course' => $module->course, 'module' => $module]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
								Редактировать модуль
							</a>
							<form method="POST" action="{{ route('deleteModule', ['course' => $module->course, 'module' => $module]) }}" class="inline" onsubmit="return confirm('Удалить модуль и все уроки?')">
								@csrf
								@method('DELETE')
								<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
									Удалить модуль
								</button>
							</form>
						</div>
					@endif
				@endauth

				@if($module->lessons->count() > 0)
					<div class="space-y-6">
						@foreach($module->lessons as $lessonIndex => $lesson)
							<div class="border border-gray-700 rounded-2xl overflow-hidden bg-[#182023]">
								<div class="p-6">
									<div class="flex items-start justify-between">
										<div class="flex-1">
											<a href="{{ route('showLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="block">
												<div class="flex items-center gap-4 mb-3">
													<div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
														<span class="font-bold text-white">{{ $lesson->order ?? $lessonIndex + 1 }}</span>
													</div>
													<div class="flex-1">
														<h4 class="text-lg font-semibold text-white mb-1">{{ $lesson->title }}</h4>
														<p class="text-gray-400 text-sm mb-1">Порядок: {{ $lesson->order ?? $lessonIndex + 1 }} | Длительность: {{ $lesson->duration }} мин</p>
													</div>
												</div>
											</a>
										</div>
										@auth
											<div class="ml-4 flex gap-2">
													@if(!$lesson->isCompletedByUser($user))
														<form method="POST" action="{{ route('completeLesson', ['course' => $module->course, 'lesson' => $lesson->id]) }}" class="d-inline">
															@csrf
															<button type="submit" class="bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
																Завершить
															</button>
														</form>
													@else
														<div class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-medium inline-flex items-center gap-2">
															<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
																<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
															</svg>
															Завершено
														</div>
													@endif
												@if(!empty($canEdit) && $canEdit)
													<div class="flex gap-2">
														<a href="{{ route('editLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-xl font-medium transition-all duration-200">
															Редактировать
														</a>
														<form method="POST" action="{{ route('deleteLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="inline" onsubmit="return confirm('Удалить урок?')">
															@csrf
															@method('DELETE')
															<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
																Удалить
															</button>
														</form>
													</div>
												@endif
											</div>
										@endauth
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@else
					<div class="text-center py-12">
						<div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
							<svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
							</svg>
						</div>
						<h3 class="text-xl font-semibold text-white mb-2">Уроки не добавлены</h3>
						<p class="text-gray-400 mb-6">Начните создавать контент для этого модуля</p>
						@auth
							@if(!empty($canEdit) && $canEdit)
								<a href="{{ route('createLesson', ['course' => $module->course, 'module' => $module]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2 mx-auto">
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
									</svg>
									Добавить урок
								</a>
							@endif
						@endauth
					</div>
				@endif
				<div class="mt-8 flex justify-center">
					<a href="{{ route('showCourse', $module->course) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2">
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
						</svg>
						Назад к курсу
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection