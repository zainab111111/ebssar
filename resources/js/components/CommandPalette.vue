<script setup lang="ts">
import { CommandDialog, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator } from '@/components/ui/command';
import { useDebounce, useMagicKeys } from '@vueuse/core';
import axios from 'axios';
import { computed, ref, watch } from 'vue';

const open = ref(false);
const searchQuery = ref('');
const searchResults = ref<{
    courses: Array<{ id: number; name: string }>;
    lessons: Array<{ id: number; name: string; course?: { name: string } }>;
}>({
    courses: [],
    lessons: [],
});
const isSearching = ref(false);
const searchError = ref<string | null>(null);

// Debounce the search query
const debouncedSearchQuery = useDebounce(searchQuery, 300);

const homepageItems = [
    { name: 'الميزات', href: '/#features', icon: 'star' },
    { name: 'القصص', href: '/#stories', icon: 'book' },
    { name: 'إمكانية الوصول', href: '/#accessibility', icon: 'accessibility' },
    { name: 'اتصل بنا', href: '/#contact', icon: 'phone' },
    { name: 'دوراتي', href: '/courses', icon: 'graduation-cap' },
];

// Computed property to check if we have any results
const hasResults = computed(() => searchResults.value.courses.length > 0 || searchResults.value.lessons.length > 0);

// AbortController for cancelling previous requests
let searchController: AbortController | null = null;

const performSearch = async (query: string) => {
    if (query.length < 2) {
        searchResults.value = { courses: [], lessons: [] };
        searchError.value = null;
        return;
    }

    // Cancel previous request
    if (searchController) {
        searchController.abort();
    }

    searchController = new AbortController();
    isSearching.value = true;
    searchError.value = null;

    try {
        const response = await axios.get(`/search?q=${encodeURIComponent(query)}`, {
            signal: searchController.signal,
            timeout: 5000, // 5 second timeout
        });

        searchResults.value = response.data;
    } catch (error) {
        if (!axios.isCancel(error)) {
            console.error('Search error:', error);
            searchError.value = 'حدث خطأ أثناء البحث';
            searchResults.value = { courses: [], lessons: [] };
        }
    } finally {
        isSearching.value = false;
        searchController = null;
    }
};

// Watch debounced query instead of direct query
watch(debouncedSearchQuery, (newQuery) => {
    performSearch(newQuery);
});

const { Meta_J, Ctrl_K } = useMagicKeys({
    passive: false,
    onEventFired(e) {
        if (e.key === 'k' && (e.metaKey || e.ctrlKey)) e.preventDefault();
    },
});

watch([Meta_J, Ctrl_K], (v) => {
    if (v[0] || v[1]) handleOpenChange();
});

function handleOpenChange() {
    open.value = !open.value;
    if (!open.value) {
        searchQuery.value = '';
        searchResults.value = { courses: [], lessons: [] };
        searchError.value = null;
        // Cancel any ongoing search
        if (searchController) {
            searchController.abort();
            searchController = null;
        }
    }
}

function handleItemSelect(href: string) {
    open.value = false;
    window.location.href = href;
}

function handleSearchInput(value: string) {
    searchQuery.value = value;
}
</script>

<template>
    <div>
        <div class="w-full flex-1 md:w-auto md:flex-none">
            <button
                @click="handleOpenChange"
                dir="rtl"
                class="group relative inline-flex h-8 w-full items-center justify-start gap-2 rounded-lg border border-primary bg-muted/50 px-4 py-2 text-sm font-normal text-muted-foreground shadow-sm ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50 sm:pr-12 md:w-40 lg:w-56 xl:w-64"
            >
                <svg class="pointer-events-none size-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <span class="hidden truncate lg:inline-flex">البحث عن الدورات</span>
                <span class="inline-flex truncate lg:hidden">بحث...</span>
                <kbd
                    class="pointer-events-none absolute top-1.5 right-1.5 hidden h-5 items-center gap-1 rounded border border-border bg-muted px-1.5 font-mono text-[10px] font-medium opacity-75 select-none sm:inline-flex"
                >
                    <span class="text-xs">⌘</span>K
                </kbd>
            </button>
        </div>

        <CommandDialog v-model:open="open">
            <CommandInput placeholder="البحث عن الدورات والدروس..." :model-value="searchQuery" @update:model-value="handleSearchInput" />
            <CommandList>
                <CommandEmpty>
                    <div class="py-4 text-center">
                        <div v-if="isSearching" class="flex items-center justify-center gap-2">
                            <div class="h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"></div>
                            <span>جاري البحث...</span>
                        </div>
                        <div v-else-if="searchError" class="text-destructive">
                            {{ searchError }}
                        </div>
                        <div v-else-if="searchQuery && !hasResults">لا توجد نتائج لـ "{{ searchQuery }}"</div>
                        <div v-else>اكتب للبحث عن الدورات والدروس</div>
                    </div>
                </CommandEmpty>

                <!-- Show navigation items only when not searching -->
                <template v-if="!searchQuery">
                    <CommandGroup heading="التنقل">
                        <CommandItem v-for="item in homepageItems" :key="item.name" :value="item.name" @select="handleItemSelect(item.href)">
                            {{ item.name }}
                        </CommandItem>
                    </CommandGroup>
                    <CommandSeparator />
                </template>

                <!-- Show search results -->
                <template v-if="searchQuery && hasResults">
                    <CommandGroup v-if="searchResults.courses.length > 0" heading="الدورات">
                        <CommandItem
                            v-for="course in searchResults.courses"
                            :key="`course-${course.id}`"
                            :value="course.name"
                            @select="handleItemSelect(`/courses/${course.id}`)"
                        >
                            <div class="flex items-center gap-2">
                                <svg class="size-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    />
                                </svg>
                                <span>{{ course.name }}</span>
                            </div>
                        </CommandItem>
                    </CommandGroup>

                    <CommandSeparator v-if="searchResults.courses.length > 0 && searchResults.lessons.length > 0" />

                    <CommandGroup v-if="searchResults.lessons.length > 0" heading="الدروس">
                        <CommandItem
                            v-for="lesson in searchResults.lessons"
                            :key="`lesson-${lesson.id}`"
                            :value="lesson.name"
                            @select="handleItemSelect(`/lessons/${lesson.id}`)"
                        >
                            <div class="flex items-center gap-2">
                                <svg class="size-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                    />
                                </svg>
                                <div>
                                    <div>{{ lesson.name }}</div>
                                    <div v-if="lesson.course" class="text-xs text-muted-foreground">في دورة: {{ lesson.course.name }}</div>
                                </div>
                            </div>
                        </CommandItem>
                    </CommandGroup>

                    <CommandSeparator />
                </template>
            </CommandList>
        </CommandDialog>
    </div>
</template>
