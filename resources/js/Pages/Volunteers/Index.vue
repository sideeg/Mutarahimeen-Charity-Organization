<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Eye, Trash2, Plus, FileSpreadsheet } from "lucide-vue-next";

defineProps({
    applications: Array,
});

const activeAppDetail = ref(null);

const openAppDetails = (app) => {
    activeAppDetail.value = app;
};

const closeAppDetails = () => {
    activeAppDetail.value = null;
};

const updateStatus = (id, newStatus) => {
    router.post(
        "/admin/volunteers/" + id + "/status",
        {
            status: newStatus,
        },
        {
            onSuccess: () => closeAppDetails(),
        }
    );
};

const deleteApplication = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف طلب التطوع هذا؟")) {
        router.delete("/admin/volunteers/" + id);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <!-- Header Actions Layout -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
        >
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    إدارة طلبات الانضمام للتطوع
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تصفح وقبول ملفات ومهارات المتقدمين للمساهمة في مبادرات
                    الجمعية.
                </p>
            </div>
            <div class="flex items-center gap-3 self-start">
                <a
                    href="/admin/volunteers/export"
                    class="flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg font-bold text-sm hover:bg-emerald-700 transition shadow-sm cursor-pointer"
                >
                    <FileSpreadsheet class="w-4 h-4" />
                    <span>تصدير Excel</span>
                </a>
                <Link
                    href="/admin/volunteers/create"
                    class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition shadow-sm cursor-pointer"
                >
                    <Plus class="w-4 h-4" />
                    <span>إضافة متطوع جديد</span>
                </Link>
            </div>
        </div>

        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"
        >
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider"
                    >
                        <th class="py-4 px-6">المتطوع والمؤهل</th>
                        <th class="py-4 px-6">بيانات الاتصال</th>
                        <th class="py-4 px-6">مكان الإقامة</th>
                        <th class="py-4 px-6">تخصص المساهمة</th>
                        <th class="py-4 px-6 text-center">حالة الطلب</th>
                        <th class="py-4 px-6 text-center">مراجعة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-sm text-slate-700">
                    <tr
                        v-for="app in applications"
                        :key="app.id"
                        class="hover:bg-slate-50/50"
                    >
                        <td class="py-4 px-6 font-bold text-slate-900">
                            {{ app.full_name }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="block font-mono text-xs">{{
                                app.phone
                            }}</span>
                            <span
                                class="block text-[10px] text-slate-400 mt-0.5"
                                >واتساب: {{ app.whatsapp }}</span
                            >
                            <span
                                class="block text-[10px] text-slate-400 mt-0.5"
                                >{{ app.email }}</span
                            >
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ app.residence_state }}
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-600">
                            {{ app.specialization || "—" }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-bold"
                                :class="{
                                    'bg-blue-100 text-blue-800':
                                        app.status === 'new',
                                    'bg-emerald-100 text-emerald-800':
                                        app.status === 'accepted',
                                    'bg-red-100 text-red-800':
                                        app.status === 'rejected',
                                }"
                            >
                                {{
                                    app.status === "new"
                                        ? "طلب جديد"
                                        : app.status === "accepted"
                                        ? "مقبول"
                                        : "مرفوض"
                                }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    @click="openAppDetails(app)"
                                    class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition cursor-pointer"
                                >
                                    <Eye class="w-4 h-4" />
                                </button>
                                <button
                                    @click="deleteApplication(app.id)"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50/50 rounded-lg transition cursor-pointer"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="applications.length === 0">
                        <td colspan="5" class="py-8 text-center text-slate-400">
                            لا توجد طلبات تطوع واردة حتى الآن.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Application Auditing Modal -->
        <div
            v-if="activeAppDetail"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                class="fixed inset-0 bg-slate-900/60"
                @click="closeAppDetails"
            ></div>
            <div
                class="bg-white rounded-xl shadow-xl max-w-lg w-full relative z-10 overflow-hidden"
                dir="rtl"
            >
                <div class="p-6 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-800 text-lg">
                        تفاصيل ومهارات المتطوع
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div
                        class="grid grid-cols-2 gap-4 text-xs border-b border-slate-100 pb-4"
                    >
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >اسم المتقدم</span
                            >
                            <strong class="text-slate-700 text-sm">{{
                                activeAppDetail.full_name
                            }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >الهاتف</span
                            >
                            <strong class="text-slate-700 text-sm font-mono">{{
                                activeAppDetail.phone
                            }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >التخصص المطلوب</span
                            >
                            <strong class="text-slate-700 text-sm">{{
                                activeAppDetail.specialization || "غير محدد"
                            }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >مكان الإقامة</span
                            >
                            <strong class="text-slate-700 text-sm">{{
                                activeAppDetail.residence_state
                            }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >الواتساب</span
                            >
                            <strong class="text-slate-700 text-sm font-mono">{{
                                activeAppDetail.whatsapp
                            }}</strong>
                        </div>
                    </div>

                    <div>
                        <span class="text-slate-400 text-xs block mb-1"
                            >الخبرة والأعمال الإنسانية السابقة</span
                        >
                        <div
                            class="p-3 bg-slate-50 rounded-lg border border-slate-150 text-xs text-slate-600 min-h-[96px]"
                        >
                            {{
                                activeAppDetail.message_or_skills ||
                                "لا يوجد رسالة أو تفاصيل مهارات مرفقة."
                            }}
                        </div>
                    </div>

                    <div
                        class="flex justify-end gap-3 pt-4 border-t border-slate-100"
                    >
                        <button
                            @click="
                                updateStatus(activeAppDetail.id, 'rejected')
                            "
                            class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-xs hover:bg-red-50 transition font-bold cursor-pointer"
                        >
                            رفض الطلب
                        </button>
                        <button
                            @click="
                                updateStatus(activeAppDetail.id, 'accepted')
                            "
                            class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold transition cursor-pointer"
                        >
                            قبول كمتطوع معتمد
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
