@extends('layout')

@section('main')
	<div class="py-24 sm:py-32">
		<div class="mx-auto max-w-7xl px-6 lg:px-8">
			<div class="mx-auto max-w-2xl lg:text-center">
				<p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-white sm:text-5xl lg:text-balance">Simple tools for your learning platform</p>
				<p class="mt-6 text-lg/8 text-gray-300">Easy ways to create courses, track progress, and engage students. Start building today.</p>
			</div>
			<div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
				<dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
					<div class="relative pl-16">
						<dt class="text-base/7 font-semibold text-white">
							<div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-emerald-600">
								<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#000000" d="m9 19l-5.657-5.657l2.121-2.121L9 14.757l8.485-8.485l2.122 2.121L9 19Zm-3.536-6.364l-.707.707L9 17.586l9.192-9.193l-.707-.707L9 16.172l-3.536-3.536Z"/></svg>
							</div>
							Course Management
						</dt>
						<dd class="mt-2 text-base/7 text-gray-400">Create and organize courses with videos, texts, and modules.</dd>
					</div>
					<div class="relative pl-16">
						<dt class="text-base/7 font-semibold text-white">
							<div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-emerald-600">
								<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24"><path fill="#000000" d="M11.5 14c4.14 0 7.5 1.57 7.5 3.5V20H4v-2.5c0-1.93 3.36-3.5 7.5-3.5m6.5 3.5c0-1.38-2.91-2.5-6.5-2.5S5 16.12 5 17.5V19h13v-1.5M11.5 5A3.5 3.5 0 0 1 15 8.5a3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8 8.5A3.5 3.5 0 0 1 11.5 5m0 1A2.5 2.5 0 0 0 9 8.5a2.5 2.5 0 0 0 2.5 2.5A2.5 2.5 0 0 0 14 8.5A2.5 2.5 0 0 0 11.5 6Z"/></svg>
							</div>
							Student Enrollment
						</dt>
						<dd class="mt-2 text-base/7 text-gray-400">Register users, manage groups, and control access easily.</dd>
					</div>
					<div class="relative pl-16">
						<dt class="text-base/7 font-semibold text-white">
							<div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-emerald-600">
								<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24"><path fill="#000000" d="M2 4h1v16h2V10h4v10h2V6h4v14h2v-6h4v7H2V4m16 11v5h2v-5h-2m-6-8v13h2V7h-2m-6 4v9h2v-9H6Z"/></svg>
							</div>
							Progress Tracking
						</dt>
						<dd class="mt-2 text-base/7 text-gray-400">Track student progress with simple reports and dashboards.</dd>
					</div>
					<div class="relative pl-16">
						<dt class="text-base/7 font-semibold text-white">
							<div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-emerald-600">
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24"><path fill="#000000" d="M6 5h2.5a3 3 0 0 1 3-3a3 3 0 0 1 3 3H17a3 3 0 0 1 3 3v11a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V8a3 3 0 0 1 3-3m0 1a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-1v3H7V6H6m2 2h7V6H8v2m3.5-5a2 2 0 0 0-2 2h4a2 2 0 0 0-2-2m5.65 8.6L10 18.75l-3.2-3.2l.7-.71l2.5 2.5l6.44-6.45l.71.71Z"/></svg>
							</div>
							Assessment Tools
						</dt>
						<dd class="mt-2 text-base/7 text-gray-400">Build exams and assignments with easy grading and secure submissions.</dd>
					</div>
				</dl>
			</div>
		</div>
	</div>
@endsection