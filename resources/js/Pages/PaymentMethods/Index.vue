<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({ methods: Array });

const deleteMethod = (id) => {
    if (confirm("هل أنت متأكد من حذف وسيلة التبرع هذه بالكامل؟")) {
        router.delete("/admin/payment-methods/" + id);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
        >
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    الحسابات المصرفية ومنافذ التبرع المعتمدة
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تعديل الحسابات البنكية للمنظمة والتعليمات المصاحبة لإجراء
                    التحويل المالي.
                </p>
            </div>
            <Link
                href="/admin/payment-methods/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة منفذ تبرع جديد</span>
            </Link>
        </div>

        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"
        >
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider"
                    >
                        <th class="py-4 px-6">المنفذ / البنك</th>
                        <th class="py-4 px-6">رقم الحساب أو المحفظة</th>
                        <th class="py-4 px-6">اسم صاحب الحساب</th>
                        <th class="py-4 px-6">ترتيب العرض</th>
                        <th class="py-4 px-6 text-center">الحالة</th>
                        <th class="py-4 px-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-sm text-slate-700">
                    <tr
                        v-for="met in methods"
                        :key="met.id"
                        class="hover:bg-slate-50/50"
                    >
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <img
                                    v-if="met.icon_url"
                                    :src="met.icon_url"
                                    class="w-8 h-8 rounded-lg object-contain bg-slate-50 border border-slate-100"
                                />
                                <span class="font-bold text-slate-900">{{
                                    met.method_name_ar
                                }}</span>
                            </div>
                        </td>
                        <td
                            class="py-4 px-6 font-mono font-bold text-slate-700 text-sm"
                        >
                            {{ met.account_number || "بدون رقم حساب" }}
                        </td>
                        <td class="py-4 px-6 text-slate-600 font-semibold">
                            {{ met.account_name || "بدون اسم" }}
                        </td>
                        <td class="py-4 px-6 font-mono">
                            {{ met.display_order }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span
                                class="inline-block w-2.5 h-2.5 rounded-full"
                                :class="
                                    met.is_active
                                        ? 'bg-emerald-500'
                                        : 'bg-red-400'
                                "
                            ></span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-3">
                                <Link
                                    :href="
                                        '/admin/payment-methods/' +
                                        met.id +
                                        '/edit'
                                    "
                                    class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                                >
                                    <Edit2 class="w-4 h-4" />
                                </Link>
                                <button
                                    @click="deleteMethod(met.id)"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50/50 rounded-lg transition cursor-pointer"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="methods.length === 0">
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            لا توجد قنوات أو منافذ دفع معرفة حالياً.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
