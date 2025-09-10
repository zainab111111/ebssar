<script setup lang="ts">
import CommandPalette from '@/components/CommandPalette.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Textarea } from '@/components/ui/textarea';
import { Head, Link } from '@inertiajs/vue3';
import { Accessibility, BookOpen, Ear, Eye, Hand, Heart, HomeIcon, Mail, Menu, MessageSquare, Phone, Star, Users, Volume2, X } from 'lucide-vue-next';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { computed, } from 'vue';

// Mobile menu state
const isMobileMenuOpen = ref(false)

// Computed properties
const isAuthenticated = computed(() => usePage().props.auth?.user)

// Methods
const closeMobileMenu = () => {
    isMobileMenuOpen.value = false
}

const pages = [
    { name: 'الميزات', href: '#features' },
    { name: 'القصص', href: '#stories' },
    { name: 'إمكانية الوصول', href: '#accessibility' },
    { name: 'اتصل بنا', href: '#contact' },
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

// Stories data
const stories = [
    {
        name: 'سارة ',
        role: 'طالبة علوم الحاسوب',
        story: 'كطالبة مكفوفة، لم أعتقد أبداً أنني أستطيع دراسة البرمجة. توافق هذه المنصة مع قارئ الشاشة ودروس البرمجة الصوتية جعل من الممكن لي أن أتعلم وأتفوق في علوم الحاسوب.',
        rating: 5,
        ariaLabel: 'قصة نجاح من سارة، طالبة علوم الحاسوب المكفوفة',
    },
    {
        name: ' أحمد',
        role: 'مدافع عن تعليم الصم',
        story: 'ترجمة لغة الإشارة وأدوات التعلم البصري غيرت طريقة وصولي للمحتوى التعليمي. أخيراً، منصة تفهم حقاً احتياجات المتعلمين الصم.',
        rating: 5,
        ariaLabel: 'قصة نجاح من أحمد، مدافع عن تعليم الصم',
    },
    {
        name: 'إيما ',
        role: 'معلمة وأم',
        story: 'ابنتي تعاني من عسر القراءة، وميزات النص التكيفي لهذه المنصة ونهج التعلم متعدد الحواس عززت ثقتها وأداءها الأكاديمي بشكل كبير.',
        rating: 5,
        ariaLabel: 'قصة نجاح من إيما، معلمة وأم لطفل يعاني من عسر القراءة',
    },
];

// Contact form handling
const contactForm = ref({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submitContact = () => {
    // Handle form submission
    console.log('Contact form submitted:', contactForm.value);
    // Reset form
    contactForm.value = { name: '', email: '', subject: '', message: '' };
};
</script>

<template>

    <Head title="مرحباً بك في إبصار">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]"
        style="font-family: 'Cairo', 'Noto Sans Arabic', sans-serif">
        <header class="mb-6 w-full fixed bg-background z-50 px-16 text-sm not-has-[nav]:hidden " role="banner">
            <nav class="flex items-center justify-between py-4" role="navigation">
                <!-- Home Link -->
                <div class="flex gap-4 items-center">
                    <Link href="/"
                        class="flex items-center focus:outline-none focus:ring-2 focus:ring-primary focus:rounded"
                        aria-label="الصفحة الرئيسية">
                    <HomeIcon class="h-8 w-8 text-primary" aria-hidden="true" />
                    </Link>
                    <CommandPalette />

                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex md:items-center md:gap-4">
                    <NavigationMenu>
                        <NavigationMenuList>
                            <NavigationMenuItem v-for="page in pages" :key="page.name">
                                <NavigationMenuLink :href="page.href" :class="navigationMenuTriggerStyle()"
                                    class="text-lg font-medium transition-colors hover:text-primary focus:text-primary">
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
                            <Button variant="default" size="icon"
                                :aria-label="isMobileMenuOpen ? 'إغلاق القائمة' : 'فتح القائمة'"
                                :aria-expanded="isMobileMenuOpen">
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
                                    <Link :href="page.href" class="w-full justify-center text-lg font-medium"
                                        @click="closeMobileMenu">
                                    {{ page.name }}
                                    </Link>
                                </DropdownMenuItem>
                            </template>

                            <!-- Separator -->
                            <DropdownMenuSeparator v-if="pages.length > 0" />

                            <!-- Auth Links -->
                            <template v-if="!isAuthenticated">
                                <DropdownMenuItem as-child>
                                    <Link :href="route('login')" class="w-full justify-center text-lg font-medium"
                                        @click="closeMobileMenu">
                                    تسجيل الدخول
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link :href="route('register')" class="w-full justify-center text-lg font-medium"
                                        @click="closeMobileMenu">
                                    التسجيل
                                    </Link>
                                </DropdownMenuItem>
                            </template>
                            <DropdownMenuItem v-else as-child>
                                <Link :href="route('courses.index')" class="w-full justify-center text-lg font-medium"
                                    @click="closeMobileMenu">
                                لوحة التحكم
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="relative pt-28 flex min-h-screen w-full justify-center bg-background px-4 py-16" role="banner"
            aria-label="قسم البطل لمنصة التعلم الإلكتروني المتاحة" dir="rtl">
            <!-- Background pattern for visual interest -->
            <div class="absolute inset-0 bg-card/30" aria-hidden="true"></div>

            <div class="relative z-10 mx-auto w-full max-w-6xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <!-- Content Section -->
                    <div class="space-y-8 text-center lg:text-right">
                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-4xl leading-tight font-black text-primary md:text-5xl lg:text-6xl"
                                id="main-heading">
                                اطلق العنان لرحلة التعلم الخاصة بك
                            </h1>

                            <!-- Text-to-speech button for main heading -->
                            <button @click="() => speakText('اطلق العنان لرحلة التعلم الخاصة بك')"
                                class="sr-only rounded-md bg-accent px-3 py-2 text-sm font-medium text-accent-foreground focus:not-sr-only focus:absolute focus:top-4 focus:right-4"
                                aria-label="استمع للعنوان الرئيسي" type="button">
                                🔊 استمع للعنوان
                            </button>
                        </div>

                        <!-- Subheading -->
                        <div class="space-y-4">
                            <h2 class="text-xl leading-relaxed font-semibold text-foreground md:text-2xl lg:text-3xl"
                                id="sub-heading">
                                تعليم متاح لجميع القدرات
                            </h2>

                            <!-- Text-to-speech button for subheading -->
                            <button @click="() => speakText('تعليم متاح لجميع القدرات')"
                                class="sr-only rounded-md bg-accent px-3 py-2 text-sm font-medium text-accent-foreground focus:not-sr-only focus:absolute focus:top-16 focus:right-4"
                                aria-label="استمع للعنوان الفرعي" type="button">
                                🔊 استمع للعنوان الفرعي
                            </button>
                        </div>

                        <!-- Description -->
                        <p class="mx-auto max-w-2xl text-lg leading-relaxed text-muted-foreground md:text-xl lg:mx-0">
                            اختبر التعلم المصمم مع إمكانية الوصول في جوهره. توفر منصتنا موارد تعليمية شاملة مع دعم كامل
                            لقارئ
                            الشاشة، وصور عالية
                            التباين، وتقنيات تكيفية للمتعلمين الصم والمكفوفين.
                        </p>

                        <!-- Call to Action -->
                        <div class="flex flex-col justify-center gap-4 sm:flex-row lg:justify-start">
                            <Button variant="default" size="lg"
                                class="min-h-[44px] min-w-[44px] px-8 py-4 text-lg font-semibold focus:ring-4 focus:ring-accent/50"
                                aria-label="ابدأ مع منصة التعلم المتاحة" role="button" tabindex="0" as-child>
                                <Link :href="route('courses.index')"> ابدأ الآن </Link>
                            </Button>

                            <Button variant="outline" size="lg"
                                class="min-h-[44px] min-w-[44px] px-8 py-4 text-lg font-semibold focus:ring-4 focus:ring-primary/50"
                                aria-label="تعرف على المزيد حول ميزات إمكانية الوصول" role="button" tabindex="0"
                                as-child>
                                <a href="#features"> تعرف على المزيد </a>
                            </Button>
                        </div>

                        <!-- Accessibility Features List -->
                        <div class="mt-12 space-y-4">
                            <h3 class="text-lg font-semibold text-primary">ميزات إمكانية الوصول:</h3>
                            <ul class="grid gap-3 text-foreground sm:grid-cols-2" role="list"
                                aria-label="قائمة ميزات إمكانية الوصول">
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>متوافق مع قارئ الشاشة</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>تصميم عالي التباين</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>التنقل بلوحة المفاتيح</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>دعم تحويل النص إلى كلام</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>أهداف لمس كبيرة</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>مسارات تعلم تكيفية</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Visual Section -->
                    <div class="flex justify-center lg:justify-end">
                        <div class="relative aspect-square w-full max-w-lg rounded-2xl border border-border bg-card p-8 shadow-lg"
                            role="img"
                            aria-label="رسم توضيحي يظهر متعلمين متنوعين يستخدمون التكنولوجيا المتاحة للتعليم">
                            <!-- Placeholder for inclusive learning illustration -->
                            <img src="/hero.jpg?height=400&width=400"
                                alt="طلاب متنوعون من ذوي الإعاقة يتفاعلون مع تكنولوجيا التعلم المتاحة، بما في ذلك شخص يستخدم شاشة برايل، وآخر يستخدم قارئ الشاشة، وترجمة لغة الإشارة"
                                class="h-full w-full rounded-lg object-cover" loading="eager" />

                            <!-- Decorative elements -->
                            <div class="absolute -top-4 -left-4 h-8 w-8 rounded-full bg-accent" aria-hidden="true">
                            </div>
                            <div class="absolute -right-4 -bottom-4 h-6 w-6 rounded-full bg-primary" aria-hidden="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skip to main content link for screen readers -->
            <a href="#main-content"
                class="sr-only z-50 rounded-md bg-primary px-4 py-2 font-medium text-primary-foreground focus:not-sr-only focus:absolute focus:top-4 focus:left-4">
                انتقل إلى المحتوى الرئيسي
            </a>
        </section>

        <!-- Main Content -->
        <main id="main-content" class="w-full">
            <!-- Features Section -->
            <section id="features" class="w-full bg-muted/30 py-20" aria-labelledby="features-heading">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="mb-16 text-center">
                        <h2 id="features-heading" class="mb-4 text-3xl font-bold text-primary md:text-4xl lg:text-5xl">
                            ميزات تركز على إمكانية الوصول أولاً
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-muted-foreground">
                            تم بناء منصتنا من الأساس مع وضع إمكانية الوصول في الاعتبار، مما يضمن نجاح كل متعلم بغض النظر
                            عن
                            قدراته.
                        </p>
                        <Button @click="
                            () =>
                                speakText(
                                    'ميزات تركز على إمكانية الوصول أولاً. تم بناء منصتنا من الأساس مع وضع إمكانية الوصول في الاعتبار، مما يضمن نجاح كل متعلم بغض النظر عن قدراته.',
                                )
                        " variant="ghost" size="sm" class="mt-4" aria-label="استمع لمقدمة قسم الميزات">
                            <Volume2 class="ml-2 h-4 w-4" />
                            استمع للقسم
                        </Button>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <Card v-for="(feature, index) in features" :key="index"
                            class="group transition-all duration-300 focus-within:ring-2 focus-within:ring-primary/50 hover:shadow-lg"
                            :aria-label="feature.ariaLabel">
                            <CardHeader class="text-center">
                                <div
                                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 transition-colors group-hover:bg-primary/20">
                                    <component :is="feature.icon" class="h-8 w-8 text-primary" aria-hidden="true" />
                                </div>
                                <CardTitle class="text-xl font-semibold">{{ feature.title }}</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <CardDescription class="text-center text-base leading-relaxed">
                                    {{ feature.description }}
                                </CardDescription>
                                <Button @click="() => speakText(`${feature.title}. ${feature.description}`)"
                                    variant="ghost" size="sm" class="mt-4 w-full"
                                    :aria-label="`استمع لوصف ميزة ${feature.title}`">
                                    <Volume2 class="ml-2 h-4 w-4" />
                                    استمع
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>

            <!-- Stories Section -->
            <section id="stories" class="w-full py-20" aria-labelledby="stories-heading">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="mb-16 text-center">
                        <h2 id="stories-heading" class="mb-4 text-3xl font-bold text-primary md:text-4xl lg:text-5xl">
                            قصص النجاح
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-muted-foreground">
                            قصص حقيقية من متعلمين غيروا رحلتهم التعليمية من خلال التعلم المتاح.
                        </p>
                        <Button
                            @click="() => speakText('قصص النجاح. قصص حقيقية من متعلمين غيروا رحلتهم التعليمية من خلال التعلم المتاح.')"
                            variant="ghost" size="sm" class="mt-4" aria-label="استمع لمقدمة قسم قصص النجاح">
                            <Volume2 class="ml-2 h-4 w-4" />
                            استمع للقسم
                        </Button>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <Card v-for="(story, index) in stories" :key="index"
                            class="group transition-all duration-300 focus-within:ring-2 focus-within:ring-primary/50 hover:shadow-lg"
                            :aria-label="story.ariaLabel">
                            <CardHeader>
                                <div class="mb-4 flex items-center gap-4">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-primary to-accent text-lg font-bold text-white">
                                        {{
                                            story.name
                                                .split(' ')
                                                .map((n) => n[0])
                                                .join('')
                                        }}
                                    </div>
                                    <div>
                                        <CardTitle class="text-lg">{{ story.name }}</CardTitle>
                                        <p class="text-sm text-muted-foreground">{{ story.role }}</p>
                                    </div>
                                </div>
                                <div class="mb-4 flex gap-1" :aria-label="`${story.rating} من أصل 5 نجوم`">
                                    <Star v-for="i in 5" :key="i" class="h-4 w-4"
                                        :class="i <= story.rating ? 'fill-current text-yellow-400' : 'text-gray-300'"
                                        aria-hidden="true" />
                                </div>
                            </CardHeader>
                            <CardContent>
                                <blockquote class="text-base leading-relaxed italic">"{{ story.story }}"</blockquote>
                                <Button @click="() => speakText(`قصة من ${story.name}، ${story.role}. ${story.story}`)"
                                    variant="ghost" size="sm" class="mt-4 w-full"
                                    :aria-label="`استمع لقصة نجاح ${story.name}`">
                                    <Volume2 class="ml-2 h-4 w-4" />
                                    استمع للقصة
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>

            <!-- Accessibility Section -->
            <section id="accessibility" class="w-full bg-muted/30 py-20" aria-labelledby="accessibility-heading">
                <div class="mx-auto max-w-6xl px-4" dir="rtl">
                    <div class="mb-16 text-center">
                        <h2 id="accessibility-heading"
                            class="mb-4 text-3xl font-bold text-primary md:text-4xl lg:text-5xl">
                            التزامنا بإمكانية الوصول
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-muted-foreground">
                            نؤمن أن التعليم يجب أن يكون متاحاً للجميع. منصتنا تلبي وتتجاوز معايير WCAG 2.1 AA.
                        </p>
                        <Button @click="
                            () =>
                                speakText(
                                    'التزامنا بإمكانية الوصول. نؤمن أن التعليم يجب أن يكون متاحاً للجميع. منصتنا تلبي وتتجاوز معايير WCAG 2.1 AA.',
                                )
                        " variant="ghost" size="sm" class="mt-4" aria-label="استمع لمقدمة قسم التزام إمكانية الوصول">
                            <Volume2 class="ml-2 h-4 w-4" />
                            استمع للقسم
                        </Button>
                    </div>

                    <div class="grid items-center gap-12 lg:grid-cols-2">
                        <div class="space-y-8">
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/10">
                                        <Accessibility class="h-6 w-6 text-primary" aria-hidden="true" />
                                    </div>
                                    <div>
                                        <h3 class="mb-2 text-xl font-semibold">متوافق مع WCAG 2.1 AA</h3>
                                        <p class="text-muted-foreground">
                                            منصتنا تلبي أعلى معايير إمكانية الوصول للويب، مما يضمن التوافق مع جميع
                                            التقنيات
                                            المساعدة.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/10">
                                        <Heart class="h-6 w-6 text-primary" aria-hidden="true" />
                                    </div>
                                    <div>
                                        <h3 class="mb-2 text-xl font-semibold">تصميم شامل</h3>
                                        <p class="text-muted-foreground">
                                            كل ميزة مصممة مع وضع القدرات المتنوعة في الاعتبار، من اختيارات الألوان إلى
                                            أنماط
                                            التفاعل.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/10">
                                        <Users class="h-6 w-6 text-primary" aria-hidden="true" />
                                    </div>
                                    <div>
                                        <h3 class="mb-2 text-xl font-semibold">مختبر من المجتمع</h3>
                                        <p class="text-muted-foreground">
                                            يتم اختبار منصتنا بانتظام من قبل مستخدمين ذوي إعاقة لضمان إمكانية الوصول في
                                            العالم
                                            الحقيقي.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border bg-card p-6">
                                <h4 class="mb-4 text-lg font-semibold">معايير إمكانية الوصول التي نلبيها:</h4>
                                <ul class="space-y-2 text-sm" role="list">
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>WCAG 2.1 المستوى AA</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>امتثال القسم 508</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>امتثال ADA</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>المعيار الأوروبي EN 301 549</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <div class="relative">
                                <img src="/accessibility.jpg?height=500&width=500"
                                    alt="مجموعة متنوعة من الأشخاص ذوي الإعاقات المختلفة يستخدمون التقنيات المساعدة للوصول إلى المحتوى التعليمي على أجهزة الكمبيوتر والأجهزة المحمولة"
                                    class="h-auto max-w-full rounded-2xl shadow-lg" loading="lazy" />
                                <div class="absolute -bottom-4 -left-4 h-8 w-8 rounded-full bg-primary"
                                    aria-hidden="true">
                                </div>
                                <div class="absolute -top-4 -right-4 h-6 w-6 rounded-full bg-accent" aria-hidden="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="contact" class="w-full py-20" aria-labelledby="contact-heading" dir="rtl">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="mb-16 text-center">
                        <h2 id="contact-heading" class="mb-4 text-3xl font-bold text-primary md:text-4xl lg:text-5xl">
                            تواصل معنا
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-muted-foreground">
                            هل لديك أسئلة حول ميزات إمكانية الوصول أو تحتاج للدعم؟ نحن هنا لمساعدتك في جعل التعلم متاحاً
                            للجميع.
                        </p>
                        <Button @click="
                            () =>
                                speakText(
                                    'تواصل معنا. هل لديك أسئلة حول ميزات إمكانية الوصول أو تحتاج للدعم؟ نحن هنا لمساعدتك في جعل التعلم متاحاً للجميع.',
                                )
                        " variant="ghost" size="sm" class="mt-4" aria-label="استمع لمقدمة قسم التواصل">
                            <Volume2 class="ml-2 h-4 w-4" />
                            استمع للقسم
                        </Button>
                    </div>

                    <div class="grid gap-12 lg:grid-cols-2">
                        <!-- Contact Information -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="mb-6 text-2xl font-semibold">معلومات التواصل</h3>
                                <div class="space-y-6">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <Mail class="h-6 w-6 text-primary" aria-hidden="true" />
                                        </div>
                                        <div>
                                            <h4 class="mb-1 font-semibold">دعم البريد الإلكتروني</h4>
                                            <p class="text-muted-foreground">accessibility@learningplatform.com</p>
                                            <p class="mt-1 text-sm text-muted-foreground">دعم إمكانية الوصول متاح 24/7
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <Phone class="h-6 w-6 text-primary" aria-hidden="true" />
                                        </div>
                                        <div>
                                            <h4 class="mb-1 font-semibold">الدعم الهاتفي</h4>
                                            <p class="text-muted-foreground">+1 (555) 123-4567</p>
                                            <p class="mt-1 text-sm text-muted-foreground">TTY: +1 (555) 123-4568</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <MessageSquare class="h-6 w-6 text-primary" aria-hidden="true" />
                                        </div>
                                        <div>
                                            <h4 class="mb-1 font-semibold">الدردشة المباشرة</h4>
                                            <p class="text-muted-foreground">متاح مع دعم قارئ الشاشة</p>
                                            <p class="mt-1 text-sm text-muted-foreground">الاثنين - الجمعة، 9 صباحاً - 6
                                                مساءً
                                                بتوقيت شرق أمريكا</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border bg-card p-6">
                                <h4 class="mb-4 text-lg font-semibold">دعم إمكانية الوصول</h4>
                                <p class="mb-4 text-muted-foreground">فريق إمكانية الوصول المخصص لدينا متاح للمساعدة في:
                                </p>
                                <ul class="space-y-2 text-sm" role="list">
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>إعداد التقنيات المساعدة</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>مساعدة التنقل في المنصة</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>تدريب على ميزات إمكانية الوصول</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>طلبات التسهيلات المخصصة</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <Card class="p-6">
                            <CardHeader class="px-0 pt-0">
                                <CardTitle class="text-xl">أرسل لنا رسالة</CardTitle>
                                <CardDescription>املأ النموذج أدناه وسنعاود الاتصال بك خلال 24 ساعة.</CardDescription>
                            </CardHeader>
                            <CardContent class="px-0 pb-0">
                                <form @submit.prevent="submitContact" class="space-y-6" aria-label="نموذج التواصل">
                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div class="space-y-2">
                                            <Label for="contact-name" class="text-sm font-medium">
                                                الاسم <span class="text-red-500" aria-label="مطلوب">*</span>
                                            </Label>
                                            <Input id="contact-name" v-model="contactForm.name" type="text"
                                                placeholder="اسمك الكامل" required class="min-h-[44px]"
                                                aria-describedby="name-help" />
                                            <p id="name-help" class="sr-only">أدخل اسمك الكامل لأغراض التواصل</p>
                                        </div>
                                        <div class="space-y-2">
                                            <Label for="contact-email" class="text-sm font-medium">
                                                البريد الإلكتروني <span class="text-red-500" aria-label="مطلوب">*</span>
                                            </Label>
                                            <Input id="contact-email" v-model="contactForm.email" type="email"
                                                placeholder="your.email@example.com" required class="min-h-[44px]"
                                                aria-describedby="email-help" />
                                            <p id="email-help" class="sr-only">أدخل عنوان بريدك الإلكتروني لردنا</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="contact-subject" class="text-sm font-medium">
                                            الموضوع <span class="text-red-500" aria-label="مطلوب">*</span>
                                        </Label>
                                        <Input id="contact-subject" v-model="contactForm.subject" type="text"
                                            placeholder="كيف يمكننا مساعدتك؟" required class="min-h-[44px]"
                                            aria-describedby="subject-help" />
                                        <p id="subject-help" class="sr-only">وصف موجز لاستفسارك</p>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="contact-message" class="text-sm font-medium">
                                            الرسالة <span class="text-red-500" aria-label="مطلوب">*</span>
                                        </Label>
                                        <Textarea id="contact-message" v-model="contactForm.message"
                                            placeholder="يرجى وصف سؤالك أو كيف يمكننا مساعدتك..." required rows="5"
                                            class="min-h-[120px] resize-none" aria-describedby="message-help" />
                                        <p id="message-help" class="sr-only">وصف مفصل لاستفسارك أو طلب الدعم</p>
                                    </div>
                                    <Button type="submit" class="min-h-[44px] w-full text-lg font-semibold"
                                        aria-label="إرسال رسالة نموذج التواصل">
                                        إرسال الرسالة
                                    </Button>
                                </form>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="mt-20 w-full bg-muted/50 py-12" role="contentinfo" aria-label="تذييل الموقع" dir="rtl">
            <div class="mx-auto max-w-6xl px-4">
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Company Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <HomeIcon class="h-6 w-6 text-primary" aria-hidden="true" />
                            <span class="text-lg font-semibold">إبصار للتعلم</span>
                        </div>
                        <p class="text-sm text-muted-foreground">جعل التعليم متاحاً للجميع، في كل مكان. مبني مع إمكانية
                            الوصول
                            في جوهره.</p>
                        <Button
                            @click="() => speakText('إبصار للتعلم. جعل التعليم متاحاً للجميع، في كل مكان. مبني مع إمكانية الوصول في جوهره.')"
                            variant="ghost" size="sm" aria-label="استمع لوصف الشركة">
                            <Volume2 class="ml-2 h-4 w-4" />
                            استمع
                        </Button>
                    </div>

                    <!-- Quick Links -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">روابط سريعة</h3>
                        <nav aria-label="تنقل التذييل">
                            <ul class="space-y-2 text-sm" role="list">
                                <li role="listitem">
                                    <a href="#features"
                                        class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                        الميزات
                                    </a>
                                </li>
                                <li role="listitem">
                                    <a href="#stories"
                                        class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                        قصص النجاح
                                    </a>
                                </li>
                                <li role="listitem">
                                    <a href="#accessibility"
                                        class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                        إمكانية الوصول
                                    </a>
                                </li>
                                <li role="listitem">
                                    <a href="#contact"
                                        class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                        اتصل بنا
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Support -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">الدعم</h3>
                        <ul class="space-y-2 text-sm" role="list">
                            <li role="listitem">
                                <a href="/help"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    مركز المساعدة
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/accessibility-guide"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    دليل إمكانية الوصول
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/tutorials"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    دروس الفيديو
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/community"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    منتدى المجتمع
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">قانوني</h3>
                        <ul class="space-y-2 text-sm" role="list">
                            <li role="listitem">
                                <a href="/privacy"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    سياسة الخصوصية
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/terms"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    شروط الخدمة
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/accessibility-statement"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    بيان إمكانية الوصول
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/cookies"
                                    class="rounded text-muted-foreground transition-colors hover:text-foreground focus:ring-2 focus:ring-primary/50 focus:outline-none">
                                    سياسة ملفات تعريف الارتباط
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 border-t border-border pt-8">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <p class="text-sm text-muted-foreground">© 2025 إبصار للتعلم. جميع الحقوق محفوظة. ملتزمون
                            بإمكانية
                            الوصول الرقمي.</p>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-muted-foreground">متوافق مع WCAG 2.1 AA</span>
                            <div class="h-4 w-4 rounded-full bg-green-500" aria-label="معتمد لإمكانية الوصول"
                                title="متوافق مع WCAG 2.1 AA"></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Ensure focus indicators are highly visible */
*:focus-visible {
    outline: 3px solid var(--ring);
    outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .text-muted-foreground {
        color: var(--foreground);
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Ensure minimum touch target sizes */
button,
a,
input,
textarea {
    min-height: 44px;
    min-width: 44px;
}

/* Improve focus visibility for keyboard users */
.focus\:ring-4:focus {
    box-shadow: 0 0 0 4px var(--ring);
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

@media (prefers-reduced-motion: reduce) {
    html {
        scroll-behavior: auto;
    }
}

.menu-icon-enter-active,
.menu-icon-leave-active {
    transition: all 0.2s ease-in-out;
}

.menu-icon-enter-from,
.menu-icon-leave-to {
    opacity: 0;
    transform: rotate(90deg);
}
</style>
