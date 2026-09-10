<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import {
    Eye,
    Trash2,
    Plus,
    FileSpreadsheet,
    X,
    MapPin,
    Phone,
    Mail,
    MessageCircle,
} from "lucide-vue-next";

const props = defineProps({
    applications: Array,
    residenceStates: Array,
    filters: Object,
});

const activeAppDetail = ref(null);

const statusFilter = ref(props.filters?.status || "");
const memberTypeFilter = ref(props.filters?.member_type || "");
const residenceFilter = ref(props.filters?.residence_state || "");

const applyFilters = () => {
    router.get(
        "/admin/volunteers",
        {
            status: statusFilter.value || undefined,
            member_type: memberTypeFilter.value || undefined,
            residence_state: residenceFilter.value || undefined,
        },
        { preserveState: true, replace: true }
    );
};

watch([statusFilter, memberTypeFilter, residenceFilter], applyFilters);

const clearFilters = () => {
    statusFilter.value = "";
    memberTypeFilter.value = "";
    residenceFilter.value = "";
};

const exportUrl = () => {
    const params = new URLSearchParams();

    if (statusFilter.value) params.set("status", statusFilter.value);

    if (memberTypeFilter.value) {
        params.set("member_type", memberTypeFilter.value);
    }

    if (residenceFilter.value) {
        params.set("residence_state", residenceFilter.value);
    }

    const qs = params.toString();

    return "/admin/volunteers/export" + (qs ? `?${qs}` : "");
};

const openAppDetails = (app) => {
    activeAppDetail.value = app;
};

const closeAppDetails = () => {
    activeAppDetail.value = null;
};

const updateStatus = (id, newStatus) => {
    router.post(
        "/admin/volunteers/" + id + "/status",
        { status: newStatus },
        { onSuccess: () => closeAppDetails() }
    );
};

const deleteApplication = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف طلب التطوع هذا؟")) {
        router.delete("/admin/volunteers/" + id);
    }
};

const statusLabel = (status) => {
    if (status === "new") return "طلب جديد";
    if (status === "accepted") return "مقبول";
    return "مرفوض";
};

const memberTypeLabel = (type) => {
    return type === "member" ? "عضو" : "متطوع";
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-6 sm:mb-8">
            <div
                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
            >
                <div class="min-w-0">
                    <h2
                        class="text-xl sm:text-2xl font-bold leading-tight text-slate-800"
                    >
                        إدارة طلبات الانضمام للتطوع
                    </h2>
                    <p
                        class="mt-1.5 max-w-3xl text-sm leading-6 text-slate-500"
                    >
                        تصفح وقبول ملفات ومهارات المتقدمين للمساهمة في مبادرات
                        الجمعية.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:items-center gap-2.5 w-full lg:w-auto"
                >
                    <a
                        :href="exportUrl()"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700 active:scale-[0.99]"
                    >
                        <FileSpreadsheet class="h-4 w-4 shrink-0" />
                        <span>تصدير Excel</span>
                    </a>

                    <Link
                        href="/admin/volunteers/create"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-600 active:scale-[0.99]"
                    >
                        <Plus class="h-4 w-4 shrink-0" />
                        <span>إضافة متطوع جديد</span>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <section
            class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
        >
            <div
                class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h3 class="text-sm font-bold text-slate-800">
                        تصفية الطلبات
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">
                        اختر المعايير المناسبة لتضييق النتائج.
                    </p>
                </div>

                <button
                    @click="clearFilters"
                    type="button"
                    class="inline-flex min-h-10 items-center justify-center gap-1.5 self-start rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-500 sm:self-auto"
                >
                    <X class="h-3.5 w-3.5" />
                    <span>مسح الفلاتر</span>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                <div>
                    <label
                        class="mb-1.5 block text-xs font-semibold text-slate-500"
                    >
                        حالة الطلب
                    </label>
                    <select
                        v-model="statusFilter"
                        class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        <option value="">الكل</option>
                        <option value="new">جديد</option>
                        <option value="accepted">مقبول</option>
                        <option value="rejected">مرفوض</option>
                    </select>
                </div>

                <div>
                    <label
                        class="mb-1.5 block text-xs font-semibold text-slate-500"
                    >
                        التصنيف
                    </label>
                    <select
                        v-model="memberTypeFilter"
                        class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        <option value="">الكل</option>
                        <option value="member">عضو</option>
                        <option value="volunteer">متطوع</option>
                    </select>
                </div>

                <div class="sm:col-span-2 xl:col-span-1">
                    <label
                        class="mb-1.5 block text-xs font-semibold text-slate-500"
                    >
                        مكان الإقامة
                    </label>
                    <select
                        v-model="residenceFilter"
                        class="min-h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                    >
                        <option value="">الكل</option>
                        <option
                            v-for="state in residenceStates"
                            :key="state"
                            :value="state"
                        >
                            {{ state }}
                        </option>
                    </select>
                </div>
            </div>
        </section>

        <!-- Mobile list -->
        <section class="space-y-3 lg:hidden">
            <template v-if="applications.length">
                <article
                    v-for="app in applications"
                    :key="app.id"
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <div class="border-b border-slate-100 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3
                                    class="truncate text-base font-bold text-slate-900"
                                >
                                    {{ app.full_name }}
                                </h3>
                                <p
                                    class="mt-1 text-xs font-medium text-slate-400"
                                >
                                    {{ app.specialization || "تخصص غير محدد" }}
                                </p>
                            </div>

                            <span
                                class="inline-flex shrink-0 rounded-full px-2.5 py-1 text-[11px] font-bold"
                                :class="
                                    app.member_type === 'member'
                                        ? 'bg-purple-100 text-purple-800'
                                        : 'bg-slate-100 text-slate-700'
                                "
                            >
                                {{ memberTypeLabel(app.member_type) }}
                            </span>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-2.5 py-1.5 text-[11px] text-slate-500"
                            >
                                <MapPin class="h-3.5 w-3.5" />
                                {{ app.residence_state || "غير محدد" }}
                            </span>

                            <span
                                class="inline-flex rounded-full px-2.5 py-1.5 text-[11px] font-bold"
                                :class="{
                                    'bg-blue-100 text-blue-800':
                                        app.status === 'new',
                                    'bg-emerald-100 text-emerald-800':
                                        app.status === 'accepted',
                                    'bg-red-100 text-red-800':
                                        app.status === 'rejected',
                                }"
                            >
                                {{ statusLabel(app.status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-2.5 p-4 text-xs">
                        <a
                            :href="`tel:${app.phone}`"
                            class="flex min-h-10 items-center gap-2 rounded-xl bg-slate-50 px-3 text-slate-600 transition hover:bg-slate-100"
                        >
                            <Phone class="h-4 w-4 shrink-0 text-slate-400" />
                            <span class="font-mono" dir="ltr">
                                {{ app.phone || "لا يوجد رقم" }}
                            </span>
                        </a>

                        <a
                            v-if="app.whatsapp"
                            :href="`https://wa.me/${String(
                                app.whatsapp
                            ).replace(/\D/g, '')}`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex min-h-10 items-center gap-2 rounded-xl bg-emerald-50 px-3 text-emerald-700 transition hover:bg-emerald-100"
                        >
                            <MessageCircle class="h-4 w-4 shrink-0" />
                            <span class="truncate" dir="ltr">
                                {{ app.whatsapp }}
                            </span>
                        </a>

                        <a
                            v-if="app.email"
                            :href="`mailto:${app.email}`"
                            class="flex min-h-10 items-center gap-2 rounded-xl bg-slate-50 px-3 text-slate-600 transition hover:bg-slate-100"
                        >
                            <Mail class="h-4 w-4 shrink-0 text-slate-400" />
                            <span class="truncate" dir="ltr">
                                {{ app.email }}
                            </span>
                        </a>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-2 border-t border-slate-100 bg-slate-50/70 p-3"
                    >
                        <button
                            @click="openAppDetails(app)"
                            type="button"
                            class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-white px-3 text-xs font-bold text-slate-600 ring-1 ring-slate-200 transition hover:text-orange-500"
                        >
                            <Eye class="h-4 w-4" />
                            مراجعة
                        </button>

                        <button
                            @click="deleteApplication(app.id)"
                            type="button"
                            class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-white px-3 text-xs font-bold text-red-500 ring-1 ring-slate-200 transition hover:bg-red-50"
                        >
                            <Trash2 class="h-4 w-4" />
                            حذف
                        </button>
                    </div>
                </article>
            </template>

            <div
                v-else
                class="rounded-2xl border border-dashed border-slate-200 bg-white px-5 py-12 text-center text-sm text-slate-400"
            >
                لا توجد طلبات تطوع مطابقة لهذا الفلتر.
            </div>
        </section>

        <!-- Desktop table -->
        <section
            class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:block"
        >
            <div class="overflow-x-auto">
                <table class="w-full min-w-[950px] border-collapse text-right">
                    <thead>
                        <tr
                            class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-600"
                        >
                            <th class="px-6 py-4">المتطوع والمؤهل</th>
                            <th class="px-6 py-4">بيانات الاتصال</th>
                            <th class="px-6 py-4">مكان الإقامة</th>
                            <th class="px-6 py-4">تخصص المساهمة</th>
                            <th class="px-6 py-4 text-center">التصنيف</th>
                            <th class="px-6 py-4 text-center">حالة الطلب</th>
                            <th class="px-6 py-4 text-center">مراجعة</th>
                        </tr>
                    </thead>

                    <tbody
                        class="divide-y divide-slate-100 text-sm text-slate-700"
                    >
                        <tr
                            v-for="app in applications"
                            :key="app.id"
                            class="transition hover:bg-slate-50/70"
                        >
                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ app.full_name }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="block font-mono text-xs" dir="ltr">
                                    {{ app.phone }}
                                </span>
                                <span
                                    class="mt-0.5 block text-[10px] text-slate-400"
                                >
                                    واتساب: {{ app.whatsapp }}
                                </span>
                                <span
                                    class="mt-0.5 block break-all text-[10px] text-slate-400"
                                    dir="ltr"
                                >
                                    {{ app.email }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ app.residence_state }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-600">
                                {{ app.specialization || "—" }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-block rounded-full px-3 py-1 text-xs font-bold"
                                    :class="
                                        app.member_type === 'member'
                                            ? 'bg-purple-100 text-purple-800'
                                            : 'bg-slate-100 text-slate-700'
                                    "
                                >
                                    {{ memberTypeLabel(app.member_type) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-block rounded-full px-3 py-1 text-xs font-bold"
                                    :class="{
                                        'bg-blue-100 text-blue-800':
                                            app.status === 'new',
                                        'bg-emerald-100 text-emerald-800':
                                            app.status === 'accepted',
                                        'bg-red-100 text-red-800':
                                            app.status === 'rejected',
                                    }"
                                >
                                    {{ statusLabel(app.status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-center gap-2"
                                >
                                    <button
                                        @click="openAppDetails(app)"
                                        type="button"
                                        title="مراجعة"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-orange-500"
                                    >
                                        <Eye class="h-4 w-4" />
                                    </button>

                                    <button
                                        @click="deleteApplication(app.id)"
                                        type="button"
                                        title="حذف"
                                        class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-500"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="applications.length === 0">
                            <td
                                colspan="7"
                                class="py-12 text-center text-sm text-slate-400"
                            >
                                لا توجد طلبات تطوع مطابقة لهذا الفلتر.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Application Auditing Modal -->
        <div
            v-if="activeAppDetail"
            class="fixed inset-0 z-50 flex items-end justify-center sm:items-center sm:p-4"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px]"
                @click="closeAppDetails"
            ></div>

            <div
                class="relative z-10 flex max-h-[92vh] w-full flex-col overflow-hidden rounded-t-2xl bg-white shadow-2xl sm:max-w-lg sm:rounded-2xl"
                dir="rtl"
            >
                <div
                    class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-100 bg-slate-50 px-4 py-4 sm:px-6"
                >
                    <div>
                        <h3
                            class="text-base font-bold text-slate-800 sm:text-lg"
                        >
                            تفاصيل ومهارات المتطوع
                        </h3>
                        <p class="mt-0.5 text-xs text-slate-400">
                            مراجعة بيانات طلب الانضمام.
                        </p>
                    </div>

                    <button
                        @click="closeAppDetails"
                        type="button"
                        aria-label="إغلاق"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-200 hover:text-slate-700"
                    >
                        <X class="h-5 w-5" />
                    </button>
                </div>

                <div class="overflow-y-auto p-4 sm:p-6">
                    <div
                        class="grid grid-cols-1 gap-4 border-b border-slate-100 pb-4 sm:grid-cols-2"
                    >
                        <div>
                            <span
                                class="mb-0.5 block text-[11px] text-slate-400"
                            >
                                اسم المتقدم
                            </span>
                            <strong class="text-sm text-slate-700">
                                {{ activeAppDetail.full_name }}
                            </strong>
                        </div>

                        <div>
                            <span
                                class="mb-0.5 block text-[11px] text-slate-400"
                            >
                                الهاتف
                            </span>
                            <strong
                                class="text-sm font-mono text-slate-700"
                                dir="ltr"
                            >
                                {{ activeAppDetail.phone }}
                            </strong>
                        </div>

                        <div>
                            <span
                                class="mb-0.5 block text-[11px] text-slate-400"
                            >
                                الواتساب
                            </span>
                            <strong
                                class="text-sm font-mono text-slate-700"
                                dir="ltr"
                            >
                                {{ activeAppDetail.whatsapp }}
                            </strong>
                        </div>

                        <div>
                            <span
                                class="mb-0.5 block text-[11px] text-slate-400"
                            >
                                مكان الإقامة
                            </span>
                            <strong class="text-sm text-slate-700">
                                {{ activeAppDetail.residence_state }}
                            </strong>
                        </div>

                        <div>
                            <span
                                class="mb-0.5 block text-[11px] text-slate-400"
                            >
                                التخصص المطلوب
                            </span>
                            <strong class="text-sm text-slate-700">
                                {{
                                    activeAppDetail.specialization || "غير محدد"
                                }}
                            </strong>
                        </div>

                        <div>
                            <span
                                class="mb-0.5 block text-[11px] text-slate-400"
                            >
                                التصنيف
                            </span>
                            <strong class="text-sm text-slate-700">
                                {{
                                    memberTypeLabel(activeAppDetail.member_type)
                                }}
                            </strong>
                        </div>
                    </div>

                    <div class="pt-4">
                        <span class="mb-1.5 block text-[11px] text-slate-400">
                            الخبرة والأعمال الإنسانية السابقة
                        </span>

                        <div
                            class="min-h-[110px] rounded-xl border border-slate-200 bg-slate-50 p-3 text-xs leading-6 text-slate-600"
                        >
                            {{
                                activeAppDetail.message_or_skills ||
                                "لا يوجد رسالة أو تفاصيل مهارات مرفقة."
                            }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-2 pt-5 sm:grid-cols-2">
                        <button
                            @click="
                                updateStatus(activeAppDetail.id, 'rejected')
                            "
                            type="button"
                            class="min-h-11 rounded-xl border border-red-200 px-4 py-2.5 text-xs font-bold text-red-600 transition hover:bg-red-50"
                        >
                            رفض الطلب
                        </button>

                        <button
                            @click="
                                updateStatus(activeAppDetail.id, 'accepted')
                            "
                            type="button"
                            class="min-h-11 rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-emerald-600"
                        >
                            قبول كمتطوع معتمد
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
