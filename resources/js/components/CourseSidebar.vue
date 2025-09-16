<script setup lang="ts">
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { router } from '@inertiajs/vue3';
import { CheckCircle, Milestone, Play } from 'lucide-vue-next';

interface Course {
    id: number | string;
    name: string;
    description: string;
    image_url: string;
    is_completed: boolean;
}

interface Lesson {
    id: number | string;
    title: string;
    index: number;
    audio_url: string;
    content: string;
    is_completed: boolean;
}

const props = defineProps<{
    course?: Course;
    lessons?: Lesson[];
    currentLesson?: Lesson;
}>();

// Menu items with active state
const items = props.lessons?.map((item) => ({
    title: item.title,
    url: `/courses/${props.course?.id}/lessons/${item.id}`,
    icon: item.is_completed ? CheckCircle : props.currentLesson?.id === item.id ? Play : Milestone,
    isActive: props.currentLesson?.id === item.id,
    isCompleted: item.is_completed,
}));

const handleLessonClick = (url: string, event: Event) => {
    event.preventDefault();
    // No need to manually mark as complete - it happens automatically on page load
    router.get(url);
};
</script>

<template>
    <Sidebar variant="sidebar">
        <SidebarHeader>
            <div class="flex flex-col items-center gap-2 p-4">
                <img :src="props.course?.image_url" alt="Course image" loading="lazy"
                    class="aspect-video w-full rounded object-cover" />
                <h2 class="text-center text-sm font-semibold">
                    {{ props.course?.name }}
                </h2>
                <!-- Progress indicator -->
                <div v-if="props.course" class="w-full">
                    <div class="mb-1 flex justify-between text-xs text-gray-500">
                        <span>Progress</span>
                        <span>{{items?.filter((item) => item.isCompleted).length || 0}} / {{ items?.length || 0
                            }}</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-green-600 transition-all duration-300"
                            :style="{ width: `${items?.length ? (items.filter((item) => item.isCompleted).length / items.length) * 100 : 0}%` }">
                        </div>
                    </div>
                </div>
            </div>
        </SidebarHeader>
        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="item in items" :key="item.title">
                            <SidebarMenuButton :class="{
                                'bg-accent text-accent-foreground': item.isActive,
                                'text-green-600': item.isCompleted && !item.isActive,
                                'opacity-75': item.isCompleted && !item.isActive,
                            }" @click="(event: Event) => handleLessonClick(item.url, event)">
                                <component :is="item.icon" :class="{
                                    'text-green-600': item.isCompleted,
                                    'text-blue-600': item.isActive && !item.isCompleted,
                                }" />
                                <span>{{ item.title }}</span>
                                <!-- Auto-completed indicator -->
                                <span v-if="item.isCompleted && !item.isActive" class="ml-auto text-xs text-green-600">
                                    ✓ </span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
