<script setup lang="ts">
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
import {
    Accessibility,
    BookOpen,
    Ear,
    Eye,
    Hand,
    Heart,
    HomeIcon,
    Mail,
    Menu,
    MessageSquare,
    Phone,
    Star,
    Users,
    Volume2,
    X
} from 'lucide-vue-next';
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
        utterance.rate = 0.8;
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

// Features data
const features = [
    {
        icon: Eye,
        title: 'Visual Accessibility',
        description: 'High contrast themes, customizable font sizes, and screen reader optimization for visually impaired learners.',
        ariaLabel: 'Visual accessibility features including high contrast and screen reader support'
    },
    {
        icon: Ear,
        title: 'Audio Support',
        description: 'Text-to-speech, audio descriptions, and sign language interpretation for comprehensive audio accessibility.',
        ariaLabel: 'Audio support features including text-to-speech and sign language interpretation'
    },
    {
        icon: Hand,
        title: 'Motor Accessibility',
        description: 'Keyboard navigation, voice commands, and adaptive input methods for users with motor impairments.',
        ariaLabel: 'Motor accessibility features including keyboard navigation and voice commands'
    },
    {
        icon: BookOpen,
        title: 'Adaptive Learning',
        description: 'Personalized learning paths that adapt to individual needs and learning preferences.',
        ariaLabel: 'Adaptive learning features with personalized educational paths'
    },
    {
        icon: Users,
        title: 'Collaborative Tools',
        description: 'Accessible group projects, peer support, and inclusive communication tools.',
        ariaLabel: 'Collaborative learning tools designed for inclusive group work'
    },
    {
        icon: MessageSquare,
        title: 'Communication',
        description: 'Multiple communication channels including chat, video calls with captions, and discussion forums.',
        ariaLabel: 'Communication features with multiple accessible channels'
    }
];

// Stories data
const stories = [
    {
        name: 'Sarah Chen',
        role: 'Computer Science Student',
        story: 'As a blind student, I never thought I could pursue programming. This platform\'s screen reader compatibility and audio coding tutorials made it possible for me to learn and excel in computer science.',
        rating: 5,
        ariaLabel: 'Success story from Sarah Chen, a blind computer science student'
    },
    {
        name: 'Marcus Rodriguez',
        role: 'Deaf Education Advocate',
        story: 'The sign language interpretation and visual learning tools have transformed how I access educational content. Finally, a platform that truly understands deaf learners\' needs.',
        rating: 5,
        ariaLabel: 'Success story from Marcus Rodriguez, a deaf education advocate'
    },
    {
        name: 'Emma Thompson',
        role: 'Teacher & Parent',
        story: 'My daughter has dyslexia, and this platform\'s adaptive text features and multi-sensory learning approaches have boosted her confidence and academic performance significantly.',
        rating: 5,
        ariaLabel: 'Success story from Emma Thompson, teacher and parent of a child with dyslexia'
    }
];

// Contact form handling
const contactForm = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const submitContact = () => {
    // Handle form submission
    console.log('Contact form submitted:', contactForm.value);
    // Reset form
    contactForm.value = { name: '', email: '', subject: '', message: '' };
};
</script>

<template>

    <Head title="Welcome to Ebssr">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]">
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
                                <NavigationMenuLink :href="page.href" :class="navigationMenuTriggerStyle()"
                                    class="text-lg font-medium">
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
                                <Menu v-if="!isOpen"
                                    class="h-[1.2rem] w-[1.2rem] transition-all duration-300 ease-in-out" />
                                <X v-else class="h-[1.2rem] w-[1.2rem] transition-all duration-300 ease-in-out" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <template v-for="page in pages" :key="page.name">
                                <DropdownMenuItem as-child>
                                    <Link :href="page.href" class="w-full justify-center text-lg font-medium"
                                        @click="isOpen = false">
                                    {{ page.name }}
                                    </Link>
                                </DropdownMenuItem>
                            </template>

                            <DropdownMenuItem v-if="!$page.props.auth.user" as-child>
                                <Link :href="route('login')" class="w-full justify-center text-lg font-medium"
                                    @click="isOpen = false">
                                Log in </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem v-if="!$page.props.auth.user" as-child>
                                <Link :href="route('register')" class="w-full justify-center text-lg font-medium"
                                    @click="isOpen = false">
                                Register
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem v-else as-child>
                                <Link :href="route('dashboard')" class="w-full justify-center text-lg font-medium"
                                    @click="isOpen = false">
                                Dashboard
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="relative flex min-h-screen w-full justify-center bg-background px-4 py-16" role="banner"
            aria-label="Hero section for accessible e-learning platform">
            <!-- Background pattern for visual interest -->
            <div class="absolute inset-0 bg-card/30" aria-hidden="true"></div>

            <div class="relative z-10 mx-auto w-full max-w-6xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <!-- Content Section -->
                    <div class="space-y-8 text-center lg:text-left">
                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-4xl leading-tight font-black text-primary md:text-5xl lg:text-6xl"
                                id="main-heading">
                                Empower Your Learning Journey
                            </h1>

                            <!-- Text-to-speech button for main heading -->
                            <button @click="() => speakText('Empower Your Learning Journey')"
                                class="sr-only rounded-md bg-accent px-3 py-2 text-sm font-medium text-accent-foreground focus:not-sr-only focus:absolute focus:top-4 focus:left-4"
                                aria-label="Listen to main heading" type="button">
                                🔊 Listen to Heading
                            </button>
                        </div>

                        <!-- Subheading -->
                        <div class="space-y-4">
                            <h2 class="text-xl leading-relaxed font-semibold text-foreground md:text-2xl lg:text-3xl"
                                id="sub-heading">
                                Accessible Education for All Abilities
                            </h2>

                            <!-- Text-to-speech button for subheading -->
                            <button @click="() => speakText('Accessible Education for All Abilities')"
                                class="sr-only rounded-md bg-accent px-3 py-2 text-sm font-medium text-accent-foreground focus:not-sr-only focus:absolute focus:top-16 focus:left-4"
                                aria-label="Listen to subheading" type="button">
                                🔊 Listen to Subheading
                            </button>
                        </div>

                        <!-- Description -->
                        <p class="mx-auto max-w-2xl text-lg leading-relaxed text-muted-foreground md:text-xl lg:mx-0">
                            Experience learning designed with accessibility at its core. Our platform provides
                            comprehensive
                            educational resources
                            with full screen reader support, high contrast visuals, and adaptive technologies for deaf
                            and blind
                            learners.
                        </p>

                        <!-- Call to Action -->
                        <div class="flex flex-col justify-center gap-4 sm:flex-row lg:justify-start">
                            <Button variant="default" size="lg" @click="handleGetStarted" @keydown="handleKeyDown"
                                class="min-h-[44px] min-w-[44px] px-8 py-4 text-lg font-semibold focus:ring-4 focus:ring-accent/50"
                                aria-label="Get started with accessible learning platform" role="button" tabindex="0"
                                as-child>
                                <Link href="/auth"> Get Started </Link>
                            </Button>

                            <Button variant="outline" size="lg"
                                class="min-h-[44px] min-w-[44px] px-8 py-4 text-lg font-semibold focus:ring-4 focus:ring-primary/50"
                                aria-label="Learn more about our accessibility features" role="button" tabindex="0"
                                as-child>
                                <a href="#features"> Learn More </a>
                            </Button>
                        </div>

                        <!-- Accessibility Features List -->
                        <div class="mt-12 space-y-4">
                            <h3 class="text-lg font-semibold text-primary">Accessibility Features:</h3>
                            <ul class="grid gap-3 text-foreground sm:grid-cols-2" role="list"
                                aria-label="List of accessibility features">
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>Screen Reader Compatible</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>High Contrast Design</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>Keyboard Navigation</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>Text-to-Speech Support</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>Large Touch Targets</span>
                                </li>
                                <li class="flex items-center gap-3" role="listitem">
                                    <span class="h-2 w-2 flex-shrink-0 rounded-full bg-accent"
                                        aria-hidden="true"></span>
                                    <span>Adaptive Learning Paths</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Visual Section -->
                    <div class="flex justify-center lg:justify-end">
                        <div class="relative aspect-square w-full max-w-lg rounded-2xl border border-border bg-card p-8 shadow-lg"
                            role="img"
                            aria-label="Illustration showing diverse learners using accessible technology for education">
                            <!-- Placeholder for inclusive learning illustration -->
                            <img src="/hero.jpg?height=400&width=400"
                                alt="Diverse students with disabilities engaging with accessible learning technology, including a person using a braille display, another using a screen reader, and sign language interpretation"
                                class="h-full w-full rounded-lg object-cover" loading="eager" />

                            <!-- Decorative elements -->
                            <div class="absolute -top-4 -right-4 h-8 w-8 rounded-full bg-accent" aria-hidden="true">
                            </div>
                            <div class="absolute -bottom-4 -left-4 h-6 w-6 rounded-full bg-primary" aria-hidden="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skip to main content link for screen readers -->
            <a href="#main-content"
                class="sr-only z-50 rounded-md bg-primary px-4 py-2 font-medium text-primary-foreground focus:not-sr-only focus:absolute focus:top-4 focus:right-4">
                Skip to main content
            </a>
        </section>

        <!-- Main Content -->
        <main id="main-content" class="w-full">
            <!-- Features Section -->
            <section id="features" class="w-full bg-muted/30 py-20" aria-labelledby="features-heading">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="text-center mb-16">
                        <h2 id="features-heading" class="text-3xl font-bold text-primary md:text-4xl lg:text-5xl mb-4">
                            Accessibility-First Features
                        </h2>
                        <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                            Our platform is built from the ground up with accessibility in mind, ensuring every learner
                            can
                            succeed regardless of their abilities.
                        </p>
                        <Button
                            @click="() => speakText('Accessibility-First Features. Our platform is built from the ground up with accessibility in mind, ensuring every learner can succeed regardless of their abilities.')"
                            variant="ghost" size="sm" class="mt-4" aria-label="Listen to features section introduction">
                            <Volume2 class="h-4 w-4 mr-2" />
                            Listen to Section
                        </Button>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <Card v-for="(feature, index) in features" :key="index"
                            class="group hover:shadow-lg transition-all duration-300 focus-within:ring-2 focus-within:ring-primary/50"
                            :aria-label="feature.ariaLabel">
                            <CardHeader class="text-center">
                                <div
                                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 group-hover:bg-primary/20 transition-colors">
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
                                    :aria-label="`Listen to ${feature.title} feature description`">
                                    <Volume2 class="h-4 w-4 mr-2" />
                                    Listen
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>

            <!-- Stories Section -->
            <section id="stories" class="w-full py-20" aria-labelledby="stories-heading">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="text-center mb-16">
                        <h2 id="stories-heading" class="text-3xl font-bold text-primary md:text-4xl lg:text-5xl mb-4">
                            Success Stories
                        </h2>
                        <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                            Real stories from learners who have transformed their educational journey through accessible
                            learning.
                        </p>
                        <Button
                            @click="() => speakText('Success Stories. Real stories from learners who have transformed their educational journey through accessible learning.')"
                            variant="ghost" size="sm" class="mt-4"
                            aria-label="Listen to success stories section introduction">
                            <Volume2 class="h-4 w-4 mr-2" />
                            Listen to Section
                        </Button>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <Card v-for="(story, index) in stories" :key="index"
                            class="group hover:shadow-lg transition-all duration-300 focus-within:ring-2 focus-within:ring-primary/50"
                            :aria-label="story.ariaLabel">
                            <CardHeader>
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="h-12 w-12 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white font-bold text-lg">
                                        {{story.name.split(' ').map(n => n[0]).join('')}}
                                    </div>
                                    <div>
                                        <CardTitle class="text-lg">{{ story.name }}</CardTitle>
                                        <p class="text-sm text-muted-foreground">{{ story.role }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-1 mb-4" :aria-label="`${story.rating} out of 5 stars`">
                                    <Star v-for="i in 5" :key="i" class="h-4 w-4"
                                        :class="i <= story.rating ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                                        aria-hidden="true" />
                                </div>
                            </CardHeader>
                            <CardContent>
                                <blockquote class="text-base leading-relaxed italic">
                                    "{{ story.story }}"
                                </blockquote>
                                <Button
                                    @click="() => speakText(`Story from ${story.name}, ${story.role}. ${story.story}`)"
                                    variant="ghost" size="sm" class="mt-4 w-full"
                                    :aria-label="`Listen to ${story.name}'s success story`">
                                    <Volume2 class="h-4 w-4 mr-2" />
                                    Listen to Story
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>

            <!-- Accessibility Section -->
            <section id="accessibility" class="w-full bg-muted/30 py-20" aria-labelledby="accessibility-heading">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="text-center mb-16">
                        <h2 id="accessibility-heading"
                            class="text-3xl font-bold text-primary md:text-4xl lg:text-5xl mb-4">
                            Our Commitment to Accessibility
                        </h2>
                        <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                            We believe education should be accessible to everyone. Our platform meets and exceeds WCAG
                            2.1 AA
                            standards.
                        </p>
                        <Button
                            @click="() => speakText('Our Commitment to Accessibility. We believe education should be accessible to everyone. Our platform meets and exceeds WCAG 2.1 AA standards.')"
                            variant="ghost" size="sm" class="mt-4"
                            aria-label="Listen to accessibility commitment section introduction">
                            <Volume2 class="h-4 w-4 mr-2" />
                            Listen to Section
                        </Button>
                    </div>

                    <div class="grid gap-12 lg:grid-cols-2 items-center">
                        <div class="space-y-8">
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
                                        <Accessibility class="h-6 w-6 text-primary" aria-hidden="true" />
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2">WCAG 2.1 AA Compliant</h3>
                                        <p class="text-muted-foreground">
                                            Our platform meets the highest web accessibility standards, ensuring
                                            compatibility
                                            with all assistive technologies.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
                                        <Heart class="h-6 w-6 text-primary" aria-hidden="true" />
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2">Inclusive Design</h3>
                                        <p class="text-muted-foreground">
                                            Every feature is designed with diverse abilities in mind, from color choices
                                            to
                                            interaction patterns.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
                                        <Users class="h-6 w-6 text-primary" aria-hidden="true" />
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2">Community Tested</h3>
                                        <p class="text-muted-foreground">
                                            Our platform is regularly tested by users with disabilities to ensure
                                            real-world
                                            accessibility.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-card p-6 rounded-lg border">
                                <h4 class="text-lg font-semibold mb-4">Accessibility Standards We Meet:</h4>
                                <ul class="space-y-2 text-sm" role="list">
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>WCAG 2.1 Level AA</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>Section 508 Compliance</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>ADA Compliance</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-green-500" aria-hidden="true"></span>
                                        <span>EN 301 549 European Standard</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <div class="relative">
                                <img src="/accessibility.jpg?height=500&width=500"
                                    alt="Diverse group of people with various disabilities using assistive technologies to access educational content on computers and mobile devices"
                                    class="rounded-2xl shadow-lg max-w-full h-auto" loading="lazy" />
                                <div class="absolute -bottom-4 -right-4 h-8 w-8 rounded-full bg-primary"
                                    aria-hidden="true">
                                </div>
                                <div class="absolute -top-4 -left-4 h-6 w-6 rounded-full bg-accent" aria-hidden="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="contact" class="w-full py-20" aria-labelledby="contact-heading">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="text-center mb-16">
                        <h2 id="contact-heading" class="text-3xl font-bold text-primary md:text-4xl lg:text-5xl mb-4">
                            Get in Touch
                        </h2>
                        <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                            Have questions about accessibility features or need support? We're here to help make
                            learning
                            accessible for everyone.
                        </p>
                        <Button
                            @click="() => speakText('Get in Touch. Have questions about accessibility features or need support? We are here to help make learning accessible for everyone.')"
                            variant="ghost" size="sm" class="mt-4" aria-label="Listen to contact section introduction">
                            <Volume2 class="h-4 w-4 mr-2" />
                            Listen to Section
                        </Button>
                    </div>

                    <div class="grid gap-12 lg:grid-cols-2">
                        <!-- Contact Information -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-2xl font-semibold mb-6">Contact Information</h3>
                                <div class="space-y-6">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex-shrink-0 h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
                                            <Mail class="h-6 w-6 text-primary" aria-hidden="true" />
                                        </div>
                                        <div>
                                            <h4 class="font-semibold mb-1">Email Support</h4>
                                            <p class="text-muted-foreground">accessibility@learningplatform.com</p>
                                            <p class="text-sm text-muted-foreground mt-1">24/7 accessibility support
                                                available
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex-shrink-0 h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
                                            <Phone class="h-6 w-6 text-primary" aria-hidden="true" />
                                        </div>
                                        <div>
                                            <h4 class="font-semibold mb-1">Phone Support</h4>
                                            <p class="text-muted-foreground">+1 (555) 123-4567</p>
                                            <p class="text-sm text-muted-foreground mt-1">TTY: +1 (555) 123-4568</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex-shrink-0 h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center">
                                            <MessageSquare class="h-6 w-6 text-primary" aria-hidden="true" />
                                        </div>
                                        <div>
                                            <h4 class="font-semibold mb-1">Live Chat</h4>
                                            <p class="text-muted-foreground">Available with screen reader support</p>
                                            <p class="text-sm text-muted-foreground mt-1">Monday - Friday, 9 AM - 6 PM
                                                EST</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-card p-6 rounded-lg border">
                                <h4 class="text-lg font-semibold mb-4">Accessibility Support</h4>
                                <p class="text-muted-foreground mb-4">
                                    Our dedicated accessibility team is available to help with:
                                </p>
                                <ul class="space-y-2 text-sm" role="list">
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>Assistive technology setup</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>Platform navigation assistance</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>Accessibility feature training</span>
                                    </li>
                                    <li class="flex items-center gap-2" role="listitem">
                                        <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                                        <span>Custom accommodation requests</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <Card class="p-6">
                            <CardHeader class="px-0 pt-0">
                                <CardTitle class="text-xl">Send us a Message</CardTitle>
                                <CardDescription>
                                    Fill out the form below and we'll get back to you within 24 hours.
                                </CardDescription>
                            </CardHeader>
                            <CardContent class="px-0 pb-0">
                                <form @submit.prevent="submitContact" class="space-y-6" aria-label="Contact form">
                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div class="space-y-2">
                                            <Label for="contact-name" class="text-sm font-medium">
                                                Name <span class="text-red-500" aria-label="required">*</span>
                                            </Label>
                                            <Input id="contact-name" v-model="contactForm.name" type="text"
                                                placeholder="Your full name" required class="min-h-[44px]"
                                                aria-describedby="name-help" />
                                            <p id="name-help" class="sr-only">Enter your full name for contact purposes
                                            </p>
                                        </div>
                                        <div class="space-y-2">
                                            <Label for="contact-email" class="text-sm font-medium">
                                                Email <span class="text-red-500" aria-label="required">*</span>
                                            </Label>
                                            <Input id="contact-email" v-model="contactForm.email" type="email"
                                                placeholder="your.email@example.com" required class="min-h-[44px]"
                                                aria-describedby="email-help" />
                                            <p id="email-help" class="sr-only">Enter your email address for our response
                                            </p>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="contact-subject" class="text-sm font-medium">
                                            Subject <span class="text-red-500" aria-label="required">*</span>
                                        </Label>
                                        <Input id="contact-subject" v-model="contactForm.subject" type="text"
                                            placeholder="What can we help you with?" required class="min-h-[44px]"
                                            aria-describedby="subject-help" />
                                        <p id="subject-help" class="sr-only">Brief description of your inquiry</p>
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="contact-message" class="text-sm font-medium">
                                            Message <span class="text-red-500" aria-label="required">*</span>
                                        </Label>
                                        <Textarea id="contact-message" v-model="contactForm.message"
                                            placeholder="Please describe your question or how we can help you..."
                                            required rows="5" class="min-h-[120px] resize-none"
                                            aria-describedby="message-help" />
                                        <p id="message-help" class="sr-only">Detailed description of your inquiry or
                                            support
                                            request</p>
                                    </div>
                                    <Button type="submit" class="w-full min-h-[44px] text-lg font-semibold"
                                        aria-label="Send contact form message">
                                        Send Message
                                    </Button>
                                </form>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="w-full bg-muted/50 py-12 mt-20" role="contentinfo" aria-label="Site footer">
            <div class="mx-auto max-w-6xl px-4">
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Company Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <HomeIcon class="h-6 w-6 text-primary" aria-hidden="true" />
                            <span class="text-lg font-semibold">AccessLearn</span>
                        </div>
                        <p class="text-sm text-muted-foreground">
                            Making education accessible for everyone, everywhere. Built with accessibility at its core.
                        </p>
                        <Button
                            @click="() => speakText('AccessLearn. Making education accessible for everyone, everywhere. Built with accessibility at its core.')"
                            variant="ghost" size="sm" aria-label="Listen to company description">
                            <Volume2 class="h-4 w-4 mr-2" />
                            Listen
                        </Button>
                    </div>

                    <!-- Quick Links -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Quick Links</h3>
                        <nav aria-label="Footer navigation">
                            <ul class="space-y-2 text-sm" role="list">
                                <li role="listitem">
                                    <a href="#features"
                                        class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                        Features
                                    </a>
                                </li>
                                <li role="listitem">
                                    <a href="#stories"
                                        class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                        Success Stories
                                    </a>
                                </li>
                                <li role="listitem">
                                    <a href="#accessibility"
                                        class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                        Accessibility
                                    </a>
                                </li>
                                <li role="listitem">
                                    <a href="#contact"
                                        class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Support -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Support</h3>
                        <ul class="space-y-2 text-sm" role="list">
                            <li role="listitem">
                                <a href="/help"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Help Center
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/accessibility-guide"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Accessibility Guide
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/tutorials"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Video Tutorials
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/community"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Community Forum
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Legal</h3>
                        <ul class="space-y-2 text-sm" role="list">
                            <li role="listitem">
                                <a href="/privacy"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Privacy Policy
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/terms"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Terms of Service
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/accessibility-statement"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Accessibility Statement
                                </a>
                            </li>
                            <li role="listitem">
                                <a href="/cookies"
                                    class="text-muted-foreground hover:text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-primary/50 rounded">
                                    Cookie Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-border">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <p class="text-sm text-muted-foreground">
                            © 2025 AccessLearn. All rights reserved. Committed to digital accessibility.
                        </p>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-muted-foreground">WCAG 2.1 AA Compliant</span>
                            <div class="h-4 w-4 rounded-full bg-green-500" aria-label="Accessibility certified"
                                title="WCAG 2.1 AA Compliant"></div>
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
</style>
