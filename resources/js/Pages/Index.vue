<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    BadgeCent,
    Clock,
    FolderHeart,
    UsersRound,
    TrendingUp,
    MailCheck,
    MailOpen,
    Users,
} from "lucide-vue-next";

defineProps({
    stats: Object,
    recentDonations: Array,
    monthlyPerformance: Array,
});

// Basic formatter helper
const formatCurrency = (amount) => {
    return new Intl.NumberFormat("ar-SD", {
        style: "currency",
        currency: "SDG",
        maximumFractionDigits: 0,
    }).format(amount);
};
</script>

<template>
    <AuthenticatedLayout>
        <!-- Welcome Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-800">
                نظرة عامة على الإنجاز والعمليات
            </h2>
            <p class="text-slate-500 text-sm mt-1">
                تحديث حي ومباشر للمؤشرات التشغيلية والمالية لمنظمة متراحمين .
            </p>
        </div>

        <!-- Row 1: Core Financial & Project Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-emerald-100 rounded-lg text-emerald-600">
                    <BadgeCent class="w-8 h-8" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >إجمالي التبرعات المؤكدة</span
                    >
                    <span class="text-xl font-black text-slate-800">{{
                        formatCurrency(stats.total_raised)
                    }}</span>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-amber-100 rounded-lg text-amber-600">
                    <Clock class="w-8 h-8" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >تبرعات قيد المراجعة والتدقيق</span
                    >
                    <span class="text-xl font-black text-slate-800"
                        >{{ stats.pending_donations_count }} معاملة</span
                    >
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                    <FolderHeart class="w-8 h-8" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >المشاريع النشطة حالياً</span
                    >
                    <span class="text-xl font-black text-slate-800"
                        >{{ stats.active_projects }} مشروع</span
                    >
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-purple-100 rounded-lg text-purple-600">
                    <UsersRound class="w-8 h-8" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >طلبات الانضمام للتطوع</span
                    >
                    <span class="text-xl font-black text-slate-800"
                        >{{ stats.volunteer_applications }} طلب</span
                    >
                </div>
            </div>
        </div>

        <!-- Row 2: Newsletter & Communications Metrics -->
        <div
            class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 border-t border-slate-200/60 pt-6"
        >
            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                    <Users class="w-7 h-7" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >المشتركون بالنشرة البريدية</span
                    >
                    <span class="text-lg font-bold text-slate-800"
                        >{{ stats.total_subscribers }} مشترك فاعل</span
                    >
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-sky-100 rounded-lg text-sky-600">
                    <MailCheck class="w-7 h-7" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >رسائل النشرة المرسلة اليوم</span
                    >
                    <span class="text-lg font-bold text-slate-800"
                        >{{ stats.emails_sent_today }} رسالة</span
                    >
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4"
            >
                <div class="p-3 bg-slate-100 rounded-lg text-slate-600">
                    <MailOpen class="w-7 h-7" />
                </div>
                <div>
                    <span class="text-slate-500 text-xs block font-semibold"
                        >إجمالي الرسائل المرسلة كلياً</span
                    >
                    <span class="text-lg font-bold text-slate-800"
                        >{{ stats.total_emails_sent }} رسالة مؤرشفة</span
                    >
                </div>
            </div>
        </div>

        <!-- Main Visual Matrix Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Mini Performance Spark chart -->
            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm lg:col-span-2"
            >
                <div class="flex items-center justify-between mb-6">
                    <h3
                        class="font-bold text-slate-800 flex items-center gap-2"
                    >
                        <TrendingUp class="text-orange-500" />
                        منحنى التبرعات المؤكدة (الشهور الأخيرة)
                    </h3>
                </div>

                <div
                    class="h-64 flex items-end justify-between px-4 pt-4 border-b border-slate-100 relative"
                >
                    <div
                        v-for="month in monthlyPerformance"
                        :key="month.month"
                        class="flex flex-col items-center flex-1"
                    >
                        <div
                            class="w-8 bg-orange-500/80 hover:bg-orange-500 transition rounded-t-sm"
                            :style="{
                                height: `${
                                    (month.total /
                                        Math.max(
                                            ...monthlyPerformance.map(
                                                (m) => m.total
                                            )
                                        )) *
                                    180
                                }px`,
                            }"
                        ></div>
                        <span
                            class="text-slate-400 text-[10px] mt-2 font-mono"
                            >{{ month.month }}</span
                        >
                    </div>
                    <div
                        v-if="monthlyPerformance.length === 0"
                        class="absolute inset-0 flex items-center justify-center text-slate-400"
                    >
                        لا توجد بيانات كافية حالياً
                    </div>
                </div>
            </div>

            <!-- Recent Donations List -->
            <div
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm"
            >
                <h3
                    class="font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4"
                >
                    آخر التبرعات المستلمة
                </h3>
                <div class="space-y-4">
                    <div
                        v-for="donation in recentDonations"
                        :key="donation.id"
                        class="flex items-center justify-between p-3 bg-slate-50 rounded-lg"
                    >
                        <div>
                            <span
                                class="text-xs font-bold text-slate-700 block"
                                >{{ donation.donor_name || "فاعل خير" }}</span
                            >
                            <span class="text-[10px] text-slate-500 block">{{
                                donation.project?.title_ar || "سهم عام"
                            }}</span>
                        </div>
                        <div class="text-left">
                            <span
                                class="text-sm font-bold text-slate-800 block"
                                >{{ formatCurrency(donation.amount) }}</span
                            >
                            <span
                                class="text-[9px] px-2 py-0.5 rounded-full inline-block mt-1"
                                :class="{
                                    'bg-amber-100 text-amber-700':
                                        donation.status === 'pending',
                                    'bg-emerald-100 text-emerald-700':
                                        donation.status === 'confirmed',
                                    'bg-red-100 text-red-700':
                                        donation.status === 'failed',
                                }"
                                >{{ donation.status }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
