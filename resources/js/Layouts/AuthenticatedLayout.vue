<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    LayoutDashboard,
    FolderHeart,
    Coins,
    LogOut,
    Menu,
    X,
    HeartHandshake,
    Building2,
    Handshake,
    CreditCard,
    UsersRound,
    SlidersHorizontal,
    Newspaper,
    TrendingUp,
    FolderClosed,
    FileText,
    Settings,
    Share2,
    UserCheck,
} from "lucide-vue-next";

defineProps({
    auth: Object,
});

const isMobileSidebarOpen = ref(false);

const logout = () => {
    router.post("/admin/logout");
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 flex" dir="rtl">
        <!-- ================= DESKTOP SIDEBAR ================= -->
        <aside
            class="hidden md:flex flex-col w-64 bg-slate-900 text-white fixed h-full z-20"
        >
            <div
                class="h-16 flex items-center justify-center border-b border-slate-800 px-6 gap-2"
            >
                <HeartHandshake class="text-orange-500 w-8 h-8 flex-shrink-0" />
                <span class="font-bold text-lg truncate">متراحمين الخيرية</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <!-- Dashboard Home -->
                <Link
                    href="/admin"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component === 'Index',
                    }"
                >
                    <LayoutDashboard class="w-4.5 h-4.5" />
                    <span>الرئيسية</span>
                </Link>

                <!-- Org Profile Editor (Admin Only) -->
                <Link
                    v-if="$page.props.auth?.user?.role === 'super_admin'"
                    href="/admin/profile"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Profile/'),
                    }"
                >
                    <Building2 class="w-4.5 h-4.5" />
                    <span>ملف المنظمة</span>
                </Link>

                <!-- Site Settings (Admin Only) -->
                <Link
                    v-if="$page.props.auth?.user?.role === 'super_admin'"
                    href="/admin/settings"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Settings/'),
                    }"
                >
                    <Settings class="w-4.5 h-4.5" />
                    <span>إعدادات المنصة</span>
                </Link>

                <!-- Slides Manager -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/hero-slides"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('HeroSlides/'),
                    }"
                >
                    <SlidersHorizontal class="w-4.5 h-4.5" />
                    <span>لافتات الواجهة (Hero)</span>
                </Link>

                <!-- Social Links -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/social-links"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('SocialLinks/'),
                    }"
                >
                    <Share2 class="w-4.5 h-4.5" />
                    <span>حسابات التواصل</span>
                </Link>

                <!-- Partners -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/partners"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Partners/'),
                    }"
                >
                    <Handshake class="w-4.5 h-4.5" />
                    <span>شركاء النجاح</span>
                </Link>

                <!-- News -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/news"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('News/'),
                    }"
                >
                    <Newspaper class="w-4.5 h-4.5" />
                    <span>الأخبار والفعاليات</span>
                </Link>

                <!-- Impact Stats -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/impact-stats"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('ImpactStats/'),
                    }"
                >
                    <TrendingUp class="w-4.5 h-4.5" />
                    <span>إحصائيات الأثر</span>
                </Link>

                <!-- Volunteers Applications -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/volunteers"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Volunteers/'),
                    }"
                >
                    <UserCheck class="w-4.5 h-4.5" />
                    <span>طلبات التطوع</span>
                </Link>

                <!-- Projects -->
                <Link
                    href="/admin/projects"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Projects/'),
                    }"
                >
                    <FolderHeart class="w-4.5 h-4.5" />
                    <span>إدارة المشاريع</span>
                </Link>

                <!-- Categories -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/categories"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Categories/'),
                    }"
                >
                    <FolderClosed class="w-4.5 h-4.5" />
                    <span>تصنيفات المشاريع</span>
                </Link>

                <!-- Updates -->
                <Link
                    v-if="
                        ['super_admin', 'content_editor'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/updates"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Updates/'),
                    }"
                >
                    <FileText class="w-4.5 h-4.5" />
                    <span>تحديثات المشاريع</span>
                </Link>

                <!-- Payment Methods -->
                <Link
                    v-if="
                        ['super_admin', 'finance'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/payment-methods"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('PaymentMethods/'),
                    }"
                >
                    <CreditCard class="w-4.5 h-4.5" />
                    <span>الحسابات المصرفية</span>
                </Link>

                <!-- Donations -->
                <Link
                    v-if="
                        ['super_admin', 'finance'].includes(
                            $page.props.auth?.user?.role
                        )
                    "
                    href="/admin/donations"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Donations/'),
                    }"
                >
                    <Coins class="w-4.5 h-4.5" />
                    <span>التبرعات الواردة</span>
                </Link>

                <!-- Users -->
                <Link
                    v-if="$page.props.auth?.user?.role === 'super_admin'"
                    href="/admin/users"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                    :class="{
                        'bg-slate-800 text-orange-500 font-bold':
                            $page.component.startsWith('Users/'),
                    }"
                >
                    <UsersRound class="w-4.5 h-4.5" />
                    <span>إدارة المشرفين</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <button
                    @click="logout"
                    class="flex w-full items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-900/40 text-red-400 transition cursor-pointer"
                >
                    <LogOut class="w-5 h-5" />
                    <span>تسجيل الخروج</span>
                </button>
            </div>
        </aside>

        <!-- ================= MOBILE NAVIGATION BAR ================= -->
        <div
            class="md:hidden fixed top-0 left-0 right-0 h-16 bg-white border-b border-slate-200 px-4 flex items-center justify-between z-30 shadow-sm"
        >
            <button
                @click="isMobileSidebarOpen = true"
                class="p-2 text-slate-700 hover:bg-slate-100 rounded-lg transition"
                aria-label="فتح القائمة"
            >
                <Menu class="w-6 h-6" />
            </button>
            <div class="flex items-center gap-2">
                <HeartHandshake class="text-orange-500 w-6 h-6" />
                <span class="font-bold text-slate-800">متراحمين الخيرية</span>
            </div>
            <div class="w-8"></div>
        </div>

        <!-- ================= MOBILE SIDEBAR DRAWER (Full Menu) ================= -->
        <div
            v-if="isMobileSidebarOpen"
            class="fixed inset-0 z-50 md:hidden flex"
        >
            <!-- Backdrop -->
            <div
                class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity"
                @click="isMobileSidebarOpen = false"
            ></div>

            <!-- Drawer Panel -->
            <aside
                class="relative flex flex-col w-72 max-w-[85vw] bg-slate-950 text-white h-full z-10 shadow-2xl"
            >
                <!-- Drawer Header -->
                <div
                    class="flex items-center justify-between px-5 py-4 border-b border-slate-800"
                >
                    <div class="flex items-center gap-2.5">
                        <HeartHandshake class="text-orange-500 w-7 h-7" />
                        <span class="font-bold text-base text-white"
                            >لوحة الإدارة</span
                        >
                    </div>
                    <button
                        @click="isMobileSidebarOpen = false"
                        class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition"
                    >
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <!-- Drawer Navigation Links -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <!-- Dashboard Home -->
                    <Link
                        href="/admin"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component === 'Index',
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <LayoutDashboard class="w-5 h-5" />
                        <span>الرئيسية</span>
                    </Link>

                    <!-- Org Profile Editor -->
                    <Link
                        v-if="$page.props.auth?.user?.role === 'super_admin'"
                        href="/admin/profile"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Profile/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <Building2 class="w-5 h-5" />
                        <span>ملف المنظمة</span>
                    </Link>

                    <!-- Site Settings -->
                    <Link
                        v-if="$page.props.auth?.user?.role === 'super_admin'"
                        href="/admin/settings"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Settings/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <Settings class="w-5 h-5" />
                        <span>إعدادات المنصة</span>
                    </Link>

                    <!-- Slides Manager -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/hero-slides"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('HeroSlides/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <SlidersHorizontal class="w-5 h-5" />
                        <span>لافتات الواجهة (Hero)</span>
                    </Link>

                    <!-- Social Links -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/social-links"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('SocialLinks/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <Share2 class="w-5 h-5" />
                        <span>حسابات التواصل</span>
                    </Link>

                    <!-- Partners -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/partners"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Partners/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <Handshake class="w-5 h-5" />
                        <span>شركاء النجاح</span>
                    </Link>

                    <!-- News -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/news"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('News/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <Newspaper class="w-5 h-5" />
                        <span>الأخبار والفعاليات</span>
                    </Link>

                    <!-- Impact Stats -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/impact-stats"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('ImpactStats/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <TrendingUp class="w-5 h-5" />
                        <span>إحصائيات الأثر</span>
                    </Link>

                    <!-- Volunteers -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/volunteers"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Volunteers/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <UserCheck class="w-5 h-5" />
                        <span>طلبات التطوع</span>
                    </Link>

                    <!-- Projects -->
                    <Link
                        href="/admin/projects"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Projects/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <FolderHeart class="w-5 h-5" />
                        <span>إدارة المشاريع</span>
                    </Link>

                    <!-- Categories -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/categories"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Categories/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <FolderClosed class="w-5 h-5" />
                        <span>تصنيفات المشاريع</span>
                    </Link>

                    <!-- Updates -->
                    <Link
                        v-if="
                            ['super_admin', 'content_editor'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/updates"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Updates/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <FileText class="w-5 h-5" />
                        <span>تحديثات المشاريع</span>
                    </Link>

                    <!-- Payment Methods -->
                    <Link
                        v-if="
                            ['super_admin', 'finance'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/payment-methods"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('PaymentMethods/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <CreditCard class="w-5 h-5" />
                        <span>الحسابات المصرفية</span>
                    </Link>

                    <!-- Donations -->
                    <Link
                        v-if="
                            ['super_admin', 'finance'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/donations"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Donations/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <Coins class="w-5 h-5" />
                        <span>التبرعات الواردة</span>
                    </Link>

                    <!-- Users -->
                    <Link
                        v-if="$page.props.auth?.user?.role === 'super_admin'"
                        href="/admin/users"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-slate-800 transition text-sm"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Users/'),
                        }"
                        @click="isMobileSidebarOpen = false"
                    >
                        <UsersRound class="w-5 h-5" />
                        <span>إدارة المشرفين</span>
                    </Link>
                </nav>

                <!-- Drawer Logout Button -->
                <div class="p-3 border-t border-slate-800 bg-slate-950">
                    <button
                        @click="logout"
                        class="flex w-full items-center gap-3 px-3.5 py-2.5 rounded-lg hover:bg-red-950/50 text-red-400 transition cursor-pointer text-sm"
                    >
                        <LogOut class="w-5 h-5" />
                        <span>تسجيل الخروج</span>
                    </button>
                </div>
            </aside>
        </div>

        <!-- ================= PAGE BODY WRAPPER ================= -->
        <main class="flex-1 md:mr-64 pt-16 md:pt-0 min-h-screen">
            <!-- Navbar Header (Desktop) -->
            <header
                class="hidden md:flex h-16 bg-white border-b border-slate-200 px-8 items-center justify-between"
            >
                <h1 class="text-slate-800 font-bold text-lg">
                    مرحباً، {{ $page.props.auth?.user?.name }}
                </h1>
                <div
                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full"
                >
                    {{ $page.props.auth?.user?.role }}
                </div>
            </header>

            <!-- Content View Slot -->
            <div class="p-4 sm:p-6 md:p-8">
                <slot />
            </div>
        </main>
    </div>
</template>
