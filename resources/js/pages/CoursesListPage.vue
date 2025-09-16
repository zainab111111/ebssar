<script setup lang="ts">
import CommandPalette from '@/components/CommandPalette.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Ear, Eye, Hand, HomeIcon, Menu, MessageSquare, Users, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

// Mobile menu state
const isMobileMenuOpen = ref(false);

// Computed properties
const isAuthenticated = computed(() => usePage().props.auth?.user);

// Methods
const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};

const pages = [
    { name: 'الدورات', href: '/courses-list' },
    { name: 'الميزات', href: '/#features' },
    { name: 'القصص', href: '/#stories' },
    { name: 'إمكانية الوصول', href: '/#accessibility' },
    { name: 'اتصل بنا', href: '/#contact' },
];

// Text-to-speech functionality for accessibility
const speakText = (text: string) => {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.rate = 0.8;
        utterance.volume = 0.8;
        utterance.lang = 'ar-SA'; // Arabic language
        speechSynthesis.speak(utterance);
    }
};

// Features data
const features = [
    {
        icon: Eye,
        title: 'إمكانية الوصول البصري',
        description: 'سمات عالية التباين، أحجام خطوط مناسبة، وتحسين قارئ الشاشة للمتعلمين ضعاف البصر.',
        ariaLabel: 'ميزات إمكانية الوصول البصري دعم قارئ الشاشة',
    },
    {
        icon: Ear,
        title: 'الدعم الصوتي',
        description: 'تحويل النص إلى كلام، أوصاف صوتية،وتحويل الكلام الى نص.',
        ariaLabel: 'ميزات الدعم الصوتي تشمل تحويل النص إلى كلام و وتحويل الكلام الى نص',
    },
    {
        icon: Hand,
        title: 'إمكانية الوصول الحركي',
        description: ' التنقل بلوحة المفاتيح، قارئ الشاشة، وطرق الإدخال التكيفية للمستخدمين ذوي  الاحتياجات الخاصة المكفوفين و الصم و البكم.',
        ariaLabel: 'ميزات إمكانية الوصول الحركي تشمل التنقل بلوحة المفاتيح و قارئ الشاشة ',
    },
    {
        icon: BookOpen,
        title: 'التعلم ',
        description: 'سوف تكون الكورسات مهيئة لتتكيف مع المكفوفين و الصم و البكم',
        ariaLabel: 'يمكن للمكفوفين اختيار الكوس المطلوب و المناسب بنسبه لهم',
    },
    {
        icon: Users,
        title: 'المكتبة التعليمية ',
        description: 'مجموعة من الدروس ،المواد الصوتية و المرئية ،و المراجع المنظمة بشكل يسهل الوصول أليها',
        ariaLabel: 'دروس و مواد تعليمية ميسرة للجميع',
    },
    {
        icon: MessageSquare,
        title: 'التواصل',
        description: 'أرسل لنا رسال',
        ariaLabel: 'رساله',
    },
];

const props = defineProps({
    courses: Array<any>,
});

console.log(props.courses);
</script>

<template>
    <Head title="Courses" />

    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] text-[#1b1b18] lg:px-96 dark:bg-[#0a0a0a]"
        style="font-family: 'Cairo', 'Noto Sans Arabic', sans-serif"
    >
        <header class="fixed z-50 mb-6 w-full bg-background px-16 text-sm not-has-[nav]:hidden" role="banner">
            <nav class="flex items-center justify-between py-4" role="navigation">
                <!-- Home Link -->
                <div class="flex items-center gap-4">
                    <Link
                        href="/"
                        class="flex items-center focus:rounded focus:ring-2 focus:ring-primary focus:outline-none"
                        aria-label="الصفحة الرئيسية"
                    >
                        <HomeIcon class="h-8 w-8 text-primary" aria-hidden="true" />
                    </Link>
                    <CommandPalette />
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex md:items-center md:gap-4">
                    <NavigationMenu>
                        <NavigationMenuList>
                            <NavigationMenuItem v-for="page in pages" :key="page.name">
                                <NavigationMenuLink
                                    :href="page.href"
                                    :class="navigationMenuTriggerStyle()"
                                    class="text-lg font-medium transition-colors hover:text-primary focus:text-primary"
                                >
                                    {{ page.name }}
                                </NavigationMenuLink>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>

                    <!-- Desktop Auth Section -->
                    <div class="flex items-center gap-2">
                        <template v-if="!isAuthenticated">
                            <Button as-child variant="ghost" class="text-lg font-medium">
                                <Link :href="route('login')">تسجيل الدخول</Link>
                            </Button>
                            <Button as-child class="text-lg font-medium">
                                <Link :href="route('register')">التسجيل</Link>
                            </Button>
                        </template>
                        <Button v-else as-child class="text-lg font-medium">
                            <Link :href="route('courses.index')">دوراتي</Link>
                        </Button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div class="flex md:hidden">
                    <DropdownMenu v-model:open="isMobileMenuOpen">
                        <DropdownMenuTrigger as-child>
                            <Button
                                variant="default"
                                size="icon"
                                :aria-label="isMobileMenuOpen ? 'إغلاق القائمة' : 'فتح القائمة'"
                                :aria-expanded="isMobileMenuOpen"
                            >
                                <Transition name="menu-icon" mode="out-in">
                                    <Menu v-if="!isMobileMenuOpen" key="menu" class="h-5 w-5" aria-hidden="true" />
                                    <X v-else key="close" class="h-5 w-5" aria-hidden="true" />
                                </Transition>
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent align="end" class="w-56" @close-auto-focus.prevent>
                            <!-- Navigation Links -->
                            <template v-for="page in pages" :key="page.name">
                                <DropdownMenuItem as-child>
                                    <Link :href="page.href" class="w-full justify-center text-lg font-medium" @click="closeMobileMenu">
                                        {{ page.name }}
                                    </Link>
                                </DropdownMenuItem>
                            </template>

                            <!-- Separator -->
                            <DropdownMenuSeparator v-if="pages.length > 0" />

                            <!-- Auth Links -->
                            <template v-if="!isAuthenticated">
                                <DropdownMenuItem as-child>
                                    <Link :href="route('login')" class="w-full justify-center text-lg font-medium" @click="closeMobileMenu">
                                        تسجيل الدخول
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link :href="route('register')" class="w-full justify-center text-lg font-medium" @click="closeMobileMenu">
                                        التسجيل
                                    </Link>
                                </DropdownMenuItem>
                            </template>
                            <DropdownMenuItem v-else as-child>
                                <Link :href="route('courses.index')" class="w-full justify-center text-lg font-medium" @click="closeMobileMenu">
                                    لوحة التحكم
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </nav>
        </header>
        <div dir="rtl" class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4 pt-36">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    v-for="course in props.courses"
                    :key="course.id"
                    class="relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <Card :class="course.is_completed == 1 ? 'border-2 border-green-300' : ''">
                        <CardHeader>
                            <CardTitle class="">
                                <img :src="course.image_url || course.image" :alt="course.name" loading="lazy" class="aspect-video rounded" />
                            </CardTitle>
                            <CardDescription>{{ course.description }}</CardDescription>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-2">
                            {{ course.name }}
                            <Button :class="course.is_completed == 1 ? 'bg-green-500' : ''" class="w-full">
                                <Link class="w-full" :href="route('courses.show', course.id)">
                                    {{ course.is_completed == 1 ? 'تم التعلم' : 'ابدأ التعلم' }}
                                </Link>
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>
