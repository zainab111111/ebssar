<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon, Menu, X } from 'lucide-vue-next';
import { ref } from 'vue';

// Props for the hero section
const props = defineProps<{
    onGetStarted?: () => void;
}>();

const isOpen = ref(false);

const pages = [
    { name: 'Features', href: '#features' },
    { name: 'Stories', href: '#stories' },
    { name: 'Accessibility', href: '#accessibility' },
    { name: 'Contact', href: '#contact' },
];

// Default get started handler
const handleGetStarted = () => {
    if (props.onGetStarted) {
        props.onGetStarted();
    }
};

// Text-to-speech functionality for accessibility
const speakText = (text: string) => {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.rate = 0.8; // Slower rate for better comprehension
        utterance.volume = 0.8;
        speechSynthesis.speak(utterance);
    }
};

// Handle keyboard events for buttons
const handleKeyDown = (event: KeyboardEvent) => {
    if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        handleGetStarted();
    }
};
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-between py-4">
                <!-- Home Icon -->
                <Link href="/" class="flex items-center">
                    <HomeIcon class="h-8 w-8 text-primary" />
                </Link>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex md:items-center md:gap-4">
                    <NavigationMenu>
                        <NavigationMenuList>
                            <NavigationMenuItem v-for="page in pages" :key="page.name">
                                <NavigationMenuLink :href="page.href" :class="navigationMenuTriggerStyle()" class="text-lg font-medium">
                                    {{ page.name }}
                                </NavigationMenuLink>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>

                    <!-- Desktop Auth Buttons -->
                    <template v-if="!$page.props.auth.user">
                        <Button as-child variant="ghost" class="text-lg font-medium">
                            <Link :href="route('login')">Log in</Link>
                        </Button>
                        <Button as-child class="text-lg font-medium">
                            <Link :href="route('register')">Register</Link>
                        </Button>
                    </template>
                    <Button v-else as-child class="text-lg font-medium">
                        <Link :href="route('dashboard')">Dashboard</Link>
                    </Button>
                </div>

                <!-- Mobile Menu -->
                <div class="flex md:hidden">
                    <DropdownMenu v-model:open="isOpen">
                        <DropdownMenuTrigger as-child>
                            <Button variant="default" size="icon" aria-label="Toggle menu">
                                <Menu v-if="!isOpen" class="h-[1.2rem] w-[1.2rem] transition-all duration-300 ease-in-out" />
                                <X v-else class="h-[1.2rem] w-[1.2rem] transition-all duration-300 ease-in-out" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <template v-for="page in pages" :key="page.name">
                                <DropdownMenuItem as-child>
                                    <Link :href="page.href" class="w-full justify-center text-lg font-medium" @click="isOpen = false">
                                        {{ page.name }}
                                    </Link>
                                </DropdownMenuItem>
                            </template>

                            <DropdownMenuItem v-if="!$page.props.auth.user" as-child>
                                <Link :href="route('login')" class="w-full justify-center text-lg font-medium" @click="isOpen = false"> Log in </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem v-if="!$page.props.auth.user" as-child>
                                <Link :href="route('register')" class="w-full justify-center text-lg font-medium" @click="isOpen = false">
                                    Register
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem v-else as-child>
                                <Link :href="route('dashboard')" class="w-full justify-center text-lg font-medium" @click="isOpen = false">
                                    Dashboard
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section
            class="relative flex min-h-screen w-full justify-center bg-background px-4 py-16"
            role="banner"
            aria-label="Hero section for accessible e-learning platform"
        >
            <!-- Background pattern for visual interest -->
            <div class="absolute inset-0 bg-card/30" aria-hidden="true"></div>

            <div class="relative z-10 mx-auto w-full max-w-6xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <!-- Content Section -->
                    <div class="space-y-8 text-center lg:text-left">
                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-4xl leading-tight font-black text-primary md:text-5xl lg:text-6xl" id="main-heading">
                                Empower Your Learning Journey
                            </h1>

                            <!-- Text-to-speech button for main heading -->
                            <button
                                @click="() => speakText('Empower Your Learning Journey')"
                                class="sr-only rounded-md bg-accent px-3 py-2 text-sm font-medium text-accent-foreground focus:not-sr-only focus:absolute focus:top-4 focus:left-4"
                                aria-label="Listen to main heading"
                                type="button"
                            >
                                🔊 Listen to Heading
                            </button>
                        </div>

                        <!-- Subheading -->
                        <div class="space-y-4">
                            <h2 class="text-xl leading-relaxed font-semibold text-foreground md:text-2xl lg:text-3xl" id="sub-heading">
                                Accessible Education for All Abilities
                            </h2>

                            <!-- Text-to-speech button for subheading -->
                            <button
                                @click="() => speakText('Accessible Education for All Abilities')"
                                class="sr-only rounded-md bg-accent px-3 py-2 text-sm font-medium text-accent-foreground focus:not-sr-only focus:absolute focus:top-16 focus:left-4"
                                aria-label="Listen to subheading"
                                type="button"
                            >
                                🔊 Listen to Subheading
                            </button>
                        </div>

                        <!-- Description -->
                        <p class="mx-auto max-w-2xl text-lg leading-relaxed text-muted-foreground md:text-xl lg:mx-0">
                            Experience learning designed with accessibility at its core. Our platform provides comprehensive educational resources
                            with full screen reader support, high contrast visuals, and adaptive technologies for deaf and blind learners.
                        </p>

                        <!-- Call to Action -->
                        <div class="flex flex-col justify-center gap-4 sm:flex-row lg:justify-start">
                            <Button
                                variant="default"
                                size="lg"
                                @click="handleGetStarted"
                                @keydown="handleKeyDown"
                                class="min-h-[44px] min-w-[44px] px-8 py-4 text-lg font-semibold focus:ring-4 focus:ring-accent/50"
                                aria-label="Get started with accessible learning platform"
                                role="button"
                                tabindex="0"
                                as-child
                            >
                                <Link href="/auth"> Get Started </Link>
                            </Button>

                            <Button
                                variant="outline"
                                size="lg"
                                class="min-h-[44px] min-w-[44px] px-8 py-4 text-lg font-semibold focus:ring-4 focus:ring-primary/50"
                                aria-label="Learn more about our accessibility features"
                                role="button"
                                tabindex="0"
                                as-child
                            >
                                <a href="#features"> Learn More </a>
                            </Button>
                        </div>

                        <!-- Accessibility Features List -->
                        <div class="mt-12 space-y-4">
                            <h3 class="text-lg font-semibold text-primary">Accessibility Features:</h3>
                            <ul class="grid gap-3 text-foreground sm:grid-cols-2" role="list" aria-label="List of accessibility features">
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent" aria-hidden="true"></span>
                                    <span>Screen Reader Compatible</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent" aria-hidden="true"></span>
                                    <span>High Contrast Design</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent" aria-hidden="true"></span>
                                    <span>Keyboard Navigation</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent" aria-hidden="true"></span>
                                    <span>Text-to-Speech Support</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent" aria-hidden="true"></span>
                                    <span>Large Touch Targets</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent" aria-hidden="true"></span>
                                    <span>Adaptive Learning Paths</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Visual Section -->
                    <div class="flex justify-center lg:justify-end">
                        <div
                            class="relative aspect-square w-full max-w-lg rounded-2xl border border-border bg-card p-8 shadow-lg"
                            role="img"
                            aria-label="Illustration showing diverse learners using accessible technology for education"
                        >
                            <!-- Placeholder for inclusive learning illustration -->
                            <img
                                src="/hero.jpg?height=400&width=400"
                                alt="Diverse students with disabilities engaging with accessible learning technology, including a person using a braille display, another using a screen reader, and sign language interpretation"
                                class="h-full w-full rounded-lg object-cover"
                                loading="eager"
                            />

                            <!-- Decorative elements -->
                            <div class="absolute -top-4 -right-4 h-8 w-8 rounded-full bg-accent" aria-hidden="true"></div>
                            <div class="absolute -bottom-4 -left-4 h-6 w-6 rounded-full bg-primary" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skip to main content link for screen readers -->
            <a
                href="#main-content"
                class="sr-only z-50 rounded-md bg-primary px-4 py-2 font-medium text-primary-foreground focus:not-sr-only focus:absolute focus:top-4 focus:right-4"
            >
                Skip to main content
            </a>
        </section>
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
</style>
