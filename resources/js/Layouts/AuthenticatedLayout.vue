<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
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

const closeMobileSidebar = () => {
    isMobileSidebarOpen.value = false;
};

watch(isMobileSidebarOpen, (isOpen) => {
    if (typeof document === "undefined") return;

    document.body.style.overflow = isOpen ? "hidden" : "";
});
</script>

<template>
    <div class="min-h-screen bg-slate-50" dir="rtl">
        <!-- ================= MOBILE HEADER ================= -->
        <header
            class="fixed inset-x-0 top-0 z-40 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-3 shadow-sm backdrop-blur md:hidden"
        >
            <button
                @click="isMobileSidebarOpen = true"
                type="button"
                aria-label="فتح القائمة"
                class="flex h-11 w-11 items-center justify-center rounded-xl text-slate-700 transition hover:bg-slate-100 active:scale-95"
            >
                <Menu class="h-6 w-6" />
            </button>

            <div class="flex min-w-0 items-center gap-2">
                <HeartHandshake class="h-6 w-6 shrink-0 text-orange-500" />
                <span
                    class="truncate text-sm font-bold text-slate-800 sm:text-base"
                >
                    متراحمين الخيرية
                </span>
            </div>

            <div class="h-11 w-11" aria-hidden="true"></div>
        </header>

        <!-- ================= DESKTOP SIDEBAR ================= -->
        <aside
            class="fixed inset-y-0 right-0 z-30 hidden w-64 flex-col bg-slate-900 text-white md:flex"
        >
            <div
                class="flex h-16 shrink-0 items-center justify-center gap-2 border-b border-slate-800 px-5"
            >
                <HeartHandshake class="h-8 w-8 shrink-0 text-orange-500" />
                <span class="truncate text-lg font-bold">
                    متراحمين الخيرية
                </span>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-5">
                <div class="space-y-1.5">
                    <!-- Dashboard Home -->
                    <Link
                        v-if="
                            ['super_admin', 'finance'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component === 'Index',
                        }"
                    >
                        <LayoutDashboard class="h-5 w-5 shrink-0" />
                        <span>الرئيسية</span>
                    </Link>

                    <!-- Org Profile Editor -->
                    <Link
                        v-if="$page.props.auth?.user?.role === 'super_admin'"
                        href="/admin/profile"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Profile/'),
                        }"
                    >
                        <Building2 class="h-5 w-5 shrink-0" />
                        <span>ملف المنظمة</span>
                    </Link>

                    <!-- Site Settings -->
                    <Link
                        v-if="$page.props.auth?.user?.role === 'super_admin'"
                        href="/admin/settings"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Settings/'),
                        }"
                    >
                        <Settings class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('HeroSlides/'),
                        }"
                    >
                        <SlidersHorizontal class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('SocialLinks/'),
                        }"
                    >
                        <Share2 class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Partners/'),
                        }"
                    >
                        <Handshake class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('News/'),
                        }"
                    >
                        <Newspaper class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('ImpactStats/'),
                        }"
                    >
                        <TrendingUp class="h-5 w-5 shrink-0" />
                        <span>إحصائيات الأثر</span>
                    </Link>

                    <!-- Volunteers Applications -->
                    <Link
                        v-if="
                            ['super_admin', 'membership_manager'].includes(
                                $page.props.auth?.user?.role
                            )
                        "
                        href="/admin/volunteers"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Volunteers/'),
                        }"
                    >
                        <UserCheck class="h-5 w-5 shrink-0" />
                        <span>طلبات التطوع</span>
                    </Link>

                    <!-- Projects -->
                    <Link
                        v-if="
                            [
                                'super_admin',
                                'content_editor',
                                'finance',
                            ].includes($page.props.auth?.user?.role)
                        "
                        href="/admin/projects"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Projects/'),
                        }"
                    >
                        <FolderHeart class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Categories/'),
                        }"
                    >
                        <FolderClosed class="h-5 w-5 shrink-0" />
                        <span>تصنيفات المشاريع</span>
                    </Link>

                    <!-- Updates -->
                    <Link
                        v-if="
                            [
                                'super_admin',
                                'content_editor',
                                'finance',
                            ].includes($page.props.auth?.user?.role)
                        "
                        href="/admin/updates"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Updates/'),
                        }"
                    >
                        <FileText class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('PaymentMethods/'),
                        }"
                    >
                        <CreditCard class="h-5 w-5 shrink-0" />
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
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Donations/'),
                        }"
                    >
                        <Coins class="h-5 w-5 shrink-0" />
                        <span>التبرعات الواردة</span>
                    </Link>

                    <!-- Users -->
                    <Link
                        v-if="$page.props.auth?.user?.role === 'super_admin'"
                        href="/admin/users"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                        :class="{
                            'bg-slate-800 text-orange-500 font-bold':
                                $page.component.startsWith('Users/'),
                        }"
                    >
                        <UsersRound class="h-5 w-5 shrink-0" />
                        <span>إدارة المشرفين</span>
                    </Link>
                </div>
            </nav>

            <div class="shrink-0 border-t border-slate-800 p-3">
                <button
                    @click="logout"
                    type="button"
                    class="flex min-h-11 w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-red-400 transition hover:bg-red-900/40"
                >
                    <LogOut class="h-5 w-5 shrink-0" />
                    <span>تسجيل الخروج</span>
                </button>
            </div>
        </aside>

        <!-- ================= MOBILE SIDEBAR DRAWER ================= -->
        <Teleport to="body">
            <div
                v-if="isMobileSidebarOpen"
                class="fixed inset-0 z-50 md:hidden"
            >
                <!-- Backdrop -->
                <button
                    type="button"
                    aria-label="إغلاق القائمة"
                    class="absolute inset-0 h-full w-full cursor-default bg-slate-950/65 backdrop-blur-sm"
                    @click="closeMobileSidebar"
                ></button>

                <!-- Drawer -->
                <aside
                    class="relative z-10 flex h-full w-[min(20rem,88vw)] flex-col bg-slate-950 text-white shadow-2xl"
                >
                    <div
                        class="flex h-16 shrink-0 items-center justify-between gap-3 border-b border-slate-800 px-4"
                    >
                        <div class="flex min-w-0 items-center gap-2.5">
                            <HeartHandshake
                                class="h-7 w-7 shrink-0 text-orange-500"
                            />
                            <span class="truncate text-base font-bold">
                                لوحة الإدارة
                            </span>
                        </div>

                        <button
                            @click="closeMobileSidebar"
                            type="button"
                            aria-label="إغلاق القائمة"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-800 hover:text-white"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <nav class="flex-1 overflow-y-auto px-3 py-4">
                        <div class="space-y-1">
                            <!-- Dashboard Home -->
                            <Link
                                v-if="
                                    ['super_admin', 'finance'].includes(
                                        $page.props.auth?.user?.role
                                    )
                                "
                                href="/admin"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component === 'Index',
                                }"
                            >
                                <LayoutDashboard class="h-5 w-5 shrink-0" />
                                <span>الرئيسية</span>
                            </Link>

                            <!-- Org Profile -->
                            <Link
                                v-if="
                                    $page.props.auth?.user?.role ===
                                    'super_admin'
                                "
                                href="/admin/profile"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('Profile/'),
                                }"
                            >
                                <Building2 class="h-5 w-5 shrink-0" />
                                <span>ملف المنظمة</span>
                            </Link>

                            <!-- Settings -->
                            <Link
                                v-if="
                                    $page.props.auth?.user?.role ===
                                    'super_admin'
                                "
                                href="/admin/settings"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('Settings/'),
                                }"
                            >
                                <Settings class="h-5 w-5 shrink-0" />
                                <span>إعدادات المنصة</span>
                            </Link>

                            <!-- Hero Slides -->
                            <Link
                                v-if="
                                    ['super_admin', 'content_editor'].includes(
                                        $page.props.auth?.user?.role
                                    )
                                "
                                href="/admin/hero-slides"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'HeroSlides/'
                                        ),
                                }"
                            >
                                <SlidersHorizontal class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'SocialLinks/'
                                        ),
                                }"
                            >
                                <Share2 class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('Partners/'),
                                }"
                            >
                                <Handshake class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('News/'),
                                }"
                            >
                                <Newspaper class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'ImpactStats/'
                                        ),
                                }"
                            >
                                <TrendingUp class="h-5 w-5 shrink-0" />
                                <span>إحصائيات الأثر</span>
                            </Link>

                            <!-- Volunteers -->
                            <Link
                                v-if="
                                    [
                                        'super_admin',
                                        'membership_manager',
                                    ].includes($page.props.auth?.user?.role)
                                "
                                href="/admin/volunteers"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'Volunteers/'
                                        ),
                                }"
                            >
                                <UserCheck class="h-5 w-5 shrink-0" />
                                <span>طلبات التطوع</span>
                            </Link>

                            <!-- Projects -->
                            <Link
                                v-if="
                                    [
                                        'super_admin',
                                        'content_editor',
                                        'finance',
                                    ].includes($page.props.auth?.user?.role)
                                "
                                href="/admin/projects"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('Projects/'),
                                }"
                            >
                                <FolderHeart class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'Categories/'
                                        ),
                                }"
                            >
                                <FolderClosed class="h-5 w-5 shrink-0" />
                                <span>تصنيفات المشاريع</span>
                            </Link>

                            <!-- Updates -->
                            <Link
                                v-if="
                                    [
                                        'super_admin',
                                        'content_editor',
                                        'finance',
                                    ].includes($page.props.auth?.user?.role)
                                "
                                href="/admin/updates"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('Updates/'),
                                }"
                            >
                                <FileText class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'PaymentMethods/'
                                        ),
                                }"
                            >
                                <CreditCard class="h-5 w-5 shrink-0" />
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
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith(
                                            'Donations/'
                                        ),
                                }"
                            >
                                <Coins class="h-5 w-5 shrink-0" />
                                <span>التبرعات الواردة</span>
                            </Link>

                            <!-- Users -->
                            <Link
                                v-if="
                                    $page.props.auth?.user?.role ===
                                    'super_admin'
                                "
                                href="/admin/users"
                                @click="closeMobileSidebar"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition hover:bg-slate-800"
                                :class="{
                                    'bg-slate-800 text-orange-500 font-bold':
                                        $page.component.startsWith('Users/'),
                                }"
                            >
                                <UsersRound class="h-5 w-5 shrink-0" />
                                <span>إدارة المشرفين</span>
                            </Link>
                        </div>
                    </nav>

                    <div
                        class="shrink-0 border-t border-slate-800 bg-slate-950 p-3"
                    >
                        <button
                            @click="logout"
                            type="button"
                            class="flex min-h-11 w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm text-red-400 transition hover:bg-red-950/50"
                        >
                            <LogOut class="h-5 w-5 shrink-0" />
                            <span>تسجيل الخروج</span>
                        </button>
                    </div>
                </aside>
            </div>
        </Teleport>

        <!-- ================= PAGE BODY ================= -->
        <main class="min-h-screen pt-16 md:mr-64 md:pt-0">
            <!-- Desktop Header -->
            <header
                class="hidden h-16 items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8 md:flex"
            >
                <h1 class="font-bold text-slate-800">
                    مرحباً، {{ $page.props.auth?.user?.name }}
                </h1>

                <div
                    class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-600"
                >
                    {{ $page.props.auth?.user?.role }}
                </div>
            </header>

            <!-- Content -->
            <div class="w-full p-4 sm:p-5 lg:p-8">
                <slot />
            </div>
        </main>
    </div>
</template>
