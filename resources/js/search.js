const search = document.querySelector("#search")
const searchResults = document.querySelector("#search-results")

if (search && searchResults) {
    search.addEventListener("input", () => {
        const val = search.value.trim()

        if (val.length > 0) {
            fetch(`/api/search?q=${encodeURIComponent(val)}`)
                .then((res) => res.json())
                .then((data) => {
                    searchResults.innerHTML = ""

                    if (data.courses.length > 0 || data.categories.length > 0) {
                        searchResults.classList.remove("hidden")

                        data.courses.forEach((course) => {
                            const courseElement = document.createElement('a')
                            courseElement.href = course.url
                            courseElement.className = 'block p-3 border-b border-gray-700 hover:bg-[#1a1d21] transition cursor-pointer'
                            
                            courseElement.innerHTML = `
                                <div class="flex items-start gap-3">
                                    ${course.thumbnail ? `
                                        <img class="w-16 h-16 object-cover rounded-lg" src="${course.thumbnail}" alt="${course.title}">
                                    ` : `
                                        <div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400 text-xs text-center px-1">${course.title.substring(0, 2)}</span>
                                        </div>
                                    `}
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-semibold mb-1 truncate">${course.title}</h4>
                                        <p class="text-gray-400 text-sm mb-1 line-clamp-2">${course.description}</p>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            ${course.category ? `<span>${course.category}</span>` : ''}
                                            ${course.teacher ? `<span>• ${course.teacher}</span>` : ''}
                                            <span>• ${course.price > 0 ? course.price + ' $' : 'Бесплатно'}</span>
                                        </div>
                                    </div>
                                </div>
                            `
                            
                            searchResults.appendChild(courseElement)
                        })

                        data.categories.forEach((category) => {
                            const categoryElement = document.createElement('a')
                            categoryElement.href = category.url
                            categoryElement.className = 'block p-3 border-b border-gray-700 hover:bg-[#1a1d21] transition cursor-pointer'
                            categoryElement.innerHTML = `
                                <div class="text-white font-semibold">${category.name}</div>
                                <div class="text-gray-400 text-xs mt-1">Категория</div>
                            `
                            searchResults.appendChild(categoryElement)
                        })
                    } else {
                        searchResults.classList.add("hidden")
                    }
                })
                .catch((error) => {
                    console.error('Search error:', error)
                    searchResults.classList.add("hidden")
                })
        } else {
            searchResults.innerHTML = ""
            searchResults.classList.add("hidden")
        }
    })

    document.addEventListener('click', (e) => {
        if (!search.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden')
        }
    })
}
